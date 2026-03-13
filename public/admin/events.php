<?php
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';
require_once __DIR__ . '/bootstrap.php';
requireAuth();

$pageTitle = 'Events';
$message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf()) {
    $id = (int)($_POST['id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $venue = trim($_POST['venue'] ?? '');
    $venue_city = trim($_POST['venue_city'] ?? '');
    $event_date = trim($_POST['event_date'] ?? '');
    $event_time = trim($_POST['event_time'] ?? '') ?: null;
    $ticket_url = trim($_POST['ticket_url'] ?? '') ?: null;
    $description = trim($_POST['description'] ?? '') ?: null;
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    if ($title && $venue && $event_date) {
        if ($id) {
            $stmt = $pdo->prepare("UPDATE events SET title=?, venue=?, venue_city=?, event_date=?, event_time=?, ticket_url=?, description=?, is_featured=? WHERE id=?");
            $stmt->execute([$title, $venue, $venue_city, $event_date, $event_time, $ticket_url, $description, $is_featured, $id]);
            $message = 'Event updated.';
        } else {
            $stmt = $pdo->prepare("INSERT INTO events (title, venue, venue_city, event_date, event_time, ticket_url, description, is_featured) VALUES (?,?,?,?,?,?,?,?)");
            $stmt->execute([$title, $venue, $venue_city, $event_date, $event_time, $ticket_url, $description, $is_featured]);
            $message = 'Event added.';
        }
    }
}

// Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM events WHERE id=?")->execute([$id]);
    $message = 'Event deleted.';
}

// Edit form
$edit = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM events WHERE id=?");
    $stmt->execute([(int)$_GET['edit']]);
    $edit = $stmt->fetch();
} elseif (isset($_GET['action']) && $_GET['action'] === 'add') {
    $edit = ['id' => 0, 'title' => '', 'venue' => '', 'venue_city' => '', 'event_date' => '', 'event_time' => '', 'ticket_url' => '', 'description' => '', 'is_featured' => 0];
}

$stmt = $pdo->query("SELECT * FROM events ORDER BY event_date DESC");
$events = $stmt->fetchAll();

ob_start();
?>
<div class="admin-header">
    <h1>Events</h1>
    <a href="?action=add" class="btn btn-primary">+ Add Event</a>
</div>
<?php if ($message): ?><p class="flash flash-success"><?= e($message) ?></p><?php endif; ?>

<?php if ($edit): ?>
<form method="post" class="admin-form">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= $edit['id'] ?>">
    <div class="form-group">
        <label>Title *</label>
        <input type="text" name="title" value="<?= e($edit['title']) ?>" required>
    </div>
    <div class="form-row">
        <div class="form-group">
            <label>Venue *</label>
            <input type="text" name="venue" value="<?= e($edit['venue']) ?>" required>
        </div>
        <div class="form-group">
            <label>City</label>
            <input type="text" name="venue_city" value="<?= e($edit['venue_city']) ?>">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group">
            <label>Date *</label>
            <input type="date" name="event_date" value="<?= e($edit['event_date']) ?>" required>
        </div>
        <div class="form-group">
            <label>Time</label>
            <input type="time" name="event_time" value="<?= e($edit['event_time']) ?>">
        </div>
    </div>
    <div class="form-group">
        <label>Ticket URL</label>
        <input type="url" name="ticket_url" value="<?= e($edit['ticket_url']) ?>" placeholder="https://...">
    </div>
    <div class="form-group">
        <label>Description</label>
        <textarea name="description" rows="3"><?= e($edit['description']) ?></textarea>
    </div>
    <div class="form-group">
        <label><input type="checkbox" name="is_featured" value="1" <?= $edit['is_featured'] ? 'checked' : '' ?>> Featured on homepage</label>
    </div>
    <button type="submit" class="btn btn-primary">Save Event</button>
    <a href="events.php" class="btn btn-secondary">Cancel</a>
</form>
<?php endif; ?>

<table class="admin-table">
    <thead>
        <tr><th>Date</th><th>Title</th><th>Venue</th><th>Actions</th></tr>
    </thead>
    <tbody>
        <?php foreach ($events as $e): ?>
        <tr>
            <td><?= format_date($e['event_date']) ?></td>
            <td><?= e($e['title']) ?></td>
            <td><?= e($e['venue']) ?></td>
            <td>
                <a href="/live.php" target="_blank" rel="noopener" class="btn btn-small btn-secondary">View</a>
                <a href="?edit=<?= $e['id'] ?>" class="btn btn-small btn-primary">Edit</a>
                <a href="?delete=<?= $e['id'] ?>" class="btn btn-small btn-secondary" onclick="return confirm('Delete this event?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
$adminContent = ob_get_clean();
include __DIR__ . '/layout.php';
