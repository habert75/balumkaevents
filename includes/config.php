<?php
/**
 * BALUMUKA EVENTS - Database Configuration
 * 
 * IMPORTANT: Update these settings with your database credentials
 */

// Prevent direct access
if (!defined('BALUMKA_ACCESS')) {
    die('Direct access not permitted');
}

// Database Configuration
define('DB_HOST', 'localhost');           // Database host (usually localhost)
define('DB_NAME', 'balumka_events');      // Database name
define('DB_USER', 'root');                // Database username
define('DB_PASS', '');                    // Database password (empty for XAMPP default)
define('DB_CHARSET', 'utf8mb4');

// Site Configuration
define('SITE_NAME', 'BALUMUKA EVENTS');
define('SITE_URL', 'http://localhost/balumkaevents');
define('ADMIN_EMAIL', 'admin@balumkaevents.com');

// File Upload Configuration
define('UPLOAD_DIR', dirname(__DIR__) . '/uploads/events/');
define('UPLOAD_URL', SITE_URL . '/uploads/events/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp']);

// Session Configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Set to 1 if using HTTPS
session_name('BALUMKA_SESSION');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Timezone
date_default_timezone_set('Europe/Prague');

// Error Reporting (Set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database Connection
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage() . 
        "<br><br>Please ensure MySQL is running and database credentials are correct in includes/config.php");
}

/**
 * Get database connection
 */
function getDB() {
    global $pdo;
    return $pdo;
}
