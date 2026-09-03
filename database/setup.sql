-- =====================================================
-- BALUMUKA EVENTS - Database Setup
-- =====================================================
-- Run this file in phpMyAdmin against your already-created database
-- (do not create/switch database here - shared hosting users can't run CREATE DATABASE/USE)
-- =====================================================

-- =====================================================
-- Admin Users Table
-- =====================================================
CREATE TABLE IF NOT EXISTS admin_users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    INDEX idx_username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Events Table
-- =====================================================
CREATE TABLE IF NOT EXISTS events (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(250) NOT NULL UNIQUE,
    description TEXT NOT NULL,
    date DATE NOT NULL,
    time VARCHAR(50),
    location VARCHAR(200) NOT NULL,
    venue_address VARCHAR(255),
    genre VARCHAR(200),
    category ENUM('parties', 'festivals', 'workshops', 'other') DEFAULT 'parties',
    image VARCHAR(255),
    price_info VARCHAR(100),
    ticket_link VARCHAR(500),
    capacity INT(11),
    status ENUM('upcoming', 'ongoing', 'past', 'cancelled') DEFAULT 'upcoming',
    featured TINYINT(1) DEFAULT 0,
    hot_tag TINYINT(1) DEFAULT 0,
    meta_keywords VARCHAR(255),
    meta_description VARCHAR(500),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_date (date),
    INDEX idx_status (status),
    INDEX idx_category (category),
    INDEX idx_featured (featured),
    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Guest List / Registrations Table
-- =====================================================
CREATE TABLE IF NOT EXISTS registrations (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_id INT(11) UNSIGNED NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(50),
    ticket_type ENUM('regular', 'vip', 'group') DEFAULT 'regular',
    quantity INT(11) DEFAULT 1,
    total_price DECIMAL(10,2),
    payment_status ENUM('pending', 'paid', 'cancelled') DEFAULT 'pending',
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    confirmation_code VARCHAR(50) UNIQUE,
    notes TEXT,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    INDEX idx_event_id (event_id),
    INDEX idx_email (email),
    INDEX idx_confirmation (confirmation_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Newsletter Subscribers Table
-- =====================================================
CREATE TABLE IF NOT EXISTS newsletter_subscribers (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('active', 'unsubscribed') DEFAULT 'active',
    INDEX idx_email (email),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Contact Messages Table
-- =====================================================
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(200),
    message TEXT NOT NULL,
    phone VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('new', 'read', 'replied') DEFAULT 'new',
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Insert Default Admin User
-- =====================================================
-- Username: admin
-- Password: admin123 (CHANGE THIS IMMEDIATELY!)
INSERT INTO admin_users (username, password, email, full_name) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@balumkaevents.com', 'Administrator');

-- =====================================================
-- Insert Sample Events
-- =====================================================
INSERT INTO events (title, slug, description, date, time, location, venue_address, genre, category, image, price_info, status, featured, hot_tag) VALUES
('AFRO MEET-UP', 'afro-meet-up', 'Join us for an intimate evening of African rhythms, cocktails, and shisha in a cozy atmosphere. Connect with fellow African music lovers and experience the best of AfroHouse and AfroTech.', '2026-09-15', '20:00', 'Prague City Center', 'TBA', 'AfroHouse • AfroTech', 'parties', 'afro-meetup.jpg', 'From 200 CZK', 'upcoming', 1, 0),

('AFRORAVE', 'afrorave', 'The ultimate African music experience with international DJs and live performances. Dance all night to the hottest Afrobeats and Amapiano tracks in Prague''s most iconic venue.', '2026-09-22', '22:00', 'Cross Club, Prague', 'Plynární 23, Prague 7', 'Afrobeats • Amapiano', 'parties', 'afrorave.jpg', 'Early Bird: 250 CZK', 'upcoming', 1, 1),

('KIZOMBA BASICS', 'kizomba-basics', 'Learn the fundamentals of Kizomba dance with professional instructors. Perfect for beginners wanting to master this sensual and beautiful dance style.', '2026-09-18', '19:00', 'Dance Studio, Prague 2', 'Vinohradská 50, Prague 2', 'Dance Workshop', 'workshops', 'workshop.jpg', '300 CZK', 'upcoming', 0, 0),

('AFRO SUMMER NIGHT', 'afro-summer-night', 'Experience African music on the water! Cruise the Vltava River with us while enjoying the best Afrobeats and Dancehall music. Limited capacity!', '2026-09-29', '19:00', 'Boat Party, Vltava', 'Rašínovo nábřeží', 'Afrobeats • Dancehall', 'parties', 'party.jpg', 'VIP: 500 CZK', 'upcoming', 0, 0),

('ROOFTOP AFRO VIBES', 'rooftop-afro-vibes', 'Monthly rooftop party featuring the best African house music and sunset views. Enjoy cocktails, amazing music, and breathtaking views of Prague.', '2026-10-05', '18:00', 'Lucerna Music Bar', 'Vodičkova 36, Prague 1', 'AfroHouse • Deep House', 'parties', 'rooftop.jpg', 'Free Entry', 'upcoming', 0, 0),

('PRAGUE KIZOMBA FESTIVAL 2026', 'prague-kizomba-festival-2026', '5 Days of Dance, Culture, Fashion & Unforgettable Moments. International instructors, social dancing, parties, and cultural experiences. The biggest Kizomba event in Central Europe!', '2026-11-15', '10:00', 'Multiple Venues, Prague', 'Various locations across Prague', 'Dance • Workshops • Parties • Fashion', 'festivals', 'kizomba.jpg', 'Full Pass: 2500 CZK', 'upcoming', 1, 1);

-- =====================================================
-- Setup Complete!
-- =====================================================
-- Next Steps:
-- 1. Configure includes/config.php with your database credentials
-- 2. Create uploads/events/ directory with write permissions
-- 3. Login to admin panel with: admin / admin123
-- 4. CHANGE THE DEFAULT PASSWORD IMMEDIATELY!
-- =====================================================
