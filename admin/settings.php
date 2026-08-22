<?php
/**
 * BALUMUKA EVENTS - Settings
 */
define('BALUMKA_ACCESS', true);
require_once '../includes/config.php';
require_once '../includes/functions.php';

$pageTitle = 'Settings';

$currentAdmin = getCurrentAdmin();
$success = '';
$error = '';

// Handle password change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $error = 'All fields are required';
    } elseif ($newPassword !== $confirmPassword) {
        $error = 'New passwords do not match';
    } elseif (strlen($newPassword) < 6) {
        $error = 'New password must be at least 6 characters';
    } else {
        $db = getDB();
        $stmt = $db->prepare("SELECT password FROM admin_users WHERE id = ?");
        $stmt->execute([$_SESSION['admin_id']]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($currentPassword, $user['password'])) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $db->prepare("UPDATE admin_users SET password = ? WHERE id = ?");
            $stmt->execute([$hashedPassword, $_SESSION['admin_id']]);
            $success = 'Password changed successfully!';
        } else {
            $error = 'Current password is incorrect';
        }
    }
}

include 'includes/header.php';
?>

<div class="top-bar">
    <div class="page-title-section">
        <h1>Settings</h1>
        <p>Manage your admin account settings</p>
    </div>
</div>

<?php if ($success): ?>
    <div class="card" style="background: rgba(0, 255, 0, 0.1); border-color: rgba(0, 255, 0, 0.3);">
        <p style="color: #4ade80; margin: 0;">✓ <?= e($success) ?></p>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="card" style="background: rgba(255, 0, 0, 0.1); border-color: rgba(255, 0, 0, 0.3);">
        <p style="color: #ff6b6b; margin: 0;">✗ <?= e($error) ?></p>
    </div>
<?php endif; ?>

<div class="card">
    <h2>Account Information</h2>
    <div style="padding: 20px; background: rgba(255, 255, 255, 0.02); border-radius: 10px;">
        <p><strong>Username:</strong> <?= e($currentAdmin['username']) ?></p>
        <p><strong>Full Name:</strong> <?= e($currentAdmin['full_name']) ?></p>
        <p><strong>Email:</strong> <?= e($currentAdmin['email']) ?></p>
    </div>
</div>

<div class="card">
    <h2>Change Password</h2>
    <form method="POST" action="" style="max-width: 500px;">
        <div class="form-group">
            <label for="current_password">Current Password</label>
            <input type="password" id="current_password" name="current_password" required>
        </div>
        
        <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" id="new_password" name="new_password" required minlength="6">
            <small style="color: #666; display: block; margin-top: 5px;">Minimum 6 characters</small>
        </div>
        
        <div class="form-group">
            <label for="confirm_password">Confirm New Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        
        <button type="submit" name="change_password" class="btn btn-primary">Change Password</button>
    </form>
</div>

<div class="card">
    <h2>System Information</h2>
    <div style="padding: 20px; background: rgba(255, 255, 255, 0.02); border-radius: 10px;">
        <p><strong>Site URL:</strong> <?= SITE_URL ?></p>
        <p><strong>Database:</strong> <?= DB_NAME ?></p>
        <p><strong>Upload Directory:</strong> <?= UPLOAD_DIR ?></p>
        <p><strong>PHP Version:</strong> <?= phpversion() ?></p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
