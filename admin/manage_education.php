<?php
require_once '../includes/db.php';
require_once 'includes/admin_header.php';

// Handle new entry submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $institution = trim($_POST['institution']);
  $degree = trim($_POST['degree']);
  $field = trim($_POST['field']);
  $start_year = intval($_POST['start_year']);
  $end_year = intval($_POST['end_year']);
  $location = trim($_POST['location']);
  $details = trim($_POST['details']);

  $logoPath = null;

  // Upload logo file
  if (!empty($_FILES['logo']['name']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../uploads/logos/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $tmpName = $_FILES['logo']['tmp_name'];
    $safeName = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($_FILES['logo']['name']));
    $destination = $uploadDir . $safeName;

    if (move_uploaded_file($tmpName, $destination)) {
      $logoPath = 'uploads/logos/' . $safeName;
    }
  }

  if ($institution && $degree && $start_year) {
    $stmt = $pdo->prepare("INSERT INTO education (institution, degree, field, start_year, end_year, location, details, logo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$institution, $degree, $field, $start_year, $end_year, $location, $details, $logoPath]);
    header("Location: manage_education.php");
    exit;
  }
}

// Handle deletion
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
  $pdo->prepare("DELETE FROM education WHERE id = ?")->execute([$_GET['delete']]);
  header("Location: manage_education.php");
  exit;
}

// Fetch existing entries
$entries = $pdo->query("SELECT * FROM education ORDER BY start_year DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="admin-section">
  <h2>🎓 Manage Education</h2>

  <!-- ADD FORM -->
  <form method="POST" enctype="multipart/form-data" class="form-column" style="margin-bottom: 25px;">
    <div class="form-row">
      <input type="text" name="institution" class="input input-wide" placeholder="Institution" required>
      <input type="text" name="degree" class="input input-medium" placeholder="Degree" required>
      <input type="text" name="field" class="input input-medium" placeholder="Field of Study">
    </div>

    <div class="form-row">
      <input type="number" name="start_year" class="input input-small" placeholder="Start Year" required>
      <input type="number" name="end_year" class="input input-small" placeholder="End Year">
      <input type="text" name="location" class="input input-wide" placeholder="Location (e.g., New York)">
    </div>

    <div class="form-row">
      <input type="file" name="logo" class="input input-medium" accept="image/*">
      <textarea name="details" class="input input-wide" rows="2" placeholder="Details or summary (optional)..."></textarea>
      <button type="submit" class="btn btn-add">+ Add Education</button>
    </div>
  </form>

  <!-- TABLE -->
  <table class="admin-table">
    <thead>
      <tr>
        <th>#</th>
        <th>Logo</th>
        <th>Institution</th>
        <th>Degree</th>
        <th>Years</th>
        <th>Location</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($entries as $i => $edu): ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td>
            <?php if (!empty($edu['logo']) && file_exists('../' . $edu['logo'])): ?>
              <img src="../<?= htmlspecialchars($edu['logo']) ?>" alt="Logo" style="max-height: 40px; border-radius: 6px;">
            <?php else: ?>
              <span style="color: #999;">No Logo</span>
            <?php endif; ?>
          </td>
          <td><?= htmlspecialchars($edu['institution']) ?></td>
          <td><?= htmlspecialchars($edu['degree']) ?></td>
          <td><?= $edu['start_year'] ?> - <?= $edu['end_year'] ?: 'Present' ?></td>
          <td><?= htmlspecialchars($edu['location']) ?></td>
          <td>
            <!-- ✏️ Edit Button -->
            <a href="edit_education.php?id=<?= $edu['id'] ?>" class="btn btn-edit">Edit</a>
            
            <!-- 🗑️ Delete Button -->
            <a href="?delete=<?= $edu['id'] ?>" class="btn btn-delete" onclick="return confirm('Delete this entry?')">Delete</a>
            </td>

                    </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <br><a href="dashboard.php">← Back to Dashboard</a>
</div>

<?php require_once 'includes/admin_footer.php'; ?>
