<?php
/**
 * BALUMUKA EVENTS - Events Listing
 */
define('BALUMKA_ACCESS', true);
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Get all upcoming events
$events = getEvents(['status' => 'upcoming', 'order_by' => 'date', 'order_dir' => 'ASC']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events - BALUMUKA EVENTS</title>
    <link rel="stylesheet" href="mockup/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;900&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="container nav-container">
            <div class="logo">
                <a href="index.php">BALUMUKA<span class="logo-accent">EVENTS</span></a>
            </div>
            <div class="nav-toggle" id="navToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <ul class="nav-menu" id="navMenu">
                <li><a href="index.php">HOME</a></li>
                <li><a href="events.php" class="active">EVENTS</a></li>
                <li><a href="about.php">ABOUT US</a></li>
                <li><a href="guestlist.php" class="btn-highlight">GUEST LIST / TICKETS</a></li>
                <li><a href="contact.php">CONTACT</a></li>
            </ul>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="page-header-overlay"></div>
        <div class="container">
            <h1 class="page-title">OUR EVENTS</h1>
            <p class="page-subtitle">Experience African Culture Through Music & Dance</p>
        </div>
    </section>

    <!-- Events Filter -->
    <section class="events-filter">
        <div class="container">
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">ALL EVENTS</button>
                <button class="filter-btn" data-filter="upcoming">UPCOMING</button>
                <button class="filter-btn" data-filter="parties">PARTIES</button>
                <button class="filter-btn" data-filter="festivals">FESTIVALS</button>
                <button class="filter-btn" data-filter="workshops">WORKSHOPS</button>
            </div>
        </div>
    </section>

    <!-- Events Grid -->
    <section class="events-listing">
        <div class="container">
            <div class="events-grid">
                <?php if (empty($events)): ?>
                    <p style="text-align: center; color: #999; padding: 60px 20px; grid-column: 1 / -1;">
                        No upcoming events at the moment. Check back soon for exciting new events!
                    </p>
                <?php else: ?>
                    <?php foreach ($events as $event): 
                        $dateInfo = formatEventDate($event['date']);
                        $tagText = '';
                        $tagClass = '';
                        
                        if ($event['hot_tag']) {
                            $tagText = 'HOT';
                            $tagClass = 'hot';
                        } elseif ($event['featured']) {
                            $tagText = 'FEATURED';
                        } elseif ($event['category'] === 'festivals') {
                            $tagText = 'FESTIVAL';
                            $tagClass = 'festival';
                        } elseif ($event['category'] === 'workshops') {
                            $tagText = 'WORKSHOP';
                        }
                        
                        $cardClass = ($event['category'] === 'festivals' && $event['featured']) ? 'featured-large' : '';
                        $categoryClass = strtolower($event['category']);
                    ?>
                        <!-- Event Card -->
                        <div class="event-card <?= $cardClass ?>" data-category="upcoming <?= $categoryClass ?>">
                            <div class="event-image">
                                <?php if ($tagText): ?>
                                    <div class="event-tag <?= $tagClass ?>"><?= e($tagText) ?></div>
                                <?php endif; ?>
                                <?php if ($event['image']): ?>
                                    <img src="<?= getEventImageUrl($event['image']) ?>" alt="<?= e($event['title']) ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 15px;">
                                <?php else: ?>
                                    <div class="event-image-placeholder <?= generateSlug($event['title']) ?>"></div>
                                <?php endif; ?>
                            </div>
                            <div class="event-content">
                                <div class="event-date">
                                    <span class="date-day"><?= $dateInfo['day'] ?></span>
                                    <span class="date-month"><?= $dateInfo['month'] ?></span>
                                </div>
                                <div class="event-details">
                                    <h3 class="event-title"><?= e($event['title']) ?></h3>
                                    <div class="event-info">
                                        <span class="event-location">📍 <?= e($event['location']) ?></span>
                                        <?php if ($event['genre']): ?>
                                            <span class="event-genre">
                                                <?= $event['category'] === 'workshops' ? '💃' : '🎶' ?>
                                                <?= e($event['genre']) ?>
                                            </span>
                                        <?php endif; ?>
                                        <?php if (!empty($event['price_info'])): ?>
                                            <span class="event-price">💰 <?= e($event['price_info']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <p class="event-description"><?= e(substr($event['description'], 0, 120)) ?><?= strlen($event['description']) > 120 ? '...' : '' ?></p>
                                    <?php if ($event['ticket_link']): ?>
                                        <a href="<?= e($event['ticket_link']) ?>" class="btn btn-small" target="_blank">GET TICKETS</a>
                                    <?php else: ?>
                                        <a href="guestlist.php" class="btn btn-small">JOIN GUEST LIST</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>NEVER MISS AN EVENT</h2>
                <p>Join our guest list and get exclusive access to upcoming events</p>
                <a href="guestlist.php" class="btn btn-primary">JOIN GUEST LIST</a>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/includes/footer.php'; ?>

    <script src="mockup/script.js"></script>
</body>
</html>
