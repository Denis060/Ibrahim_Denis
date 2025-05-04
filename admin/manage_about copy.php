<?php
require_once '../includes/db.php';
require_once 'includes/admin_header.php';

$about = $pdo->query("SELECT * FROM about WHERE id = 1")->fetch(PDO::FETCH_ASSOC);

// ✅ Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name']);
  $title = trim($_POST['title']);
  $summary = trim($_POST['summary']);

  // Handle file upload
  $profile_picture = $about['profile_picture']; // Default to current image
  if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
    $newName = uniqid() . '.' . $ext;
    $destination = '../uploads/' . $newName;
    move_uploaded_file($_FILES['profile_picture']['tmp_name'], $destination);
    $profile_picture = $newName;
  }

  // Update DB
  $stmt = $pdo->prepare("UPDATE about SET name = ?, title = ?, summary = ?, profile_picture = ?, updated_at = NOW() WHERE id = 1");
  $stmt->execute([$name, $title, $summary, $profile_picture]);

  header("Location: manage_about.php?updated=1");
  exit;
}
?>

<div class="edit-project-container">
  <h2>🧑 Manage About Section</h2>

  <?php if (isset($_GET['updated'])): ?>
    <div class="alert-success">✅ About updated successfully.</div>
  <?php endif; ?>

  <!-- 🔹 ABOUT FORM -->
  <form method="POST" enctype="multipart/form-data" class="form-column">
    <!-- Full Name -->
    <label><strong>Full Name</strong></label>
    <input type="text" name="name" class="input input-wide" value="<?= htmlspecialchars($about['name'] ?? '') ?>" required>

    <!-- Title -->
    <label><strong>Title / Tagline</strong></label>
    <input type="text" name="title" class="input input-wide" value="<?= htmlspecialchars($about['title'] ?? '') ?>" required>

    <!-- Profile Picture Upload -->
    <label><strong>Upload Profile Photo</strong></label>
    <input type="file" name="profile_picture" class="input input-wide">

    <?php if (!empty($about['profile_picture'])): ?>
      <div style="margin-top: 10px;">
        <img src="../uploads/<?= htmlspecialchars($about['profile_picture']) ?>" alt="Current Photo" style="max-height: 150px; border-radius: 8px;">
      </div>
    <?php endif; ?>

    <!-- Summary -->
    <label><strong>Markdown Summary</strong></label>
    <textarea name="summary" id="markdownInput" class="input input-wide" rows="10" oninput="updatePreview()" required><?= htmlspecialchars($about['summary'] ?? '') ?></textarea>

    <button type="submit" class="btn btn-add">💾 Save Changes</button>
  </form>

  <!-- 🔍 Live Markdown Preview -->
  <div style="margin-top: 30px;">
    <h3>🔍 Live Preview</h3>
    <div id="preview" style="padding: 15px; background: #1e293b; border-radius: 8px; color: #f1f5f9;"></div>
  </div>
</div>

<!-- ✅ Markdown Preview Script -->
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
function updatePreview() {
  const input = document.getElementById('markdownInput').value;
  document.getElementById('preview').innerHTML = marked.parse(input);
}
window.onload = updatePreview;
</script>

<?php require_once 'includes/admin_footer.php'; ?>
