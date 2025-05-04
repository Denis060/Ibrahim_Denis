<?php
require_once '../includes/db.php';
require_once 'includes/admin_header.php';

$uploadDir = '../uploads/';
$files = array_diff(scandir($uploadDir), ['.', '..']);

// ✅ Handle file deletion
if (isset($_GET['delete'])) {
  $filename = basename($_GET['delete']);
  $filePath = $uploadDir . $filename;

  if (file_exists($filePath)) {
    unlink($filePath);
    header("Location: manage_files.php?deleted=1");
    exit;
  }
}
?>

<div class="edit-project-container">
  <h2>📂 File Manager</h2>

  <?php if (isset($_GET['deleted'])): ?>
    <div class="alert-success">🗑️ File deleted successfully.</div>
  <?php endif; ?>

  <?php if (empty($files)): ?>
    <p>No files in the upload folder.</p>
  <?php else: ?>
    <table class="admin-table">
      <thead>
        <tr>
          <th>Preview</th>
          <th>Filename</th>
          <th>Size</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($files as $file): 
          $filePath = $uploadDir . $file;
          $size = round(filesize($filePath) / 1024, 2); // KB
          $isImage = preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file);
        ?>
          <tr>
            <td>
              <?php if ($isImage): ?>
                <img src="<?= $uploadDir . $file ?>" style="max-height: 50px; border-radius: 6px;">
              <?php else: ?>
                📄
              <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($file) ?></td>
            <td><?= $size ?> KB</td>
            <td>
              <a href="?delete=<?= urlencode($file) ?>" class="btn btn-delete" onclick="return confirm('Delete this file?')">Delete</a>
              <a href="<?= $uploadDir . $file ?>" class="btn btn-edit" target="_blank">View</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <br><a href="dashboard.php">← Back to Dashboard</a>
</div>

<?php require_once 'includes/admin_footer.php'; ?>
