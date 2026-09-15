<?php
/**
 * BALUMUKA EVENTS - Homepage
 */
define('BALUMKA_ACCESS', true);
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Get featured events for homepage
$featuredEvents = getEvents(['featured' => 1, 'status' => 'upcoming', 'limit' => 3, 'order_by' => 'date', 'order_dir' => 'ASC']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BALUMUKA EVENTS - African Music • Dance • Culture</title>
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
                <li><a href="index.php" class="active">HOME</a></li>
                <li><a href="events.php">EVENTS</a></li>
                <li><a href="about.php">ABOUT US</a></li>
                <li><a href="guestlist.php" class="btn-highlight">GUEST LIST / TICKETS</a></li>
                <li><a href="contact.php">CONTACT</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="hero-title">EXPERIENCE AFRICA.<br>LIVE THE CULTURE.</h1>
            <p class="hero-subtitle">African music, dance, nightlife and unforgettable experiences in Prague.</p>
            <div class="hero-buttons">
                <a href="events.php" class="btn btn-primary">UPCOMING EVENTS</a>
                <a href="guestlist.php" class="btn btn-secondary">JOIN GUEST LIST</a>
            </div>
        </div>
        <div class="scroll-indicator">
            <span>SCROLL</span>
            <div class="scroll-line"></div>
        </div>
    </section>

    <!-- Upcoming Events Section -->
    <section class="upcoming-events">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">UPCOMING EVENTS</h2>
                <p class="section-subtitle">Join us for unforgettable experiences</p>
            </div>

            <div class="events-grid">
                <?php if (empty($featuredEvents)): ?>
                    <p style="text-align: center; color: #999; grid-column: 1 / -1;">No upcoming events at the moment. Check back soon!</p>
                <?php else: ?>
                    <?php foreach ($featuredEvents as $index => $event): 
                        $dateInfo = formatEventDate($event['date']);
                        $tagText = $event['hot_tag'] ? 'HOT' : ($event['featured'] ? 'FEATURED' : '');
                        $tagClass = $event['hot_tag'] ? 'hot' : '';
                        $cardClass = ($event['category'] === 'festivals') ? 'featured-large' : '';
                        $delay = $index * 100;
                    ?>
                        <!-- Event Card -->
                        <div class="event-card <?= $cardClass ?>" data-aos="fade-up" data-aos-delay="<?= $delay ?>">
                            <div class="event-image">
                                <?php if ($tagText): ?>
                                    <div class="event-tag <?= $tagClass ?>"><?= e($tagText) ?></div>
                                <?php endif; ?>
                                <?php if ($event['image']): ?>
                                    <img src="<?= getEventImageUrl($event['image']) ?>" alt="<?= e($event['title']) ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 15px;">
                                <?php else: ?>
                                    <div class="event-image-placeholder <?= strtolower(str_replace(' ', '-', $event['title'])) ?>"></div>
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
                                            <span class="event-genre">🎶 <?= e($event['genre']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <p class="event-description"><?= e($event['description']) ?></p>
                                    <a href="guestlist.php" class="btn btn-small">
                                        <?= $event['category'] === 'festivals' ? 'GET YOUR PASS' : 'JOIN GUEST LIST' ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="section-footer">
                <a href="events.php" class="btn btn-outline">VIEW ALL EVENTS</a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-preview">
        <div class="container">
            <div class="about-grid">
                <div class="about-image" data-aos="fade-right">
                    <div class="about-image-placeholder"></div>
                </div>
                <div class="about-content" data-aos="fade-left">
                    <h2 class="section-title">ABOUT BALUMUKA</h2>
                    <p class="about-text">
                        Balumuka Events brings African music, dance and culture to life through unique events and experiences.
                    </p>
                    <p class="about-text">
                        From intimate meet-ups and nightlife parties to major festivals, we connect people through music, movement and culture.
                    </p>
                    <a href="about.php" class="btn btn-outline">LEARN MORE</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <div class="container">
            <div class="newsletter-content">
                <h2>STAY IN THE LOOP</h2>
                <p>Subscribe to our newsletter for event updates and exclusive offers</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="Your email address" required>
                    <button type="submit" class="btn btn-primary">SUBSCRIBE</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-section">
                    <h3 class="footer-logo">BALUMUKA<span>EVENTS</span></h3>
                    <p>African Music • Dance • Culture</p>
                    <div class="social-links">
                        <a href="#" class="social-link">📷 Instagram</a>
                        <a href="#" class="social-link">💬 WhatsApp</a>
                        <a href="#" class="social-link">📘 Facebook</a>
                    </div>
                </div>
                <div class="footer-section">
                    <h4>QUICK LINKS</h4>
                    <ul class="footer-links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="events.php">Events</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="guestlist.php">Guest List</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>CONTACT</h4>
                    <ul class="footer-contact">
                        <li>📧 info@balumukaevents.cz</li>
                        <li>📱 WhatsApp: +420 XXX XXX XXX</li>
                        <li>📍 Prague, Czech Republic</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> Balumuka Events. All rights reserved. | <a href="<?= SITE_URL ?>/admin/login.php" style="color: #666;">Admin</a></p>
            </div>
        </div>
    </footer>

    <script src="mockup/script.js"></script>
</body>
</html>
