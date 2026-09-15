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
$host = $_SERVER['HTTP_HOST'] ?? '';
$isLocal = in_array($host, ['localhost', 'localhost:80', 'localhost:8080', '127.0.0.1', '127.0.0.1:80', '127.0.0.1:8080'], true);

define('DB_HOST', 'localhost');
define('DB_NAME', $isLocal ? 'balumka_events' : 'u472674549_balumka_db');
define('DB_USER', $isLocal ? 'root' : 'u472674549_balumka_user');
define('DB_PASS', $isLocal ? '' : 'BalumkaJmul2026');
define('DB_CHARSET', 'utf8mb4');

// Site Configuration
define('SITE_NAME', 'BALUMUKA EVENTS');
define('SITE_URL', $isLocal ? 'http://localhost/Balumkaevents' : 'https://balumukaevents.com');
define('ADMIN_EMAIL', 'admin@balumukaevents.com');

// File Upload Configuration
define('UPLOAD_DIR', dirname(__DIR__) . '/uploads/events/');
define('UPLOAD_URL', SITE_URL . '/uploads/events/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif']);

// Session Configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', $isLocal ? 0 : 1);
session_name('BALUMKA_SESSION');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Timezone
date_default_timezone_set('Europe/Prague');

// Error Reporting (Set to 0 in production)
error_reporting(0);
ini_set('display_errors', 0);

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
    error_log("Database Connection Failed: " . $e->getMessage());
    die("Database connection failed. Please try again later.");
}

/**
 * Get database connection
 */
function getDB() {
    global $pdo;
    return $pdo;
}
