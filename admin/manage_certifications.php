<?php
require_once '../includes/db.php';
require_once 'includes/admin_header.php';

$edit_mode = false;
$edit_data = [];

// ✅ Handle delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
  $stmt = $pdo->prepare("DELETE FROM certifications WHERE id = ?");
  $stmt->execute([$_GET['delete']]);
  header("Location: manage_certifications.php?deleted=1");
  exit;
}

// ✅ Handle edit view
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
  $stmt = $pdo->prepare("SELECT * FROM certifications WHERE id = ?");
  $stmt->execute([$_GET['edit']]);
  $edit_data = $stmt->fetch(PDO::FETCH_ASSOC);
  $edit_mode = true;
}

// ✅ Handle add or update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = trim($_POST['title']);
  $issuer = trim($_POST['issuer']);
  $issue_date = $_POST['issue_date'];
  $skills = trim($_POST['skills']);
  $details = trim($_POST['details']);
  $credential_url = trim($_POST['credential_url']);

  // ✅ Handle image upload
  $certificate_img = $edit_mode ? $edit_data['certificate_img'] : '';
  if (isset($_FILES['certificate_img']) && $_FILES['certificate_img']['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES['certificate_img']['name'], PATHINFO_EXTENSION);
    $newName = time() . '_' . basename($_FILES['certificate_img']['name']);
    move_uploaded_file($_FILES['certificate_img']['tmp_name'], '../uploads/' . $newName);
    $certificate_img = $newName;
  }

  if ($edit_mode) {
    $stmt = $pdo->prepare("UPDATE certifications SET title=?, issuer=?, issue_date=?, skills=?, details=?, credential_url=?, certificate_img=? WHERE id=?");
    $stmt->execute([$title, $issuer, $issue_date, $skills, $details, $credential_url, $certificate_img, $_POST['id']]);
    header("Location: manage_certifications.php?updated=1");
    exit;
  } else {
    $stmt = $pdo->prepare("INSERT INTO certifications (title, issuer, issue_date, skills, details, credential_url, certificate_img) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$title, $issuer, $issue_date, $skills, $details, $credential_url, $certificate_img]);
    header("Location: manage_certifications.php?added=1");
    exit;
  }
}

// ✅ Fetch all certifications
$certs = $pdo->query("SELECT * FROM certifications ORDER BY issue_date DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="edit-project-container">
  <h2>📜 Manage Certifications</h2>

  <?php if (isset($_GET['added'])): ?>
    <div class="alert-success">✅ Certification added.</div>
  <?php elseif (isset($_GET['updated'])): ?>
    <div class="alert-success">✏️ Certification updated.</div>
  <?php elseif (isset($_GET['deleted'])): ?>
    <div class="alert-success">🗑️ Certification deleted.</div>
  <?php endif; ?>

  <!-- 🔹 Certification Form -->
  <form method="POST" enctype="multipart/form-data" class="form-column" style="margin-bottom: 25px;">
    <input type="hidden" name="id" value="<?= $edit_data['id'] ?? '' ?>">

    <input type="text" name="title" class="input input-wide" placeholder="Certificate Title" value="<?= $edit_data['title'] ?? '' ?>" required>

    <input type="text" name="issuer" class="input input-wide" placeholder="Issuer (e.g., Coursera)" value="<?= $edit_data['issuer'] ?? '' ?>" required>

    <label>Issue Date</label>
    <input type="date" name="issue_date" class="input input-wide" value="<?= $edit_data['issue_date'] ?? '' ?>" required>

    <textarea name="skills" class="input input-wide" rows="2" placeholder="Skills Gained"><?= $edit_data['skills'] ?? '' ?></textarea>

    <textarea name="details" class="input input-wide" rows="2" placeholder="Extra Details (optional)"><?= $edit_data['details'] ?? '' ?></textarea>

    <input type="url" name="credential_url" class="input input-wide" placeholder="Credential URL" value="<?= $edit_data['credential_url'] ?? '' ?>">

    <label>Certificate Image</label>
    <input type="file" name="certificate_img" class="input input-wide">

    <?php if ($edit_mode && $edit_data['certificate_img']): ?>
      <img src="../uploads/<?= $edit_data['certificate_img'] ?>" alt="Certificate Preview" style="max-width: 150px; margin-top: 10px;">
    <?php endif; ?>

    <?php if ($edit_mode): ?>
      <button type="submit" class="btn btn-update">✏️ Update Certificate</button>
      <a href="manage_certifications.php" class="btn btn-cancel">Cancel</a>
    <?php else: ?>
      <button type="submit" class="btn btn-add">+ Add Certification</button>
    <?php endif; ?>
  </form>

  <!-- 🔹 Certification Table -->
  <table class="admin-table">
    <thead>
      <tr>
        <th>#</th>
        <th>Title</th>
        <th>Issuer</th>
        <th>Date</th>
        <th>Skills</th>
        <th>Credential</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($certs as $i => $c): ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td><?= htmlspecialchars($c['title']) ?></td>
          <td><?= htmlspecialchars($c['issuer']) ?></td>
          <td><?= $c['issue_date'] ?></td>
          <td><?= htmlspecialchars($c['skills']) ?></td>
          <td>
            <?php if ($c['credential_url']): ?>
              <a href="<?= $c['credential_url'] ?>" target="_blank">🌐 View</a>
            <?php else: ?>
              —
            <?php endif; ?>
          </td>
          <td>
            <a href="?edit=<?= $c['id'] ?>" class="btn btn-edit">Edit</a>
            <a href="?delete=<?= $c['id'] ?>" class="btn btn-delete" onclick="return confirm('Delete this certificate?')">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <br><a href="dashboard.php">← Back to Dashboard</a>
</div>

<?php require_once 'includes/admin_footer.php'; ?>
