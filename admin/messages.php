<?php
/**
 * BALUMUKA EVENTS - Contact Messages
 */
define('BALUMKA_ACCESS', true);
require_once '../includes/config.php';
require_once '../includes/functions.php';

$pageTitle = 'Contact Messages';

// Get all messages
$db = getDB();
$messages = $db->query("SELECT * FROM contact_messages ORDER BY created_at DESC")->fetchAll();

include 'includes/header.php';
?>

<div class="top-bar">
    <div class="page-title-section">
        <h1>Contact Messages</h1>
        <p>View messages from your contact form</p>
    </div>
</div>

<div class="card">
    <h2>All Messages</h2>
    
    <?php if (empty($messages)): ?>
        <p style="color: #999; text-align: center; padding: 40px;">No messages yet.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $msg): ?>
                        <tr>
                            <td><?= e($msg['name']) ?></td>
                            <td><?= e($msg['email']) ?></td>
                            <td><?= e($msg['subject']) ?></td>
                            <td><?= substr(e($msg['message']), 0, 50) ?>...</td>
                            <td>
                                <?php
                                $statusClass = match($msg['status']) {
                                    'new' => 'badge-warning',
                                    'read' => 'badge-info',
                                    'replied' => 'badge-success',
                                    default => 'badge-info'
                                };
                                ?>
                                <span class="badge <?= $statusClass ?>"><?= e($msg['status']) ?></span>
                            </td>
                            <td><?= timeAgo($msg['created_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
