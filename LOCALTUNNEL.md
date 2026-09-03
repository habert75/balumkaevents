# LocalTunnel Setup Guide

Share your local Balumka Events website with clients for testing without deploying to a server.

## Prerequisites

- XAMPP running (Apache and MySQL started)
- Node.js installed
- Website working locally at `http://localhost/balumkaevents`

## Installation

Install LocalTunnel globally using npm:

```powershell
npm install -g localtunnel
```

## Usage

### 1. Start LocalTunnel

Open PowerShell in the project directory and run:

```powershell
lt --port 80 --subdomain balumkaevents
```

You'll see output like:
```
your url is: https://balumkaevents.loca.lt
```

### 2. Update Site Configuration

Before sharing, update the site URL in `includes/config.php`:

**Change from:**
```php
define('SITE_URL', 'http://localhost/balumkaevents');
```

**Change to:**
```php
define('SITE_URL', 'https://balumkaevents.loca.lt/balumkaevents');
```

This ensures images and links work correctly through the tunnel.

### 3. Share with Client

Send your client the URL:
```
https://balumkaevents.loca.lt/balumkaevents
```

**Important Notes:**
- First-time visitors will see a security warning page
- Click "Click to Continue" to access the site
- Keep the terminal running during the entire testing session
- Keep XAMPP running while the tunnel is active

### 4. Stop the Tunnel

When testing is complete:

1. Press `Ctrl+C` in the PowerShell terminal
2. Revert the config back to localhost:

```php
define('SITE_URL', 'http://localhost/balumkaevents');
```

## Troubleshooting

### Subdomain Not Available
If `balumkaevents` subdomain is taken, use without subdomain:
```powershell
lt --port 80
```
This will generate a random URL like `https://heavy-rats-12345.loca.lt`

### Images Not Loading
Make sure you've updated `SITE_URL` in `includes/config.php` to match the tunnel URL.

### Connection Issues
- Verify XAMPP is running
- Check that the website works at `http://localhost/balumkaevents`
- Ensure your firewall isn't blocking the tunnel

## Alternative: ngrok

If LocalTunnel doesn't work, try ngrok:

1. Download from https://ngrok.com/download
2. Extract to a folder
3. Run: `ngrok http 80`
4. Use the HTTPS forwarding URL provided

## Security Note

⚠️ These tunnels expose your local server to the internet temporarily. Only share the URL with trusted clients and stop the tunnel when testing is complete.

## For Production Deployment

For permanent hosting, consider:
- **Free Hosting**: InfinityFree, 000webhost
- **Paid Hosting**: Hostinger, Bluehost ($3-5/month)
- **VPS**: DigitalOcean, Vultr ($5-10/month)
