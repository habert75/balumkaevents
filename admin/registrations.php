<?php
/**
 * BALUMUKA EVENTS - Registrations/Guest List Management
 */
define('BALUMKA_ACCESS', true);
require_once '../includes/config.php';
require_once '../includes/functions.php';

$pageTitle = 'Guest List & Registrations';

// Get all registrations
$db = getDB();
$stmt = $db->query("
    SELECT r.*, e.title as event_title 
    FROM registrations r 
    LEFT JOIN events e ON r.event_id = e.id 
    ORDER BY r.registration_date DESC
");
$registrations = $stmt->fetchAll();

include 'includes/header.php';
?>

<div class="top-bar">
    <div class="page-title-section">
        <h1>Guest List & Registrations</h1>
        <p>Manage event registrations and guest lists</p>
    </div>
</div>

<div class="card">
    <h2>All Registrations</h2>
    
    <?php if (empty($registrations)): ?>
        <p style="color: #999; text-align: center; padding: 40px;">No registrations yet.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Event</th>
                        <th>Ticket Type</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($registrations as $reg): ?>
                        <tr>
                            <td><?= e($reg['full_name']) ?></td>
                            <td><?= e($reg['email']) ?></td>
                            <td><?= e($reg['phone']) ?></td>
                            <td><?= e($reg['event_title']) ?></td>
                            <td><span class="badge badge-info"><?= e($reg['ticket_type']) ?></span></td>
                            <td><?= e($reg['quantity']) ?></td>
                            <td>
                                <?php
                                $statusClass = match($reg['payment_status']) {
                                    'paid' => 'badge-success',
                                    'pending' => 'badge-warning',
                                    'cancelled' => 'badge-danger',
                                    default => 'badge-info'
                                };
                                ?>
                                <span class="badge <?= $statusClass ?>"><?= e($reg['payment_status']) ?></span>
                            </td>
                            <td><?= formatDate($reg['registration_date'], 'M d, Y H:i') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
