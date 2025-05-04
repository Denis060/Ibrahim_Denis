<?php
require_once '../includes/db.php';
require_once 'includes/admin_header.php';

// Capture filter input
$selectedCategory = $_GET['category_id'] ?? '';

// Fetch project categories for dropdown
$catStmt = $pdo->query("SELECT * FROM project_categories ORDER BY category_name ASC");
$categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch filtered or all projects
$query = "SELECT p.*, c.category_name FROM projects p 
          LEFT JOIN project_categories c ON p.category_id = c.id";
$params = [];

if (!empty($selectedCategory)) {
  $query .= " WHERE p.category_id = ?";
  $params[] = $selectedCategory;
}

$query .= " ORDER BY p.created_at DESC";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="admin-container">
  <h2>📂 Manage Projects</h2>

  <!-- Filter Projects by Category -->
  <form method="GET" class="filter-form">
    <label for="category_id">Filter by Category:</label>
    <select name="category_id" id="category_id" onchange="this.form.submit()">
      <option value="">All Categories</option>
      <?php foreach ($categories as $cat): ?>
        <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $selectedCategory ? 'selected' : '' ?>>
          <?= htmlspecialchars($cat['category_name']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </form>

  <!-- Project Table -->
  <table class="admin-table">
    <thead>
      <tr>
        <th>Title</th>
        <th>Category</th>
        <th>Status</th>
        <th>Type</th>
        <th>Tags</th>
        <th>Created</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if (count($projects) > 0): ?>
        <?php foreach ($projects as $proj): ?>
          <tr>
            <td><?= htmlspecialchars($proj['title']) ?></td>
            <td><?= htmlspecialchars($proj['category_name'] ?? '—') ?></td>
            <td><span class="status-badge <?= strtolower($proj['status']) ?>"><?= htmlspecialchars($proj['status']) ?></span></td>
            <td><?= htmlspecialchars($proj['type']) ?></td>
            <td><?= htmlspecialchars($proj['tags']) ?></td>
            <td><?= date('M d, Y', strtotime($proj['created_at'])) ?></td>
            <td class="table-actions">
              <a href="edit_project.php?id=<?= $proj['id'] ?>" class="btn btn-edit">Edit</a>
              <a href="delete_project.php?id=<?= $proj['id'] ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this project?')">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="7" class="no-data">No projects found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

  <a href="add_project.php" class="btn btn-primary">+ Add New Project</a>
  <br><br>
  <a href="dashboard.php" class="btn btn-back">← Back to Dashboard</a>
</div>

<?php require_once 'includes/admin_footer.php'; ?>
