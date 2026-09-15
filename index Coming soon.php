<?php
/**
 * BALUMUKA EVENTS - Coming Soon Page
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BALUMUKA EVENTS - Coming Soon</title>
    <meta name="description" content="BALUMUKA EVENTS is launching soon. African music, dance, nightlife and unforgettable experiences in Prague.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;900&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #FF6B35;
            --secondary-color: #FFB627;
            --accent-gold: #FFD700;
            --dark-bg: #0A0A0A;
            --light-text: #FFFFFF;
            --gray-text: #B0B0B0;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Montserrat', sans-serif;
            background: var(--dark-bg);
            color: var(--light-text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
        }
        .coming-soon {
            max-width: 700px;
        }
        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 900;
            letter-spacing: 2px;
            margin-bottom: 2rem;
        }
        .logo-accent {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        h1 {
            font-size: clamp(2rem, 6vw, 3.5rem);
            font-weight: 900;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }
        p.subtitle {
            color: var(--gray-text);
            font-size: 1.1rem;
            margin-bottom: 2.5rem;
        }
        .divider {
            width: 80px;
            height: 4px;
            margin: 0 auto 2.5rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 2px;
        }
        .contact {
            color: var(--gray-text);
            font-size: 0.95rem;
        }
        .contact a {
            color: var(--accent-gold);
            text-decoration: none;
            font-weight: 600;
        }
        .contact a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="coming-soon">
        <div class="logo">BALUMUKA<span class="logo-accent">EVENTS</span></div>
        <h1>SOMETHING EXCITING<br>IS COMING SOON.</h1>
        <div class="divider"></div>
        <p class="subtitle">We're putting the final touches on our new home for African music, dance and culture in Prague. Stay tuned!</p>
        <p class="contact">Questions? Reach us at <a href="mailto:Jmulimbwe@gmail.com">Jmulimbwe@gmail.com</a></p>
    </div>
</body>
</html>
