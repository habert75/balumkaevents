<?php
/**
 * BALUMUKA EVENTS - Helper Functions
 */

if (!defined('BALUMKA_ACCESS')) {
    die('Direct access not permitted');
}

/**
 * Sanitize input data
 */
function sanitize($data) {
    if (is_array($data)) {
        return array_map('sanitize', $data);
    }
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

/**
 * Generate URL-friendly slug
 */
function generateSlug($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    return empty($text) ? 'event-' . time() : $text;
}

/**
 * Format date for display
 */
function formatDate($date, $format = 'M d, Y') {
    return date($format, strtotime($date));
}

/**
 * Format date for event cards (e.g., "15 SEP")
 */
function formatEventDate($date) {
    return [
        'day' => date('d', strtotime($date)),
        'month' => strtoupper(date('M', strtotime($date)))
    ];
}

/**
 * Get time ago string
 */
function timeAgo($datetime) {
    $time = strtotime($datetime);
    $diff = time() - $time;
    
    if ($diff < 60) return 'just now';
    if ($diff < 3600) return floor($diff / 60) . ' minutes ago';
    if ($diff < 86400) return floor($diff / 3600) . ' hours ago';
    if ($diff < 604800) return floor($diff / 86400) . ' days ago';
    
    return date('M d, Y', $time);
}

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['admin_id']) && isset($_SESSION['admin_username']);
}

/**
 * Require login (redirect if not logged in)
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ' . SITE_URL . '/admin/login.php');
        exit;
    }
}

/**
 * Get current admin user
 */
function getCurrentAdmin() {
    if (!isLoggedIn()) return null;
    
    $db = getDB();
    $stmt = $db->prepare("SELECT id, username, email, full_name FROM admin_users WHERE id = ?");
    $stmt->execute([$_SESSION['admin_id']]);
    return $stmt->fetch();
}

/**
 * Logout user
 */
function logout() {
    session_unset();
    session_destroy();
    header('Location: ' . SITE_URL . '/admin/login.php');
    exit;
}

/**
 * Flash message system
 */
function setFlash($type, $message) {
    $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
}

function getFlash() {
    if (!isset($_SESSION['flash'])) return [];
    $messages = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $messages;
}

/**
 * Redirect helper
 */
function redirect($url, $message = null, $type = 'success') {
    if ($message) setFlash($type, $message);
    header('Location: ' . $url);
    exit;
}

/**
 * Upload image file
 */
function uploadImage($file, $oldImage = null) {
    // Check if file was uploaded
    if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return $oldImage; // Keep old image if no new one uploaded
    }
    
    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $uploadErrors = [
            UPLOAD_ERR_INI_SIZE => 'The image exceeds the server upload_max_filesize limit (' . ini_get('upload_max_filesize') . ').',
            UPLOAD_ERR_FORM_SIZE => 'The image exceeds the maximum size allowed by the form.',
            UPLOAD_ERR_PARTIAL => 'The image was only partially uploaded. Please try again.',
            UPLOAD_ERR_NO_TMP_DIR => 'Server is missing a temporary folder for uploads.',
            UPLOAD_ERR_CANT_WRITE => 'Server failed to write the uploaded file to disk.',
            UPLOAD_ERR_EXTENSION => 'A server extension stopped the file upload.',
        ];
        throw new Exception($uploadErrors[$file['error']] ?? 'File upload error: ' . $file['error']);
    }
    
    // Check file size
    if ($file['size'] > MAX_FILE_SIZE) {
        throw new Exception('File size exceeds maximum allowed size of ' . (MAX_FILE_SIZE / 1024 / 1024) . 'MB');
    }
    
    // Get file extension
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    // Check file extension
    if (!in_array($extension, ALLOWED_EXTENSIONS)) {
        throw new Exception('Invalid file type. Allowed types: ' . implode(', ', ALLOWED_EXTENSIONS));
    }
    
    // Generate unique filename
    $filename = uniqid('event_') . '_' . time() . '.' . $extension;
    $targetPath = UPLOAD_DIR . $filename;
    
    // Create upload directory if it doesn't exist
    if (!file_exists(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0755, true);
    }
    
    // Move uploaded file
    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        throw new Exception('Failed to move uploaded file');
    }
    
    // Delete old image if exists
    if ($oldImage && file_exists(UPLOAD_DIR . $oldImage)) {
        unlink(UPLOAD_DIR . $oldImage);
    }
    
    return $filename;
}

/**
 * Delete image file
 */
function deleteImage($filename) {
    if ($filename && file_exists(UPLOAD_DIR . $filename)) {
        return unlink(UPLOAD_DIR . $filename);
    }
    return false;
}

/**
 * Get event image URL
 */
function getEventImageUrl($image) {
    if (empty($image)) {
        return SITE_URL . '/mockup/images/default-event.jpg';
    }
    return UPLOAD_URL . $image;
}

/**
 * Pagination helper
 */
function paginate($total, $perPage = 10, $page = 1) {
    $totalPages = ceil($total / $perPage);
    $page = max(1, min($page, $totalPages));
    $offset = ($page - 1) * $perPage;
    
    return [
        'total' => $total,
        'per_page' => $perPage,
        'current_page' => $page,
        'total_pages' => $totalPages,
        'offset' => $offset,
        'has_prev' => $page > 1,
        'has_next' => $page < $totalPages
    ];
}

/**
 * Get events with filters
 */
function getEvents($filters = []) {
    $db = getDB();
    
    $sql = "SELECT * FROM events WHERE 1=1";
    $params = [];
    
    // Filter by status
    if (!empty($filters['status'])) {
        $sql .= " AND status = ?";
        $params[] = $filters['status'];
    }
    
    // Filter by category
    if (!empty($filters['category'])) {
        $sql .= " AND category = ?";
        $params[] = $filters['category'];
    }
    
    // Filter by featured
    if (isset($filters['featured'])) {
        $sql .= " AND featured = ?";
        $params[] = $filters['featured'];
    }
    
    // Search by title
    if (!empty($filters['search'])) {
        $sql .= " AND (title LIKE ? OR description LIKE ?)";
        $search = '%' . $filters['search'] . '%';
        $params[] = $search;
        $params[] = $search;
    }
    
    // Order by
    $orderBy = $filters['order_by'] ?? 'date';
    $orderDir = $filters['order_dir'] ?? 'ASC';
    $sql .= " ORDER BY {$orderBy} {$orderDir}";
    
    // Limit
    if (isset($filters['limit'])) {
        $sql .= " LIMIT " . (int)$filters['limit'];
        if (isset($filters['offset'])) {
            $sql .= " OFFSET " . (int)$filters['offset'];
        }
    }
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

/**
 * Get single event
 */
function getEvent($id) {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

/**
 * Get event by slug
 */
function getEventBySlug($slug) {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM events WHERE slug = ?");
    $stmt->execute([$slug]);
    return $stmt->fetch();
}

/**
 * Count events
 */
function countEvents($filters = []) {
    $db = getDB();
    
    $sql = "SELECT COUNT(*) FROM events WHERE 1=1";
    $params = [];
    
    if (!empty($filters['status'])) {
        $sql .= " AND status = ?";
        $params[] = $filters['status'];
    }
    
    if (!empty($filters['category'])) {
        $sql .= " AND category = ?";
        $params[] = $filters['category'];
    }
    
    if (!empty($filters['search'])) {
        $sql .= " AND (title LIKE ? OR description LIKE ?)";
        $search = '%' . $filters['search'] . '%';
        $params[] = $search;
        $params[] = $search;
    }
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchColumn();
}

/**
 * Escape output for HTML
 */
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Check if date is in the future
 */
function isFutureDate($date) {
    return strtotime($date) > time();
}

/**
 * Generate a short unique confirmation code for a registration
 */
function generateConfirmationCode() {
    return strtoupper(bin2hex(random_bytes(4)));
}

/**
 * Send guest list confirmation email via PHP mail()
 * Note: on local XAMPP, mail() requires sendmail/SMTP to be configured to actually deliver.
 */
function sendGuestListConfirmationEmail($toEmail, $fullName, $event, $guests, $confirmationCode) {
    $eventTitle = $event['title'] ?? 'the event';
    $eventDate = !empty($event['date']) ? formatDate($event['date'], 'l, j F Y') : 'TBA';
    $eventTime = $event['time'] ?? 'TBA';
    $eventLocation = $event['location'] ?? 'TBA';

    $subject = "You're on the guest list - " . $eventTitle;

    $body = '<div style="font-family: Arial, sans-serif; color:#222; max-width:500px;">'
        . '<h2 style="color:#FF6B35;">You\'re on the list, ' . e($fullName) . '!</h2>'
        . '<p>Thanks for joining the guest list for <strong>' . e($eventTitle) . '</strong>.</p>'
        . '<table cellpadding="4" style="margin:15px 0;">'
        . '<tr><td><strong>Date:</strong></td><td>' . e($eventDate) . '</td></tr>'
        . '<tr><td><strong>Time:</strong></td><td>' . e($eventTime) . '</td></tr>'
        . '<tr><td><strong>Location:</strong></td><td>' . e($eventLocation) . '</td></tr>'
        . '<tr><td><strong>Guests:</strong></td><td>' . (int)$guests . '</td></tr>'
        . '<tr><td><strong>Confirmation code:</strong></td><td>' . e($confirmationCode) . '</td></tr>'
        . '</table>'
        . '<p>Please keep this email or your confirmation code handy for entry.</p>'
        . '<p>See you there!<br>' . e(SITE_NAME) . '</p>'
        . '</div>';

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "From: " . SITE_NAME . " <" . ADMIN_EMAIL . ">\r\n";
    $headers .= "Reply-To: " . ADMIN_EMAIL . "\r\n";

    $sent = @mail($toEmail, $subject, $body, $headers);
    if (!$sent) {
        error_log('sendGuestListConfirmationEmail: mail() returned false for ' . $toEmail);
    }
    return $sent;
}

/**
 * Auto-update event status based on date
 */
function updateEventStatus($eventId) {
    $db = getDB();
    $event = getEvent($eventId);
    
    if (!$event) return;
    
    $today = date('Y-m-d');
    $eventDate = $event['date'];
    
    if ($eventDate < $today && $event['status'] === 'upcoming') {
        $stmt = $db->prepare("UPDATE events SET status = 'past' WHERE id = ?");
        $stmt->execute([$eventId]);
    }
}
