// ===================================
// BALUMUKA EVENTS - MOCKUP JAVASCRIPT
// ===================================

// === NAVIGATION ===
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.getElementById('navbar');
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');

    // Sticky Navigation on Scroll
    window.addEventListener('scroll', function() {
        if (window.scrollY > 100) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Mobile Menu Toggle
    if (navToggle) {
        navToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            
            // Animate hamburger
            const spans = navToggle.querySelectorAll('span');
            if (navMenu.classList.contains('active')) {
                spans[0].style.transform = 'rotate(45deg) translateY(8px)';
                spans[1].style.opacity = '0';
                spans[2].style.transform = 'rotate(-45deg) translateY(-8px)';
            } else {
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            }
        });

        // Close menu when clicking nav links
        const navLinks = document.querySelectorAll('.nav-menu a');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('active');
                const spans = navToggle.querySelectorAll('span');
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            });
        });
    }

    // Smooth Scrolling for Anchor Links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#' && document.querySelector(href)) {
                e.preventDefault();
                document.querySelector(href).scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // === EVENTS FILTER ===
    const filterButtons = document.querySelectorAll('.filter-btn');
    const eventCards = document.querySelectorAll('.event-card');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');

            const filterValue = this.getAttribute('data-filter');

            eventCards.forEach(card => {
                const categories = card.getAttribute('data-category');
                
                if (filterValue === 'all') {
                    card.style.display = 'block';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'scale(1)';
                    }, 10);
                } else {
                    if (categories && categories.includes(filterValue)) {
                        card.style.display = 'block';
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'scale(1)';
                        }, 10);
                    } else {
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.8)';
                        setTimeout(() => {
                            card.style.display = 'none';
                        }, 300);
                    }
                }
            });
        });
    });

    // === GUEST LIST FORM ===
    const guestlistForm = document.getElementById('guestlistForm');
    if (guestlistForm) {
        guestlistForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Get form data
            const formData = {
                fullname: document.getElementById('fullname').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                event: document.getElementById('event').value,
                guests: document.getElementById('guests').value
            };

            // Simulate form submission
            console.log('Guest List Submission:', formData);

            // Show success message
            guestlistForm.style.display = 'none';
            document.getElementById('formSuccess').style.display = 'block';

            // Scroll to success message
            document.getElementById('formSuccess').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
            });
        });
    }

    // === CONTACT FORM ===
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Get form data
            const formData = {
                name: document.getElementById('name').value,
                email: document.getElementById('contact-email').value,
                phone: document.getElementById('contact-phone').value,
                inquiryType: document.getElementById('inquiry-type').value,
                message: document.getElementById('message').value
            };

            // Simulate form submission
            console.log('Contact Form Submission:', formData);

            // Show success message
            contactForm.style.display = 'none';
            document.getElementById('contactSuccess').style.display = 'block';

            // Scroll to success message
            document.getElementById('contactSuccess').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
            });
        });
    }

    // === NEWSLETTER FORM ===
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const emailInput = this.querySelector('input[type="email"]');
            const email = emailInput.value;

            // Simulate newsletter subscription
            console.log('Newsletter Subscription:', email);

            // Show feedback
            const button = this.querySelector('button');
            const originalText = button.textContent;
            button.textContent = 'SUBSCRIBED!';
            button.style.background = '#2A2A2A';
            
            setTimeout(() => {
                button.textContent = originalText;
                button.style.background = '';
                emailInput.value = '';
            }, 3000);
        });
    }

    // === ANIMATION ON SCROLL ===
    const animateOnScroll = () => {
        const elements = document.querySelectorAll('[data-aos]');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        elements.forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.8s ease';
            observer.observe(el);
        });
    };

    animateOnScroll();

    // === EVENT CARD HOVER EFFECTS ===
    const cards = document.querySelectorAll('.event-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // === PARALLAX EFFECT FOR HERO ===
    const hero = document.querySelector('.hero');
    if (hero) {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const heroContent = hero.querySelector('.hero-content');
            if (heroContent) {
                heroContent.style.transform = `translateY(${scrolled * 0.5}px)`;
                heroContent.style.opacity = 1 - (scrolled * 0.002);
            }
        });
    }

    // === STATS COUNTER ANIMATION ===
    const stats = document.querySelectorAll('.stat-number');
    const animateStats = () => {
        stats.forEach(stat => {
            const target = stat.textContent;
            const isNumber = /^\d+/.test(target);
            
            if (isNumber) {
                const num = parseInt(target);
                const duration = 2000;
                const increment = num / (duration / 16);
                let current = 0;
                
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const timer = setInterval(() => {
                                current += increment;
                                if (current >= num) {
                                    stat.textContent = target;
                                    clearInterval(timer);
                                } else {
                                    stat.textContent = Math.floor(current) + target.replace(/^\d+/, '');
                                }
                            }, 16);
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.5 });
                
                observer.observe(stat);
            }
        });
    };

    animateStats();

    // === GALLERY LIGHTBOX (Simple Implementation) ===
    const galleryItems = document.querySelectorAll('.gallery-item');
    galleryItems.forEach(item => {
        item.addEventListener('click', function() {
            // Create lightbox overlay
            const lightbox = document.createElement('div');
            lightbox.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.95);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 10000;
                cursor: pointer;
            `;
            
            const content = document.createElement('div');
            content.style.cssText = `
                max-width: 90%;
                max-height: 90%;
                padding: 20px;
                text-align: center;
            `;
            
            const message = document.createElement('p');
            message.textContent = 'Gallery image would appear here in full size';
            message.style.cssText = 'color: white; font-size: 24px;';
            
            content.appendChild(message);
            lightbox.appendChild(content);
            document.body.appendChild(lightbox);
            
            // Close on click
            lightbox.addEventListener('click', () => {
                document.body.removeChild(lightbox);
            });
        });
    });

    // === LOADING ANIMATION ===
    window.addEventListener('load', () => {
        document.body.style.opacity = '0';
        setTimeout(() => {
            document.body.style.transition = 'opacity 0.5s ease';
            document.body.style.opacity = '1';
        }, 100);
    });

    // === FORM VALIDATION ENHANCEMENT ===
    const allForms = document.querySelectorAll('form');
    allForms.forEach(form => {
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('invalid', (e) => {
                e.preventDefault();
                input.style.borderColor = '#FF6B35';
            });
            
            input.addEventListener('input', () => {
                input.style.borderColor = 'transparent';
            });
        });
    });

    // === DETECT IF USER IS ON MOBILE ===
    const isMobile = () => {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    };

    if (isMobile()) {
        document.body.classList.add('mobile');
    }

    // === LOG INITIALIZATION ===
    console.log('%c🎉 BALUMUKA EVENTS - Website Loaded Successfully! 🎉', 'color: #FF6B35; font-size: 16px; font-weight: bold;');
    console.log('%cExperience Africa. Live the Culture.', 'color: #FFB627; font-size: 14px;');
});

// === UTILITY FUNCTIONS ===

// Debounce function for scroll events
function debounce(func, wait = 10, immediate = true) {
    let timeout;
    return function() {
        const context = this, args = arguments;
        const later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        const callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
}

// Smooth scroll to top
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// Add to top button if user scrolls down
window.addEventListener('scroll', debounce(() => {
    if (window.pageYOffset > 500 && !document.querySelector('.scroll-to-top')) {
        const scrollBtn = document.createElement('button');
        scrollBtn.className = 'scroll-to-top';
        scrollBtn.innerHTML = '↑';
        scrollBtn.style.cssText = `
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FF6B35, #FFB627);
            color: white;
            border: none;
            font-size: 24px;
            cursor: pointer;
            z-index: 999;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(255, 107, 53, 0.4);
        `;
        
        scrollBtn.addEventListener('mouseenter', () => {
            scrollBtn.style.transform = 'translateY(-5px)';
        });
        
        scrollBtn.addEventListener('mouseleave', () => {
            scrollBtn.style.transform = 'translateY(0)';
        });
        
        scrollBtn.addEventListener('click', scrollToTop);
        document.body.appendChild(scrollBtn);
    } else if (window.pageYOffset < 500) {
        const scrollBtn = document.querySelector('.scroll-to-top');
        if (scrollBtn) {
            scrollBtn.remove();
        }
    }
}));
