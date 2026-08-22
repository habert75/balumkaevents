<?php
/**
 * BALUMUKA EVENTS - Add New Event
 */
define('BALUMKA_ACCESS', true);
require_once '../includes/config.php';
require_once '../includes/functions.php';

$pageTitle = 'Add New Event';

$errors = [];
$formData = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $formData = [
        'title' => sanitize($_POST['title'] ?? ''),
        'description' => sanitize($_POST['description'] ?? ''),
        'date' => sanitize($_POST['date'] ?? ''),
        'time' => sanitize($_POST['time'] ?? ''),
        'location' => sanitize($_POST['location'] ?? ''),
        'venue_address' => sanitize($_POST['venue_address'] ?? ''),
        'genre' => sanitize($_POST['genre'] ?? ''),
        'category' => sanitize($_POST['category'] ?? 'parties'),
        'price_info' => sanitize($_POST['price_info'] ?? ''),
        'ticket_link' => sanitize($_POST['ticket_link'] ?? ''),
        'capacity' => sanitize($_POST['capacity'] ?? ''),
        'status' => sanitize($_POST['status'] ?? 'upcoming'),
        'featured' => isset($_POST['featured']) ? 1 : 0,
        'hot_tag' => isset($_POST['hot_tag']) ? 1 : 0,
        'meta_keywords' => sanitize($_POST['meta_keywords'] ?? ''),
        'meta_description' => sanitize($_POST['meta_description'] ?? ''),
    ];
    
    // Validation
    if (empty($formData['title'])) $errors[] = 'Title is required';
    if (empty($formData['description'])) $errors[] = 'Description is required';
    if (empty($formData['date'])) $errors[] = 'Date is required';
    if (empty($formData['location'])) $errors[] = 'Location is required';
    
    // Generate slug
    $slug = generateSlug($formData['title']);
    
    // Handle image upload
    $image = null;
    if (!empty($_FILES['image']['name'])) {
        try {
            $image = uploadImage($_FILES['image']);
        } catch (Exception $e) {
            $errors[] = $e->getMessage();
        }
    }
    
    if (empty($errors)) {
        try {
            $db = getDB();
            $stmt = $db->prepare("
                INSERT INTO events (
                    title, slug, description, date, time, location, venue_address,
                    genre, category, image, price_info, ticket_link, capacity,
                    status, featured, hot_tag, meta_keywords, meta_description
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->execute([
                $formData['title'],
                $slug,
                $formData['description'],
                $formData['date'],
                $formData['time'],
                $formData['location'],
                $formData['venue_address'],
                $formData['genre'],
                $formData['category'],
                $image,
                $formData['price_info'],
                $formData['ticket_link'],
                $formData['capacity'] ?: null,
                $formData['status'],
                $formData['featured'],
                $formData['hot_tag'],
                $formData['meta_keywords'],
                $formData['meta_description']
            ]);
            
            redirect(SITE_URL . '/admin/events.php', 'Event added successfully!', 'success');
        } catch (PDOException $e) {
            $errors[] = 'Database error: ' . $e->getMessage();
        }
    }
}

include 'includes/header.php';
?>

<div class="top-bar">
    <div class="page-title-section">
        <h1>Add New Event</h1>
        <p>Create a new event for your calendar</p>
    </div>
    <div class="top-actions">
        <a href="events.php">← Back to Events</a>
    </div>
</div>

<?php if (!empty($errors)): ?>
    <div class="card" style="background: rgba(255, 0, 0, 0.1); border-color: rgba(255, 0, 0, 0.3);">
        <h2 style="color: #ff6b6b;">Errors</h2>
        <ul style="color: #ff6b6b;">
            <?php foreach ($errors as $error): ?>
                <li><?= e($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card">
    <form method="POST" action="" enctype="multipart/form-data">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
            <!-- Left Column -->
            <div>
                <div class="form-group">
                    <label for="title">Event Title *</label>
                    <input type="text" id="title" name="title" value="<?= e($formData['title'] ?? '') ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea id="description" name="description" rows="5" required><?= e($formData['description'] ?? '') ?></textarea>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group">
                        <label for="date">Date *</label>
                        <input type="date" id="date" name="date" value="<?= e($formData['date'] ?? '') ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="time">Time</label>
                        <input type="time" id="time" name="time" value="<?= e($formData['time'] ?? '') ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="location">Location *</label>
                    <input type="text" id="location" name="location" placeholder="e.g., Cross Club, Prague" value="<?= e($formData['location'] ?? '') ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="venue_address">Venue Address</label>
                    <input type="text" id="venue_address" name="venue_address" placeholder="e.g., Plynární 23, Prague 7" value="<?= e($formData['venue_address'] ?? '') ?>">
                </div>
                
                <div class="form-group">
                    <label for="genre">Genre/Music Type</label>
                    <input type="text" id="genre" name="genre" placeholder="e.g., Afrobeats • Amapiano" value="<?= e($formData['genre'] ?? '') ?>">
                </div>
            </div>
            
            <!-- Right Column -->
            <div>
                <div class="form-group">
                    <label for="category">Category *</label>
                    <select id="category" name="category" required>
                        <option value="parties" <?= ($formData['category'] ?? '') === 'parties' ? 'selected' : '' ?>>Parties</option>
                        <option value="festivals" <?= ($formData['category'] ?? '') === 'festivals' ? 'selected' : '' ?>>Festivals</option>
                        <option value="workshops" <?= ($formData['category'] ?? '') === 'workshops' ? 'selected' : '' ?>>Workshops</option>
                        <option value="other" <?= ($formData['category'] ?? '') === 'other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="upcoming" <?= ($formData['status'] ?? 'upcoming') === 'upcoming' ? 'selected' : '' ?>>Upcoming</option>
                        <option value="ongoing" <?= ($formData['status'] ?? '') === 'ongoing' ? 'selected' : '' ?>>Ongoing</option>
                        <option value="past" <?= ($formData['status'] ?? '') === 'past' ? 'selected' : '' ?>>Past</option>
                        <option value="cancelled" <?= ($formData['status'] ?? '') === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="image">Event Image</label>
                    <input type="file" id="image" name="image" accept="image/*">
                    <small style="color: #666; display: block; margin-top: 5px;">Max 5MB. Formats: JPG, PNG, GIF, WebP</small>
                </div>
                
                <div class="form-group">
                    <label for="price_info">Price Information</label>
                    <input type="text" id="price_info" name="price_info" placeholder="e.g., From 200 CZK" value="<?= e($formData['price_info'] ?? '') ?>">
                </div>
                
                <div class="form-group">
                    <label for="ticket_link">Ticket Link</label>
                    <input type="url" id="ticket_link" name="ticket_link" placeholder="https://..." value="<?= e($formData['ticket_link'] ?? '') ?>">
                </div>
                
                <div class="form-group">
                    <label for="capacity">Capacity (optional)</label>
                    <input type="number" id="capacity" name="capacity" placeholder="e.g., 500" value="<?= e($formData['capacity'] ?? '') ?>">
                </div>
                
                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                        <input type="checkbox" name="featured" value="1" <?= !empty($formData['featured']) ? 'checked' : '' ?>>
                        <span>Featured Event</span>
                    </label>
                </div>
                
                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                        <input type="checkbox" name="hot_tag" value="1" <?= !empty($formData['hot_tag']) ? 'checked' : '' ?>>
                        <span>Hot Tag (Trending)</span>
                    </label>
                </div>
            </div>
        </div>
        
        <!-- SEO Section -->
        <div style="border-top: 1px solid rgba(255, 255, 255, 0.1); padding-top: 30px; margin-top: 30px;">
            <h3 style="color: #FF6B35; margin-bottom: 20px;">SEO Settings (Optional)</h3>
            
            <div class="form-group">
                <label for="meta_keywords">Meta Keywords</label>
                <input type="text" id="meta_keywords" name="meta_keywords" placeholder="african events, prague nightlife, afrobeats" value="<?= e($formData['meta_keywords'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label for="meta_description">Meta Description</label>
                <textarea id="meta_description" name="meta_description" rows="3" placeholder="Brief description for search engines"><?= e($formData['meta_description'] ?? '') ?></textarea>
            </div>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <button type="submit" class="btn btn-primary" style="padding: 15px 50px;">Create Event</button>
            <a href="events.php" class="btn btn-secondary" style="padding: 15px 50px;">Cancel</a>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
