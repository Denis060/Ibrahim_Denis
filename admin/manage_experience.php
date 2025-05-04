<?php
require_once '../includes/db.php';
require_once 'includes/admin_header.php';

$edit_mode = false;
$edit_data = [];

// ✅ Handle delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
  $stmt = $pdo->prepare("DELETE FROM experience WHERE id = ?");
  $stmt->execute([$_GET['delete']]);
  header("Location: manage_experience.php?deleted=1");
  exit;
}

// ✅ Edit mode: load data
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
  $stmt = $pdo->prepare("SELECT * FROM experience WHERE id = ?");
  $stmt->execute([$_GET['edit']]);
  $edit_data = $stmt->fetch(PDO::FETCH_ASSOC);
  $edit_mode = true;
}

// ✅ Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $company     = trim($_POST['company']);
  $role        = trim($_POST['role']);
  $type        = $_POST['type'];
  $location    = trim($_POST['location']);
  $start_date  = $_POST['start_date'];
  $end_date    = $_POST['is_current'] ? '0000-00-00' : $_POST['end_date'];
  $is_current  = isset($_POST['is_current']) ? 1 : 0;
  $description = trim($_POST['description']);
  $technologies = trim($_POST['technologies']);

  // ✅ Handle logo upload
  $logo = $edit_mode ? $edit_data['logo'] : '';
  if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
    $newName = time() . '_' . basename($_FILES['logo']['name']);
    move_uploaded_file($_FILES['logo']['tmp_name'], '../uploads/' . $newName);
    $logo = $newName;
  }

  // ✅ Insert or update
  if ($edit_mode) {
    $stmt = $pdo->prepare("UPDATE experience SET company=?, role=?, type=?, location=?, start_date=?, end_date=?, is_current=?, description=?, logo=?, technologies=? WHERE id=?");
    $stmt->execute([$company, $role, $type, $location, $start_date, $end_date, $is_current, $description, $logo, $technologies, $_POST['id']]);
    header("Location: manage_experience.php?updated=1");
    exit;
  } else {
    $stmt = $pdo->prepare("INSERT INTO experience (company, role, type, location, start_date, end_date, is_current, description, logo, technologies) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$company, $role, $type, $location, $start_date, $end_date, $is_current, $description, $logo, $technologies]);
    header("Location: manage_experience.php?added=1");
    exit;
  }
}

// ✅ Fetch all experience
$experiences = $pdo->query("SELECT * FROM experience ORDER BY start_date DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="edit-project-container">
  <h2>💼 Manage Experience</h2>

  <?php if (isset($_GET['added'])): ?>
    <div class="alert-success">✅ Experience added.</div>
  <?php elseif (isset($_GET['updated'])): ?>
    <div class="alert-success">✏️ Experience updated.</div>
  <?php elseif (isset($_GET['deleted'])): ?>
    <div class="alert-success">🗑️ Experience deleted.</div>
  <?php endif; ?>

  <!-- 🔹 Add/Edit Form -->
  <form method="POST" enctype="multipart/form-data" class="form-column" style="margin-bottom: 25px;">
    <input type="hidden" name="id" value="<?= $edit_data['id'] ?? '' ?>">

    <input type="text" name="company" class="input input-wide" placeholder="Company Name" value="<?= $edit_data['company'] ?? '' ?>" required>

    <input type="text" name="role" class="input input-wide" placeholder="Your Role" value="<?= $edit_data['role'] ?? '' ?>" required>

    <select name="type" class="input input-wide" required>
      <?php
      $types = ['Internship', 'Full-time', 'Freelance', 'Volunteer', 'Part-time', 'Contract'];
      foreach ($types as $t):
        $selected = ($edit_data['type'] ?? '') === $t ? 'selected' : '';
      ?>
        <option value="<?= $t ?>" <?= $selected ?>><?= $t ?></option>
      <?php endforeach; ?>
    </select>

    <input type="text" name="location" class="input input-wide" placeholder="Location (e.g., Remote, NYC)" value="<?= $edit_data['location'] ?? '' ?>" required>

    <label>Start Date</label>
    <input type="date" name="start_date" class="input input-wide" value="<?= $edit_data['start_date'] ?? '' ?>" required>

    <label>End Date</label>
    <input type="date" name="end_date" class="input input-wide" value="<?= ($edit_data['end_date'] ?? '') !== '0000-00-00' ? $edit_data['end_date'] ?? '' : '' ?>">

    <label><input type="checkbox" name="is_current" <?= !empty($edit_data['is_current']) ? 'checked' : '' ?>> I currently work here</label>

    <textarea name="description" class="input input-wide" rows="3" placeholder="What did you do?"><?= $edit_data['description'] ?? '' ?></textarea>

    <input type="text" name="technologies" class="input input-wide" placeholder="Tools used (e.g., Python, SQL, Tableau)" value="<?= $edit_data['technologies'] ?? '' ?>">

    <label>Logo (optional)</label>
    <input type="file" name="logo" class="input input-wide">

    <?php if ($edit_mode): ?>
      <button type="submit" class="btn btn-update">✏️ Update Experience</button>
      <a href="manage_experience.php" class="btn btn-cancel">Cancel</a>
    <?php else: ?>
      <button type="submit" class="btn btn-add">+ Add Experience</button>
    <?php endif; ?>
  </form>

  <!-- 🔹 Table -->
  <table class="admin-table">
    <thead>
      <tr>
        <th>#</th>
        <th>Company</th>
        <th>Role</th>
        <th>Type</th>
        <th>Dates</th>
        <th>Location</th>
        <th>Tools</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($experiences as $i => $e): ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td><?= htmlspecialchars($e['company']) ?></td>
          <td><?= htmlspecialchars($e['role']) ?></td>
          <td><?= $e['type'] ?></td>
          <td>
            <?= $e['start_date'] ?> - <?= $e['is_current'] ? 'Present' : $e['end_date'] ?>
          </td>
          <td><?= htmlspecialchars($e['location']) ?></td>
          <td><?= htmlspecialchars($e['technologies']) ?></td>
          <td>
            <a href="?edit=<?= $e['id'] ?>" class="btn btn-edit">Edit</a>
            <a href="?delete=<?= $e['id'] ?>" class="btn btn-delete" onclick="return confirm('Delete this experience?')">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <br><a href="dashboard.php">← Back to Dashboard</a>
</div>

<?php require_once 'includes/admin_footer.php'; ?>
