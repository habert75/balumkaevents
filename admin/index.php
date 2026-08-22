<?php
/**
 * BALUMUKA EVENTS - Admin Dashboard
 */
define('BALUMKA_ACCESS', true);
require_once '../includes/config.php';
require_once '../includes/functions.php';

$pageTitle = 'Dashboard';

// Get statistics
$db = getDB();

$totalEvents = $db->query("SELECT COUNT(*) FROM events")->fetchColumn();
$upcomingEvents = $db->query("SELECT COUNT(*) FROM events WHERE status = 'upcoming'")->fetchColumn();
$totalRegistrations = $db->query("SELECT COUNT(*) FROM registrations")->fetchColumn();
$newMessages = $db->query("SELECT COUNT(*) FROM contact_messages WHERE status = 'new'")->fetchColumn();
$subscribers = $db->query("SELECT COUNT(*) FROM newsletter_subscribers WHERE status = 'active'")->fetchColumn();

// Get recent events
$recentEvents = getEvents(['limit' => 5, 'order_by' => 'created_at', 'order_dir' => 'DESC']);

// Get upcoming events
$upcomingEventsList = getEvents(['status' => 'upcoming', 'limit' => 5, 'order_by' => 'date', 'order_dir' => 'ASC']);

include 'includes/header.php';
?>

<div class="top-bar">
    <div class="page-title-section">
        <h1>Dashboard</h1>
        <p>Welcome back! Here's what's happening with your events.</p>
    </div>
    <div class="top-actions">
        <a href="event-add.php">➕ Add New Event</a>
    </div>
</div>

<!-- Statistics -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number"><?= $totalEvents ?></div>
        <div class="stat-label">Total Events</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-number"><?= $upcomingEvents ?></div>
        <div class="stat-label">Upcoming Events</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-number"><?= $totalRegistrations ?></div>
        <div class="stat-label">Total Registrations</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-number"><?= $newMessages ?></div>
        <div class="stat-label">New Messages</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-number"><?= $subscribers ?></div>
        <div class="stat-label">Newsletter Subscribers</div>
    </div>
</div>

<!-- Upcoming Events -->
<div class="card">
    <h2>Upcoming Events</h2>
    <?php if (empty($upcomingEventsList)): ?>
        <p style="color: #999;">No upcoming events scheduled.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($upcomingEventsList as $event): ?>
                        <tr>
                            <td>
                                <strong><?= e($event['title']) ?></strong>
                                <?php if ($event['featured']): ?>
                                    <span class="badge badge-warning">Featured</span>
                                <?php endif; ?>
                            </td>
                            <td><?= formatDate($event['date']) ?></td>
                            <td><?= e($event['location']) ?></td>
                            <td><span class="badge badge-info"><?= e($event['category']) ?></span></td>
                            <td><span class="badge badge-success"><?= e($event['status']) ?></span></td>
                            <td>
                                <a href="event-edit.php?id=<?= $event['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div style="margin-top: 20px; text-align: center;">
            <a href="events.php" class="btn btn-secondary">View All Events</a>
        </div>
    <?php endif; ?>
</div>

<!-- Recently Added Events -->
<div class="card">
    <h2>Recently Added Events</h2>
    <?php if (empty($recentEvents)): ?>
        <p style="color: #999;">No events added yet.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentEvents as $event): ?>
                        <tr>
                            <td><strong><?= e($event['title']) ?></strong></td>
                            <td><?= formatDate($event['date']) ?></td>
                            <td>
                                <?php
                                $statusClass = match($event['status']) {
                                    'upcoming' => 'badge-success',
                                    'ongoing' => 'badge-info',
                                    'past' => 'badge-secondary',
                                    'cancelled' => 'badge-danger',
                                    default => 'badge-info'
                                };
                                ?>
                                <span class="badge <?= $statusClass ?>"><?= e($event['status']) ?></span>
                            </td>
                            <td><?= timeAgo($event['created_at']) ?></td>
                            <td>
                                <a href="event-edit.php?id=<?= $event['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
