<?php
$template = file_get_contents(__DIR__ . '/mockup/contact.html');

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