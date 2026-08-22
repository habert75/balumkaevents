<?php
/**
 * BALUMUKA EVENTS - Delete Event
 */
define('BALUMKA_ACCESS', true);
require_once '../includes/config.php';
require_once '../includes/functions.php';

requireLogin();

// Get event ID
$eventId = $_GET['id'] ?? 0;
$event = getEvent($eventId);

if (!$event) {
    redirect(SITE_URL . '/admin/events.php', 'Event not found', 'error');
}

try {
    $db = getDB();
    
    // Delete event image if exists
    if ($event['image']) {
        deleteImage($event['image']);
    }
    
    // Delete event
    $stmt = $db->prepare("DELETE FROM events WHERE id = ?");
    $stmt->execute([$eventId]);
    
    redirect(SITE_URL . '/admin/events.php', 'Event deleted successfully!', 'success');
} catch (PDOException $e) {
    redirect(SITE_URL . '/admin/events.php', 'Error deleting event: ' . $e->getMessage(), 'error');
}
