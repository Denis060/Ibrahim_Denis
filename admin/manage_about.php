<?php
require_once '../includes/db.php';
require_once 'includes/admin_header.php';

// ✅ Get the about record (assumed single entry)
$about = $pdo->query("SELECT * FROM about WHERE id = 1")->fetch(PDO::FETCH_ASSOC);

// ✅ Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name']);
  $title = trim($_POST['title']);
  $summary = trim($_POST['summary']);
  $profile_picture = $about['profile_picture'];

  // ✅ Handle image upload
  if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
    $newName = time() . '_' . basename($_FILES['profile_picture']['name']);
    move_uploaded_file($_FILES['profile_picture']['tmp_name'], '../uploads/' . $newName);
    $profile_picture = $newName;
  }

  // ✅ Update About
  $stmt = $pdo->prepare("UPDATE about SET name=?, title=?, summary=?, profile_picture=?, updated_at=NOW() WHERE id=1");
  $stmt->execute([$name, $title, $summary, $profile_picture]);

  header("Location: manage_about.php?updated=1");
  exit;
}
?>

<div class="edit-project-container">
  <h2>🧑 About Me Section</h2>

  <?php if (isset($_GET['updated'])): ?>
    <div class="alert-success">✅ About section updated!</div>
  <?php endif; ?>

  <!-- 🔹 Edit About Form -->
  <form method="POST" enctype="multipart/form-data" class="form-column" style="margin-bottom: 25px;">
    <input type="text" name="name" class="input input-wide" value="<?= htmlspecialchars($about['name']) ?>" placeholder="Your Name" required>

    <input type="text" name="title" class="input input-wide" value="<?= htmlspecialchars($about['title']) ?>" placeholder="Your Title (e.g. Data Scientist)" required>

    <textarea name="summary" class="input input-wide" rows="5" placeholder="Write your personal summary..." required><?= htmlspecialchars($about['summary']) ?></textarea>

    <label>Profile Picture</label>
    <input type="file" name="profile_picture" class="input input-wide">

    <?php if ($about['profile_picture']): ?>
      <div style="margin-top: 10px;">
        <img src="../uploads/<?= $about['profile_picture'] ?>" alt="Current Picture" style="max-width: 150px; border-radius: 10px;">
      </div>
    <?php endif; ?>

    <button type="submit" class="btn btn-update">✏️ Update About</button>
  </form>

  <p><strong>Last Updated:</strong> <?= date('M d, Y H:i', strtotime($about['updated_at'])) ?></p>

  <br><a href="dashboard.php">← Back to Dashboard</a>
</div>

<?php require_once 'includes/admin_footer.php'; ?>
