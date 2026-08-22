# 🎉 BALUMUKA EVENTS - Complete Setup Guide

## 📋 Table of Contents
1. [Prerequisites](#prerequisites)
2. [Installation Steps](#installation-steps)
3. [Database Setup](#database-setup)
4. [Configuration](#configuration)
5. [First Login](#first-login)
6. [Adding Your First Event](#adding-your-first-event)
7. [Troubleshooting](#troubleshooting)
8. [Features Overview](#features-overview)

---

## ✅ Prerequisites

Before you begin, make sure you have:

- **XAMPP** installed and running (Apache + MySQL)
- Web browser (Chrome, Firefox, Edge, etc.)
- Basic understanding of file navigation

---

## 🚀 Installation Steps

### Step 1: Start XAMPP

1. Open **XAMPP Control Panel**
2. Start **Apache** (click "Start" button)
3. Start **MySQL** (click "Start" button)
4. Both should show green "Running" status

### Step 2: Verify Installation

Your project files are already in: `C:\xampp\htdocs\balumkaevents\`

### Step 3: Create Upload Directory

Create a folder for event images:
```
C:\xampp\htdocs\balumkaevents\uploads\events\
```

**Windows Instructions:**
1. Open File Explorer
2. Navigate to `C:\xampp\htdocs\balumkaevents\`
3. Right-click → New → Folder → Name it `uploads`
4. Open the `uploads` folder
5. Right-click → New → Folder → Name it `events`

---

## 🗄️ Database Setup

### Option 1: Using phpMyAdmin (Recommended for Beginners)

1. Open your web browser
2. Go to: `http://localhost/phpmyadmin`
3. Click **"New"** in the left sidebar
4. Database name: `balumka_events`
5. Collation: `utf8mb4_unicode_ci`
6. Click **"Create"**
7. Click on your new `balumka_events` database
8. Click **"Import"** tab
9. Click **"Choose File"**
10. Navigate to: `C:\xampp\htdocs\balumkaevents\database\setup.sql`
11. Click **"Go"** button at the bottom
12. You should see: ✅ "Import has been successfully finished"

### Option 2: Using MySQL Command Line

1. Open Command Prompt
2. Navigate to XAMPP:
```bash
cd C:\xampp\mysql\bin
```
3. Login to MySQL:
```bash
mysql -u root -p
```
(Press Enter when asked for password - default is no password)

4. Run the setup file:
```sql
source C:\xampp\htdocs\balumkaevents\database\setup.sql
```

### Verify Database Setup

Your database should now have these tables:
- ✅ `admin_users` (with default admin account)
- ✅ `events` (with 6 sample events)
- ✅ `registrations`
- ✅ `newsletter_subscribers`
- ✅ `contact_messages`

---

## ⚙️ Configuration

### Update Database Settings (if needed)

If you changed your MySQL settings, edit the config file:

**File:** `C:\xampp\htdocs\balumkaevents\includes\config.php`

```php
// Default XAMPP settings (usually no changes needed)
define('DB_HOST', 'localhost');
define('DB_NAME', 'balumka_events');
define('DB_USER', 'root');
define('DB_PASS', '');  // Empty for default XAMPP
```

### Verify Site URL

Check that this matches your setup:
```php
define('SITE_URL', 'http://localhost/balumkaevents');
```

---

## 🔐 First Login

### Access the Website

**Frontend (Public Site):**
```
http://localhost/balumkaevents/
```
or
```
http://localhost/balumkaevents/index.php
```

**Admin Panel:**
```
http://localhost/balumkaevents/admin/
```
or
```
http://localhost/balumkaevents/admin/login.php
```

### Default Admin Credentials

```
Username: admin
Password: admin123
```

⚠️ **IMPORTANT SECURITY NOTE:**
After first login, you should:
1. Go to **Settings** in the admin panel
2. Change the default password immediately
3. Never use these credentials in production!

---

## 🎪 Adding Your First Event

### Step-by-Step Guide

1. **Login to Admin Panel**
   - Go to: `http://localhost/balumkaevents/admin/`
   - Enter username: `admin`
   - Enter password: `admin123`

2. **Navigate to Events**
   - Click **"🎉 Events"** in the left sidebar
   - Click **"➕ Add New Event"** button

3. **Fill in Event Details**

   **Required Fields:**
   - **Event Title:** e.g., "Afrobeats Night"
   - **Description:** Write about your event
   - **Date:** Select event date
   - **Location:** e.g., "Prague City Center"
   - **Category:** Choose from dropdown

   **Optional Fields:**
   - **Time:** Event start time
   - **Venue Address:** Full address
   - **Genre:** Music/dance style
   - **Event Image:** Upload a photo (JPG, PNG, max 5MB)
   - **Price Info:** e.g., "From 200 CZK"
   - **Ticket Link:** URL to ticket page
   - **Capacity:** Maximum attendees
   
   **Tags:**
   - ✓ **Featured Event** - Shows on homepage
   - ✓ **Hot Tag** - Displays "HOT" badge

4. **Click "Create Event"**

5. **View Your Event**
   - Go to frontend: `http://localhost/balumkaevents/`
   - Your event should now appear!

---

## 🎨 Features Overview

### Frontend Features

✅ **Dynamic Homepage**
- Displays featured upcoming events from database
- Hero section with call-to-action buttons
- About section
- Newsletter signup

✅ **Events Page**
- Lists all upcoming events from database
- Filter by category (Parties, Festivals, Workshops)
- Responsive event cards
- Event images display automatically

✅ **Mobile Responsive**
- Works on all devices
- Adaptive navigation menu

### Admin Panel Features

✅ **Dashboard**
- Statistics overview
- Quick access to events
- Recent activity

✅ **Event Management**
- Add/Edit/Delete events
- Upload event images
- Set featured/hot tags
- Search and filter events
- Category organization

✅ **Database-Driven**
- All events stored in MySQL
- Automatic date formatting
- Slug generation for SEO

✅ **Secure Admin**
- Password-protected
- Session management
- Flash message system

---

## 🔧 Troubleshooting

### Problem: "Database Connection Failed"

**Solutions:**
1. Check MySQL is running in XAMPP
2. Verify database exists: `balumka_events`
3. Check credentials in `includes/config.php`
4. Run setup.sql again if needed

### Problem: "Page Not Found" or 404 Error

**Solutions:**
1. Check URL is correct: `http://localhost/balumkaevents/`
2. Ensure Apache is running in XAMPP
3. Verify files are in: `C:\xampp\htdocs\balumkaevents\`

### Problem: Images Not Uploading

**Solutions:**
1. Check `uploads/events/` folder exists
2. Verify folder permissions (should be writable)
3. Check image size (must be under 5MB)
4. Verify file type (JPG, PNG, GIF, WebP only)

### Problem: Can't Login to Admin

**Solutions:**
1. Check database has `admin_users` table
2. Verify default admin exists (run setup.sql again)
3. Clear browser cookies/cache
4. Use default credentials: `admin` / `admin123`

### Problem: Events Not Showing on Frontend

**Solutions:**
1. Check event status is "upcoming" in database
2. Verify event date is in the future
3. For homepage, ensure event is marked as "Featured"
4. Check database connection is working

---

## 📁 File Structure

```
balumkaevents/
├── admin/                      # Admin panel
│   ├── includes/
│   │   ├── header.php         # Admin header template
│   │   └── footer.php         # Admin footer template
│   ├── index.php              # Admin dashboard
│   ├── login.php              # Login page
│   ├── logout.php             # Logout handler
│   ├── events.php             # Event list management
│   ├── event-add.php          # Add new event
│   ├── event-edit.php         # Edit event
│   └── event-delete.php       # Delete event
├── database/
│   └── setup.sql              # Database creation script
├── includes/
│   ├── config.php             # Database & site configuration
│   └── functions.php          # Helper functions
├── mockup/                    # Static design files
│   ├── styles.css             # Website styling
│   ├── script.js              # Frontend JavaScript
│   └── *.html                 # Static pages (about, contact, etc.)
├── uploads/
│   └── events/                # Event images storage
├── index.php                  # Dynamic homepage
├── events.php                 # Dynamic events page
└── SETUP_GUIDE.md             # This file
```

---

## 🚀 Next Steps

### Customize Your Site

1. **Update Site Information**
   - Edit contact details in footer
   - Add social media links
   - Update email addresses

2. **Add Your Events**
   - Replace sample events with real ones
   - Upload professional event images
   - Set proper dates and prices

3. **Customize Design**
   - Edit `mockup/styles.css` for colors
   - Modify logo text
   - Adjust layout if needed

4. **Complete Static Pages**
   - Update `mockup/about.html` with your story
   - Configure `mockup/contact.html` form
   - Setup `mockup/guestlist.html` registration

### For Production Deployment

When ready to go live:

1. Change database password
2. Change admin password
3. Update `SITE_URL` in config.php
4. Set `display_errors` to `0` in config.php
5. Use HTTPS for secure connections
6. Set up regular database backups

---

## 💡 Tips for Success

1. **Add events regularly** - Keep your calendar fresh
2. **Use high-quality images** - Makes events more appealing
3. **Mark popular events as "Hot"** - Creates urgency
4. **Feature your best events** - They appear on homepage
5. **Update past events** - System can auto-update status

---

## 📞 Support

If you encounter issues:

1. Check this guide's Troubleshooting section
2. Verify all prerequisites are met
3. Review error messages in browser console
4. Check XAMPP error logs

---

## ✨ Congratulations!

You now have a fully functional event management system! 🎉

Start by logging in and adding your first event. Your audience can view events on the beautiful frontend while you manage everything from the powerful admin panel.

**Happy Event Managing! 🎊**

---

*Last Updated: <?= date('F Y') ?>*
*Balumuka Events Management System v1.0*
