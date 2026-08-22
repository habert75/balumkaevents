<?php
/**
 * BALUMUKA EVENTS - Manage Events
 */
define('BALUMKA_ACCESS', true);
require_once '../includes/config.php';
require_once '../includes/functions.php';

$pageTitle = 'Manage Events';

// Handle search and filters
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$status = $_GET['status'] ?? '';

$filters = [];
if ($search) $filters['search'] = $search;
if ($category) $filters['category'] = $category;
if ($status) $filters['status'] = $status;
$filters['order_by'] = 'date';
$filters['order_dir'] = 'DESC';

$events = getEvents($filters);
$totalEvents = countEvents($filters);

include 'includes/header.php';
?>

<div class="top-bar">
    <div class="page-title-section">
        <h1>Manage Events</h1>
        <p>View, edit, and delete events</p>
    </div>
    <div class="top-actions">
        <a href="event-add.php">➕ Add New Event</a>
    </div>
</div>

<!-- Filters -->
<div class="card">
    <form method="GET" action="" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: end;">
        <div class="form-group" style="margin-bottom: 0;">
            <label for="search">Search</label>
            <input type="text" id="search" name="search" placeholder="Event title..." value="<?= e($search) ?>">
        </div>
        
        <div class="form-group" style="margin-bottom: 0;">
            <label for="category">Category</label>
            <select id="category" name="category">
                <option value="">All Categories</option>
                <option value="parties" <?= $category === 'parties' ? 'selected' : '' ?>>Parties</option>
                <option value="festivals" <?= $category === 'festivals' ? 'selected' : '' ?>>Festivals</option>
                <option value="workshops" <?= $category === 'workshops' ? 'selected' : '' ?>>Workshops</option>
                <option value="other" <?= $category === 'other' ? 'selected' : '' ?>>Other</option>
            </select>
        </div>
        
        <div class="form-group" style="margin-bottom: 0;">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="">All Status</option>
                <option value="upcoming" <?= $status === 'upcoming' ? 'selected' : '' ?>>Upcoming</option>
                <option value="ongoing" <?= $status === 'ongoing' ? 'selected' : '' ?>>Ongoing</option>
                <option value="past" <?= $status === 'past' ? 'selected' : '' ?>>Past</option>
                <option value="cancelled" <?= $status === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
            </select>
        </div>
        
        <div>
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="events.php" class="btn btn-secondary">Reset</a>
        </div>
    </form>
</div>

<!-- Events List -->
<div class="card">
    <h2>All Events (<?= $totalEvents ?>)</h2>
    
    <?php if (empty($events)): ?>
        <p style="color: #999; text-align: center; padding: 40px;">No events found. <a href="event-add.php" style="color: #FF6B35;">Add your first event</a></p>
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
                        <th>Tags</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($events as $event): ?>
                        <tr>
                            <td>
                                <strong><?= e($event['title']) ?></strong><br>
                                <small style="color: #666;"><?= substr(e($event['description']), 0, 60) ?>...</small>
                            </td>
                            <td><?= formatDate($event['date'], 'M d, Y') ?><br><small style="color: #666;"><?= e($event['time']) ?></small></td>
                            <td><?= e($event['location']) ?></td>
                            <td><span class="badge badge-info"><?= e($event['category']) ?></span></td>
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
                            <td>
                                <?php if ($event['featured']): ?>
                                    <span class="badge badge-warning">Featured</span>
                                <?php endif; ?>
                                <?php if ($event['hot_tag']): ?>
                                    <span class="badge badge-danger">Hot</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="event-edit.php?id=<?= $event['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                <a href="event-delete.php?id=<?= $event['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
