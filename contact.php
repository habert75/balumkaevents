<?php
$template = file_get_contents(__DIR__ . '/mockup/contact.html');

echo str_replace(
    ['href="styles.css"', 'href="index.html"', 'href="events.html"', 'href="about.html"', 'href="guestlist.html"', 'href="contact.html"', 'src="script.js"'],
    ['href="mockup/styles.css"', 'href="index.php"', 'href="events.php"', 'href="about.php"', 'href="guestlist.php"', 'href="contact.php"', 'src="mockup/script.js"'],
    $template
);