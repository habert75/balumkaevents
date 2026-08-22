# 🎉 BALUMUKA EVENTS - Complete Event Management System

**Professional Event Management with PHP + MySQL**

Transform your static website mockup into a fully functional, database-driven event management platform!

---

## ✨ What You Get

### 🎨 Beautiful Frontend
- **Dynamic Homepage** - Automatically displays featured events from database
- **Events Listing Page** - Shows all upcoming events with filtering
- **Responsive Design** - Works perfectly on mobile, tablet, and desktop
- **Professional UI** - Maintains your existing beautiful mockup design

### 🛠️ Powerful Admin Panel
- **Dashboard** - Overview statistics and quick actions
- **Event Management** - Add, edit, delete events with ease
- **Image Uploads** - Upload event photos (up to 5MB)
- **Search & Filter** - Find events quickly
- **Guest List Management** - View registrations
- **Newsletter Subscribers** - Manage email list
- **Contact Messages** - View form submissions
- **Settings** - Change password and view system info

### 🗄️ Database Features
- **MySQL Database** - Robust data storage
- **6 Sample Events** - Pre-populated for testing
- **5 Tables** - Events, Registrations, Messages, Subscribers, Admin Users
- **SEO-Ready** - Meta tags and clean URLs

---

## 📦 What's Included

### Core Files
- ✅ Database setup script with sample data
- ✅ Configuration files (database connection, settings)
- ✅ Helper functions (sanitization, validation, formatting)
- ✅ Dynamic PHP pages (index, events)
- ✅ Complete admin panel (login, dashboard, CRUD)
- ✅ Image upload system
- ✅ Session management & authentication

### Documentation
- ✅ **SETUP_GUIDE.md** - Complete step-by-step instructions
- ✅ **QUICK_START.md** - 5-minute quick setup guide
- ✅ **README.md** - This file (project overview)

---

## 🚀 Quick Setup (5 Minutes)

### 1. Start XAMPP
- Start Apache and MySQL

### 2. Create Upload Folder
```
C:\xampp\htdocs\balumkaevents\uploads\events\
```

### 3. Import Database
- Open phpMyAdmin: `http://localhost/phpmyadmin`
- Create database: `balumka_events`
- Import: `database/setup.sql`

### 4. Access Your Site

**Frontend:**
```
http://localhost/balumkaevents/
```

**Admin Panel:**
```
http://localhost/balumkaevents/admin/
Username: admin
Password: admin123
```

**⚠️ Change the default password immediately after first login!**

---

## 📖 Full Documentation

For detailed setup instructions, troubleshooting, and usage guide, see:

- **[QUICK_START.md](QUICK_START.md)** - Fast 5-minute setup
- **[SETUP_GUIDE.md](SETUP_GUIDE.md)** - Complete detailed guide

---

## 🎯 Key Features

### Event Management
- ✅ Add/Edit/Delete events
- ✅ Upload event images
- ✅ Set event status (upcoming, ongoing, past, cancelled)
- ✅ Mark events as Featured or Hot
- ✅ Categorize (Parties, Festivals, Workshops)
- ✅ Add pricing and ticket links
- ✅ Set venue and location
- ✅ SEO meta tags

### Frontend Display
- ✅ Featured events on homepage
- ✅ All events on events page
- ✅ Filter by category
- ✅ Responsive event cards
- ✅ Automatic date formatting
- ✅ Dynamic image display

### Security
- ✅ Password-protected admin
- ✅ Session management
- ✅ SQL injection prevention (PDO prepared statements)
- ✅ XSS protection (input sanitization)
- ✅ File upload validation

---

## 📁 Project Structure

```
balumkaevents/
├── admin/                      # Admin panel
│   ├── includes/              # Admin templates
│   ├── index.php              # Dashboard
│   ├── login.php              # Login page
│   ├── events.php             # Event management
│   ├── event-add.php          # Add event
│   ├── event-edit.php         # Edit event
│   ├── event-delete.php       # Delete event
│   ├── registrations.php      # Guest list
│   ├── messages.php           # Contact messages
│   ├── subscribers.php        # Newsletter
│   └── settings.php           # Admin settings
├── database/
│   └── setup.sql              # Database script
├── includes/
│   ├── config.php             # Configuration
│   └── functions.php          # Helper functions
├── mockup/                    # Your original design
│   ├── styles.css
│   ├── script.js
│   └── *.html
├── uploads/
│   └── events/                # Event images
├── index.php                  # Dynamic homepage
├── events.php                 # Dynamic events page
├── QUICK_START.md             # Quick guide
├── SETUP_GUIDE.md             # Detailed guide
└── README.md                  # This file
```

---

## 💻 Technology Stack

- **Backend:** PHP 7.4+
- **Database:** MySQL 5.7+
- **Frontend:** HTML5, CSS3, JavaScript
- **Server:** Apache (XAMPP)
- **Architecture:** MVC-inspired, procedural PHP

---

## 🔒 Security Features

- Password hashing (bcrypt)
- Prepared statements (SQL injection protection)
- Input sanitization (XSS protection)
- Session management
- File upload validation
- Access control

---

## 🎨 Customization

### Change Colors
Edit `mockup/styles.css`:
```css
--primary-color: #FF6B35;
--secondary-color: #FFB627;
```

### Update Site Info
Edit `includes/config.php`:
```php
define('SITE_NAME', 'Your Event Name');
define('SITE_URL', 'http://yoursite.com');
```

### Modify Database
Edit `database/setup.sql` for schema changes

---

## 📱 Responsive Design

- ✅ Mobile-first approach
- ✅ Breakpoints for all devices
- ✅ Touch-friendly navigation
- ✅ Optimized images
- ✅ Fast loading

---

## 🔄 Workflow

### For Event Managers
1. Login to admin panel
2. Add new events with details and images
3. Mark important events as Featured/Hot
4. Manage registrations and guest lists
5. View contact messages
6. Export newsletter subscribers

### For Website Visitors
1. Browse events on homepage
2. View all events on events page
3. Filter by category
4. Register for events
5. Subscribe to newsletter
6. Contact organizers

---

## 🆘 Troubleshooting

### Common Issues

**Database connection error?**
- Check MySQL is running
- Verify database credentials in `includes/config.php`
- Ensure database `balumka_events` exists

**Can't upload images?**
- Create `uploads/events/` folder
- Check folder permissions
- Verify max upload size in php.ini

**Events not showing?**
- Check event status is "upcoming"
- Verify date is in future
- For homepage, ensure "Featured" is checked

See [SETUP_GUIDE.md](SETUP_GUIDE.md) for detailed troubleshooting.

---

## 🚀 Deployment to Production

When ready to go live:

1. **Update Configuration**
   ```php
   define('SITE_URL', 'https://yourdomain.com');
   define('DB_PASS', 'strong-password-here');
   ```

2. **Secure Settings**
   - Change admin password
   - Set `display_errors` to 0
   - Enable HTTPS
   - Update .htaccess

3. **Database**
   - Use strong DB password
   - Regular backups
   - Restrict database access

4. **Files**
   - Set proper permissions (755 for folders, 644 for files)
   - Secure uploads folder
   - Remove setup files

---

## 📈 Future Enhancements

Possible additions:
- Email notifications
- Ticket purchasing integration
- Calendar export (iCal)
- Social media sharing
- Multi-language support
- Analytics dashboard
- Automated email marketing
- Payment gateway integration

---

## 🎓 Learning Resources

This project demonstrates:
- PHP CRUD operations
- MySQL database design
- Session management
- File uploads
- Form validation
- Security best practices
- Responsive design

---

## 🙏 Credits

Built with:
- PHP & MySQL
- Custom CSS (your mockup design)
- Vanilla JavaScript
- Font: Montserrat & Playfair Display

---

## 📄 License

This is a custom-built solution. Modify and use as needed for your events business.

---

## 📞 Support

For issues or questions:
1. Check [QUICK_START.md](QUICK_START.md)
2. Review [SETUP_GUIDE.md](SETUP_GUIDE.md)
3. Verify XAMPP is running properly
4. Check error logs in XAMPP

---

## ✅ System Requirements

- **PHP:** 7.4 or higher
- **MySQL:** 5.7 or higher
- **Apache:** 2.4 or higher
- **Disk Space:** 100MB minimum
- **RAM:** 512MB minimum
- **Browser:** Modern browser (Chrome, Firefox, Safari, Edge)

---

## 🎊 Conclusion

You now have a **professional, database-driven event management system** that:

✅ Keeps your beautiful mockup design
✅ Adds powerful backend functionality
✅ Requires NO WordPress or heavy CMS
✅ Is lightweight and fast
✅ Gives you complete control
✅ Is easy to customize
✅ Includes comprehensive documentation

**Start managing your events like a pro! 🚀**

---

*Version 1.0 | Built <?= date('Y') ?> | Balumuka Events Management System*
