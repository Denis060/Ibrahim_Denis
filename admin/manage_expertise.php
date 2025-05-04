<?php
require_once '../includes/db.php';
require_once 'includes/admin_header.php';

// ✅ Handle deletion first (before fetching)
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
  $id = $_GET['delete'];
  $pdo->prepare("DELETE FROM expertise WHERE id = ?")->execute([$id]);
  header("Location: manage_expertise.php?deleted=1");
  exit;
}

// ✅ Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = trim($_POST['title']);
  $subtitle = trim($_POST['subtitle']);
  $impact = trim($_POST['impact']);

  if ($title && $subtitle) {
    $stmt = $pdo->prepare("INSERT INTO expertise 
      (title, subtitle, impact, created_at, visible, status, visibility) 
      VALUES (?, ?, ?, NOW(), 1, 'active', 'public')");
    $stmt->execute([$title, $subtitle, $impact]);
    header("Location: manage_expertise.php?added=1");
    exit;
  }
}

// ✅ Fetch all expertise records
$expertiseList = $pdo->query("SELECT * FROM expertise ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="edit-project-container">
  <h2>⭐ Manage Expertise</h2>

  <!-- ✅ Optional status alert -->
  <?php if (isset($_GET['deleted'])): ?>
    <div class="alert-success">✅ Expertise entry deleted successfully.</div>
  <?php elseif (isset($_GET['added'])): ?>
    <div class="alert-success">✅ New expertise added.</div>
  <?php endif; ?>

  <!-- 🔹 ADD EXPERTISE FORM -->
  <form method="POST" class="form-column" style="margin-bottom: 25px;">
    <input type="text" name="title" class="input input-wide" placeholder="Expertise Area / Title (e.g., Project Management)" required>

    <textarea name="subtitle" class="input input-wide" rows="2" placeholder="Short Description (e.g., Certified PM)..." required></textarea>

    <textarea name="impact" class="input input-wide" rows="2" placeholder="Impact / Key Outcomes (optional)"></textarea>

    <button type="submit" class="btn btn-add">+ Add Expertise</button>
  </form>

  <!-- 🔹 TABLE OF EXISTING ENTRIES -->
  <table class="admin-table">
    <thead>
      <tr>
        <th>#</th>
        <th>Title</th>
        <th>Subtitle</th>
        <th>Impact</th>
        <th>Status</th>
        <th>Visibility</th>
        <th>Created</th>
        <th>Visible</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($expertiseList as $i => $exp): ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td><?= htmlspecialchars($exp['title']) ?></td>
          <td><?= htmlspecialchars($exp['subtitle']) ?></td>
          <td><?= htmlspecialchars($exp['impact']) ?></td>
          <td><?= ucfirst($exp['status']) ?></td>
          <td><?= ucfirst($exp['visibility']) ?></td>
          <td><?= date('M d, Y', strtotime($exp['created_at'])) ?></td>
          <td><?= $exp['visible'] ? 'Yes' : 'No'; ?></td>
          <td>
            <a href="edit_expertise.php?id=<?= $exp['id'] ?>" class="btn btn-edit">Edit</a>
            <a href="manage_expertise.php?delete=<?= $exp['id'] ?>" class="btn btn-delete" onclick="return confirm('Delete this expertise?')">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <br><a href="dashboard.php">← Back to Dashboard</a>
</div>

<?php require_once 'includes/admin_footer.php'; ?>
