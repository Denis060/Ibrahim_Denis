<?php
require_once '../includes/db.php';
require_once 'includes/admin_header.php';

// ✅ Handle deletion from within this page
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM recognition WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: manage_recognition.php");
    exit;
}

// ✅ Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $title = trim($_POST['title']);
    $organization = trim($_POST['organization']);
    $location = trim($_POST['location']);
    $start_date = $_POST['start_date'];
    $end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : null;
    $description = trim($_POST['description']);
    $external_link = trim($_POST['external_link']);
    $badge_icon = trim($_POST['badge_icon']);
    $type = $_POST['type'];
    $visibility = $_POST['visibility'];

    if ($title && $organization && $start_date) {
        $stmt = $pdo->prepare("INSERT INTO recognition 
          (title, organization, location, start_date, end_date, description, external_link, badge_icon, type, visibility) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->execute([
            $title, $organization, $location, $start_date, $end_date,
            $description, $external_link, $badge_icon, $type, $visibility
        ]);

        header("Location: manage_recognition.php");
        exit;
    }
}

// ✅ Fetch all recognitions
$recognitions = $pdo->query("SELECT * FROM recognition ORDER BY start_date DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="admin-section">
  <h2>🏅 Manage Recognition</h2>

  <!-- 🔹 Form for Adding Recognition -->
  <div class="edit-project-container">
    <form method="POST" class="form-column">

      <input type="text" name="title" class="input input-wide" placeholder="Recognition Title (e.g., Top 10 Data Scientists)" required>

      <input type="text" name="organization" class="input input-wide" placeholder="Issuing Organization" required>

      <input type="text" name="location" class="input input-wide" placeholder="Location (e.g., Global or New York)">

      <label>Start Date</label>
      <input type="date" name="start_date" class="input input-wide" required>

      <label>End Date <small>(optional)</small></label>
      <input type="date" name="end_date" class="input input-wide">

      <textarea name="description" class="input input-wide" rows="2" placeholder="Brief Description of the Recognition..."></textarea>

      <input type="url" name="external_link" class="input input-wide" placeholder="External Link (e.g., article, certificate)">

      <input type="text" name="badge_icon" class="input input-wide" placeholder="FontAwesome Icon (e.g., fas fa-award)">

      <select name="type" class="input input-wide">
        <option value="Award">Award</option>
        <option value="Badge">Badge</option>
        <option value="Mention">Mention</option>
      </select>

      <select name="visibility" class="input input-wide">
        <option value="public">Public</option>
        <option value="private">Private</option>
      </select>

      <button type="submit" class="btn btn-add">+ Add Recognition</button>
    </form>
  </div>

  <!-- 🔹 Recognition Table -->
  <table class="admin-table">
    <thead>
      <tr>
        <th>#</th>
        <th>Title</th>
        <th>Org</th>
        <th>Location</th>
        <th>Dates</th>
        <th>Type</th>
        <th>Icon</th>
        <th>Visibility</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($recognitions as $i => $r): ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td><?= htmlspecialchars($r['title']) ?></td>
          <td><?= htmlspecialchars($r['organization']) ?></td>
          <td><?= htmlspecialchars($r['location']) ?></td>
          <td>
            <?= htmlspecialchars($r['start_date']) ?>
            <?= $r['end_date'] ? ' – ' . htmlspecialchars($r['end_date']) : '' ?>
          </td>
          <td><?= htmlspecialchars($r['type']) ?></td>
          <td><i class="<?= htmlspecialchars($r['badge_icon']) ?>"></i></td>
          <td><?= htmlspecialchars($r['visibility']) ?></td>
          <td>
            <a href="edit_recognition.php?id=<?= $r['id'] ?>" class="btn-sm edit">Edit</a>
            <a href="manage_recognition.php?delete=<?= $r['id'] ?>" class="btn-sm delete" onclick="return confirm('Delete this item?')">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <br><a href="dashboard.php">← Back to Dashboard</a>
</div>

<?php require_once 'includes/admin_footer.php'; ?>
