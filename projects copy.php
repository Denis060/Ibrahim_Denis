<?php
require_once 'includes/db.php';
require_once 'includes/header.php';

// Fetch all categories
$catStmt = $pdo->query("SELECT * FROM project_categories ORDER BY category_name ASC");
$categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="project-section">
  <h2 class="section-title">My Projects</h2>
  <div class="section-underline"></div>

  <?php foreach ($categories as $cat): ?>
    <div class="project-category">
      <h3 class="category-title"><?= htmlspecialchars($cat['category_name']) ?></h3>

      <?php
        $stmt = $pdo->prepare("SELECT * FROM projects WHERE category_id = ? ORDER BY created_at DESC");
        $stmt->execute([$cat['id']]);
        $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>

      <div class="project-cards">
        <?php foreach ($projects as $proj): ?>
          <div class="project-card">
            <div class="project-header">
              <div>
                <h4 class="project-title"><?= htmlspecialchars($proj['title']) ?></h4>
                <p class="project-meta">
                  <strong><?= htmlspecialchars($proj['type']) ?></strong> • 
                  <?= htmlspecialchars($proj['status']) ?>
                </p>
              </div>

              <button class="expand-btn"><i class="fas fa-chevron-down"></i></button>
            </div>

            <div class="project-expanded">
              <p class="project-overview"><?= nl2br(htmlspecialchars($proj['overview'])) ?></p>

              <?php if (!empty($proj['impact'])): ?>
                <p><strong>Impact:</strong> <?= nl2br(htmlspecialchars($proj['impact'])) ?></p>
              <?php endif; ?>

              <?php if (!empty($proj['tech_stack'])): ?>
                <p><strong>Tech Stack:</strong> <?= htmlspecialchars($proj['tech_stack']) ?></p>
              <?php endif; ?>

              <?php if (!empty($proj['preview_link'])): ?>
                <a href="<?= htmlspecialchars($proj['preview_link']) ?>" class="project-link" target="_blank">
                  <i class="fas fa-external-link-alt"></i> View Project
                </a>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endforeach; ?>
</section>

<?php require_once 'includes/footer.php'; ?>

<!-- Page-specific CSS + JS -->
<link rel="stylesheet" href="assets/css/projects.css">
<script defer src="assets/js/projects.js"></script>
