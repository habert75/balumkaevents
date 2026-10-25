<?php
define('BALUMKA_ACCESS', true);
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

// Handle guest list form submission (AJAX, returns JSON)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $fullName = sanitize($_POST['fullname'] ?? '');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $phone = sanitize($_POST['phone'] ?? '');
    $eventId = (int)($_POST['event'] ?? 0);
    $guests = max(1, min(3, (int)($_POST['guests'] ?? 1))); // never trust the client, cap at 3
    $newsletter = isset($_POST['newsletter']);

    $errors = [];
    if ($fullName === '') $errors[] = 'Full name is required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'A valid email is required.';
    if ($phone === '') $errors[] = 'Phone number is required.';

    $event = $eventId > 0 ? getEvent($eventId) : null;
    if (!$event) $errors[] = 'Please select a valid event.';

    if (!empty($errors)) {
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit;
    }

    try {
        $db = getDB();
        $confirmationCode = generateConfirmationCode();

        $stmt = $db->prepare("INSERT INTO registrations (event_id, full_name, email, phone, ticket_type, quantity, payment_status, confirmation_code) VALUES (?, ?, ?, ?, 'regular', ?, 'pending', ?)");
        $stmt->execute([$eventId, $fullName, $email, $phone, $guests, $confirmationCode]);

        if ($newsletter) {
            $stmt = $db->prepare("INSERT INTO newsletter_subscribers (email, status) VALUES (?, 'active') ON DUPLICATE KEY UPDATE status = 'active'");
            $stmt->execute([$email]);
        }

        $mailSent = sendGuestListConfirmationEmail($email, $fullName, $event, $guests, $confirmationCode);

        $response = ['success' => true];
        // TEMP DEBUG: remove this block once email deliverability is diagnosed
        if (($_GET['debug'] ?? '') === 'balumka2026') {
            $response['debug'] = 'mail_sent=' . var_export($mailSent, true);
        }
        echo json_encode($response);
    } catch (Exception $e) {
        error_log('Guest list submission failed: ' . $e->getMessage());
        $response = ['success' => false, 'errors' => ['Something went wrong. Please try again later.']];
        // TEMP DEBUG: remove this block once the live insert issue is diagnosed
        if (($_GET['debug'] ?? '') === 'balumka2026') {
            $response['debug'] = $e->getMessage();
        }
        echo json_encode($response);
    }
    exit;
}

// Build the "Select Event" dropdown from live upcoming events
$upcomingEvents = getEvents(['status' => 'upcoming', 'order_by' => 'date', 'order_dir' => 'ASC']);
$eventOptionsHtml = '<option value="">Choose an event...</option>';
foreach ($upcomingEvents as $evt) {
    $label = $evt['title'] . ' - ' . formatDate($evt['date'], 'j F Y');
    $eventOptionsHtml .= '<option value="' . (int)$evt['id'] . '">' . e($label) . '</option>';
}

$template = file_get_contents(__DIR__ . '/mockup/guestlist.html');

$template = preg_replace(
    '/<select id="event" name="event" required>.*?<\/select>/s',
    '<select id="event" name="event" required>' . $eventOptionsHtml . '</select>',
    $template
);

$template = str_replace(
    ['href="styles.css"', 'href="index.html"', 'href="events.html"', 'href="about.html"', 'href="guestlist.html"', 'href="contact.html"', 'src="script.js"'],
    ['href="mockup/styles.css"', 'href="index.php"', 'href="events.php"', 'href="about.php"', 'href="guestlist.php"', 'href="contact.php"', 'src="mockup/script.js"'],
    $template
);

// Splice in the shared footer so this page stays in sync with the rest of the site
if (preg_match('/<!-- Footer -->.*?<\/footer>/s', $template, $footerMatch)) {
    ob_start();
    include __DIR__ . '/includes/footer.php';
    $template = str_replace($footerMatch[0], ob_get_clean(), $template);
}

echo $template;