<?php
if (!defined('BALUMKA_ACCESS')) die('Direct access not permitted');
requireLogin();
$currentAdmin = getCurrentAdmin();
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Dashboard' ?> - BALUMUKA EVENTS Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            background: #0f0f0f;
            color: #fff;
            line-height: 1.6;
        }
        
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #1A1A1A 0%, #0A0A0A 100%);
            border-right: 1px solid rgba(255, 107, 53, 0.2);
            padding: 30px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        
        .sidebar-logo {
            padding: 0 30px 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-logo h1 {
            font-size: 24px;
            font-weight: 900;
            color: #fff;
            letter-spacing: 1px;
        }
        
        .sidebar-logo span {
            color: #FF6B35;
        }
        
        .sidebar-logo p {
            color: #999;
            font-size: 12px;
            margin-top: 5px;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
        }
        
        .sidebar-menu li {
            margin-bottom: 5px;
        }
        
        .sidebar-menu a {
            display: block;
            padding: 15px 30px;
            color: #999;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255, 107, 53, 0.1);
            color: #FF6B35;
            border-left-color: #FF6B35;
        }
        
        .sidebar-user {
            padding: 20px 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 20px;
        }
        
        .sidebar-user p {
            color: #666;
            font-size: 12px;
            margin-bottom: 5px;
        }
        
        .sidebar-user strong {
            color: #fff;
            font-size: 14px;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 30px;
        }
        
        .top-bar {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 20px 30px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .page-title-section h1 {
            font-size: 28px;
            font-weight: 900;
            color: #fff;
        }
        
        .page-title-section p {
            color: #999;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .top-actions a {
            display: inline-block;
            padding: 12px 25px;
            background: linear-gradient(135deg, #FF6B35 0%, #FFB627 100%);
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
        }
        
        .top-actions a:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.4);
        }
        
        /* Flash Messages */
        .flash-messages {
            margin-bottom: 30px;
        }
        
        .flash {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .flash.success {
            background: rgba(0, 255, 0, 0.1);
            border: 1px solid rgba(0, 255, 0, 0.3);
            color: #4ade80;
        }
        
        .flash.error {
            background: rgba(255, 0, 0, 0.1);
            border: 1px solid rgba(255, 0, 0, 0.3);
            color: #ff6b6b;
        }
        
        .flash.info {
            background: rgba(0, 150, 255, 0.1);
            border: 1px solid rgba(0, 150, 255, 0.3);
            color: #60a5fa;
        }
        
        /* Cards */
        .card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .card h2 {
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Table */
        .table-responsive {
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            background: rgba(255, 107, 53, 0.1);
            color: #FF6B35;
            padding: 15px;
            text-align: left;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
        }
        
        td {
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        tr:hover {
            background: rgba(255, 255, 255, 0.02);
        }
        
        /* Buttons */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #FF6B35 0%, #FFB627 100%);
            color: #fff;
        }
        
        .btn-success {
            background: #4ade80;
            color: #000;
        }
        
        .btn-danger {
            background: #ff6b6b;
            color: #fff;
        }
        
        .btn-secondary {
            background: #666;
            color: #fff;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        
        .btn-sm {
            padding: 8px 15px;
            font-size: 11px;
        }
        
        /* Form Elements */
        .form-group {
            margin-bottom: 25px;
        }
        
        label {
            display: block;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"],
        input[type="time"],
        input[type="url"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: #fff;
            font-size: 14px;
            font-family: 'Montserrat', sans-serif;
        }
        
        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #FF6B35;
            background: rgba(255, 255, 255, 0.1);
        }
        
        textarea {
            min-height: 120px;
            resize: vertical;
        }
        
        /* Badge */
        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .badge-success { background: #4ade80; color: #000; }
        .badge-warning { background: #FFB627; color: #000; }
        .badge-danger { background: #ff6b6b; color: #fff; }
        .badge-info { background: #60a5fa; color: #fff; }
        
        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 25px;
            text-align: center;
        }
        
        .stat-number {
            font-size: 36px;
            font-weight: 900;
            color: #FF6B35;
            margin-bottom: 10px;
        }
        
        .stat-label {
            color: #999;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <aside class="sidebar">
            <div class="sidebar-logo">
                <h1>BALUMUKA<span>EVENTS</span></h1>
                <p>Admin Panel</p>
            </div>
            
            <ul class="sidebar-menu">
                <li><a href="index.php" class="<?= $currentPage === 'index' ? 'active' : '' ?>">📊 Dashboard</a></li>
                <li><a href="events.php" class="<?= $currentPage === 'events' ? 'active' : '' ?>">🎉 Events</a></li>
                <li><a href="registrations.php" class="<?= $currentPage === 'registrations' ? 'active' : '' ?>">📝 Guest List</a></li>
                <li><a href="messages.php" class="<?= $currentPage === 'messages' ? 'active' : '' ?>">✉️ Messages</a></li>
                <li><a href="subscribers.php" class="<?= $currentPage === 'subscribers' ? 'active' : '' ?>">📧 Newsletter</a></li>
                <li><a href="settings.php" class="<?= $currentPage === 'settings' ? 'active' : '' ?>">⚙️ Settings</a></li>
                <li><a href="logout.php">🚪 Logout</a></li>
            </ul>
            
            <div class="sidebar-user">
                <p>Logged in as:</p>
                <strong><?= e($currentAdmin['full_name']) ?></strong>
            </div>
        </aside>
        
        <main class="main-content">
            <?php
            $flashMessages = getFlash();
            if (!empty($flashMessages)):
            ?>
            <div class="flash-messages">
                <?php foreach ($flashMessages as $flash): ?>
                    <div class="flash <?= e($flash['type']) ?>">
                        <?= e($flash['message']) ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
