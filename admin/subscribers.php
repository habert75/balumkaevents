<?php
/**
 * BALUMUKA EVENTS - Newsletter Subscribers
 */
define('BALUMKA_ACCESS', true);
require_once '../includes/config.php';
require_once '../includes/functions.php';

$pageTitle = 'Newsletter Subscribers';

// Get all subscribers
$db = getDB();
$subscribers = $db->query("SELECT * FROM newsletter_subscribers ORDER BY subscribed_at DESC")->fetchAll();

include 'includes/header.php';
?>

<div class="top-bar">
    <div class="page-title-section">
        <h1>Newsletter Subscribers</h1>
        <p>Manage your newsletter email list</p>
    </div>
</div>

<div class="card">
    <h2>All Subscribers (<?= count($subscribers) ?>)</h2>
    
    <?php if (empty($subscribers)): ?>
        <p style="color: #999; text-align: center; padding: 40px;">No subscribers yet.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Subscribed Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subscribers as $sub): ?>
                        <tr>
                            <td><?= e($sub['email']) ?></td>
                            <td>
                                <span class="badge <?= $sub['status'] === 'active' ? 'badge-success' : 'badge-secondary' ?>">
                                    <?= e($sub['status']) ?>
                                </span>
                            </td>
                            <td><?= formatDate($sub['subscribed_at'], 'M d, Y H:i') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
