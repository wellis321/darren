<?php
$pageTitle = 'Dashboard';
$stmt = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'new'");
$newBookings = $stmt->fetchColumn();
$stmt = $pdo->query("SELECT COUNT(*) FROM events WHERE event_date >= CURDATE()");
$upcomingEvents = $stmt->fetchColumn();
$stmt = $pdo->query("SELECT COUNT(*) FROM newsletter_subscribers");
$subscribers = $stmt->fetchColumn();
?>
<div class="admin-header">
    <h1>Dashboard</h1>
    <a href="/" class="btn btn-secondary" target="_blank">View Site</a>
    <a href="logout.php" class="btn btn-outline">Logout</a>
</div>
<div class="admin-stats">
    <div class="stat-card">
        <span class="stat-value"><?= $newBookings ?></span>
        <span class="stat-label">New Enquiries</span>
        <a href="bookings.php">View →</a>
    </div>
    <div class="stat-card">
        <span class="stat-value"><?= $upcomingEvents ?></span>
        <span class="stat-label">Upcoming Events</span>
        <a href="events.php">Manage →</a>
    </div>
    <div class="stat-card">
        <span class="stat-value"><?= $subscribers ?></span>
        <span class="stat-label">Newsletter Subscribers</span>
    </div>
</div>
<div class="admin-quick">
    <a href="events.php?action=add" class="btn btn-primary">+ Add Event</a>
    <a href="content.php" class="btn btn-secondary">Edit Content</a>
    <a href="media.php" class="btn btn-secondary">Manage Media</a>
    <a href="podcast.php" class="btn btn-secondary">Podcast Episodes</a>
</div>
