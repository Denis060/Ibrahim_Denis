<?php
require_once '../includes/db.php';
require_once 'includes/admin_header.php';

// ✅ Handle deletion
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $pdo->prepare("DELETE FROM course_categories WHERE id = ?")->execute([$_GET['delete']]);
    header("Location: manage_course_categories.php?deleted=1");
    exit;
}

// ✅ Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $education_id = intval($_POST['education_id']);
    $category_name = trim($_POST['category_name']);

    if ($education_id && $category_name) {
        $stmt = $pdo->prepare("INSERT INTO course_categories (education_id, category_name) VALUES (?, ?)");
        $stmt->execute([$education_id, $category_name]);
        header("Location: manage_course_categories.php?added=1");
        exit;
    }
}

// ✅ Fetch dropdown options
$educations = $pdo->query("SELECT id, institution FROM education ORDER BY start_year DESC")->fetchAll(PDO::FETCH_ASSOC);

// ✅ Fetch category list with JOIN
$stmt = $pdo->query("
  SELECT cc.id, cc.category_name, e.institution 
  FROM course_categories cc
  JOIN education e ON cc.education_id = e.id
  ORDER BY e.start_year DESC, cc.category_name ASC
");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="edit-project-container">
  <h2>📚 Manage Course Categories</h2>

  <?php if (isset($_GET['added'])): ?>
    <div class="alert-success">✅ Course category added.</div>
  <?php elseif (isset($_GET['deleted'])): ?>
    <div class="alert-success">🗑️ Category deleted.</div>
  <?php endif; ?>

  <!-- 🔹 Add Course Category -->
  <form method="POST" class="form-column" style="margin-bottom: 20px;">
    <label>Select Education Program</label>
    <select name="education_id" class="input input-wide" required>
      <option value="">-- Select Education --</option>
      <?php foreach ($educations as $edu): ?>
        <option value="<?= $edu['id'] ?>"><?= htmlspecialchars($edu['institution']) ?></option>
      <?php endforeach; ?>
    </select>

    <input type="text" name="category_name" class="input input-wide" placeholder="New Course Category..." required>
    <button type="submit" class="btn btn-add">+ Add Course Category</button>
  </form>

  <!-- 🔹 Table -->
  <table class="admin-table">
    <thead>
      <tr>
        <th>#</th>
        <th>Education</th>
        <th>Course Category</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($categories as $i => $cat): ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td><?= htmlspecialchars($cat['institution']) ?></td>
          <td><?= htmlspecialchars($cat['category_name']) ?></td>
          <td>
            <a href="?delete=<?= $cat['id'] ?>" class="btn btn-delete" onclick="return confirm('Delete this category?')">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <br><a href="dashboard.php">← Back to Dashboard</a>
</div>

<?php require_once 'includes/admin_footer.php'; ?>
