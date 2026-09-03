-- Fix admin password to "admin123"
UPDATE admin_users 
SET password = '$2y$10$6x6c7lgOHigMUKWKwx8dbuK7MjPVizxMThCd/XayXAqemynjg.RGW'
WHERE username = 'admin';

-- Verify the update
SELECT username, email, full_name FROM admin_users WHERE username = 'admin';
