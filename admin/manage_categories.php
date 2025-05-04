<?php
require_once '../includes/db.php';
require_once 'includes/admin_header.php';

// ✅ Handle deletion
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
  $pdo->prepare("DELETE FROM project_categories WHERE id = ?")->execute([$_GET['delete']]);
  header("Location: manage_categories.php?deleted=1");
  exit;
}

// ✅ Handle form submission (add or update)
$edit_mode = false;
$edit_category = ['id' => null, 'category_name' => ''];

if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
  $stmt = $pdo->prepare("SELECT * FROM project_categories WHERE id = ?");
  $stmt->execute([$_GET['edit']]);
  $edit_category = $stmt->fetch(PDO::FETCH_ASSOC);
  $edit_mode = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $category_name = trim($_POST['category_name']);

  if (!empty($category_name)) {
    if (isset($_POST['category_id']) && is_numeric($_POST['category_id'])) {
      // UPDATE
      $stmt = $pdo->prepare("UPDATE project_categories SET category_name = ? WHERE id = ?");
      $stmt->execute([$category_name, $_POST['category_id']]);
      header("Location: manage_categories.php?updated=1");
      exit;
    } else {
      // INSERT
      $stmt = $pdo->prepare("INSERT INTO project_categories (category_name) VALUES (?)");
      $stmt->execute([$category_name]);
      header("Location: manage_categories.php?added=1");
      exit;
    }
  }
}

// ✅ Fetch all categories
$categories = $pdo->query("SELECT * FROM project_categories ORDER BY category_name ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="edit-project-container">
  <h2>📁 Manage Project Categories</h2>

  <?php if (isset($_GET['added'])): ?>
    <div class="alert-success">✅ Category added.</div>
  <?php elseif (isset($_GET['deleted'])): ?>
    <div class="alert-success">🗑️ Category deleted.</div>
  <?php elseif (isset($_GET['updated'])): ?>
    <div class="alert-success">✏️ Category updated.</div>
  <?php endif; ?>

  <!-- 🔹 Form: Add or Edit -->
  <form method="POST" class="form-column" style="margin-bottom: 25px;">
    <input type="text" name="category_name" class="input input-wide" value="<?= htmlspecialchars($edit_category['category_name']) ?>" placeholder="Category name..." required>
    <?php if ($edit_mode): ?>
      <input type="hidden" name="category_id" value="<?= $edit_category['id'] ?>">
      <button type="submit" class="btn btn-update">✏️ Update Category</button>
      <a href="manage_categories.php" class="btn btn-cancel">Cancel</a>
    <?php else: ?>
      <button type="submit" class="btn btn-add">+ Add Category</button>
    <?php endif; ?>
  </form>

  <!-- 🔹 Table -->
  <table class="admin-table">
    <thead>
      <tr>
        <th>#</th>
        <th>Category</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($categories as $i => $cat): ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td><?= htmlspecialchars($cat['category_name']) ?></td>
          <td>
            <a href="?edit=<?= $cat['id'] ?>" class="btn btn-edit">Edit</a>
            <a href="?delete=<?= $cat['id'] ?>" class="btn btn-delete" onclick="return confirm('Delete this category?')">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <br><a href="dashboard.php">← Back to Dashboard</a>
</div>

<?php require_once 'includes/admin_footer.php'; ?>
