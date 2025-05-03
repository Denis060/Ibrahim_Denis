<?php
require_once 'includes/db.php';
require_once 'includes/header.php';

// Fetch all categories
$catStmt = $pdo->query("SELECT * FROM project_categories ORDER BY category_name ASC");
$categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="project-section">
  <!-- Section Title -->
  <h2 class="section-title">🚀 My Projects</h2>
  <div class="section-underline"></div>

  <!-- Search Bar -->
  <div class="project-search">
    <input type="text" id="projectSearchInput" placeholder="🔍 Search projects by title or tag...">
  </div>

  <!-- Loop Through Each Category -->
  <?php foreach ($categories as $cat): ?>
    <div class="project-category">
      <h3 class="category-title"><?= htmlspecialchars($cat['category_name']) ?></h3>

      <?php
        // Fetch projects by category
        $stmt = $pdo->prepare("SELECT * FROM projects WHERE category_id = ? ORDER BY created_at DESC");
        $stmt->execute([$cat['id']]);
        $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>

      <div class="project-cards">
        <?php foreach ($projects as $proj): ?>
          <div 
            class="project-card"
            data-title="<?= strtolower($proj['title']) ?>"
            data-tags="<?= strtolower($proj['tags']) ?>"
            data-category="<?= strtolower($cat['category_name']) ?>"
          >
            <!-- Card Header -->
            <div class="project-header">
              <div>
                <h4 class="project-title"><?= htmlspecialchars($proj['title']) ?></h4>
                <p class="project-meta">
                  <span class="status <?= strtolower($proj['status']) ?>">
                    <?= htmlspecialchars($proj['status']) ?>
                  </span>
                  <span class="type"><?= htmlspecialchars($proj['type']) ?></span>
                </p>

                <!-- Display Tags -->
                <div class="project-tags">
                  <?php foreach (explode(',', $proj['tags']) as $tag): ?>
                    <span class="tag"><?= htmlspecialchars(trim($tag)) ?></span>
                  <?php endforeach; ?>
                </div>
              </div>

              <!-- Expand/Collapse Button -->
              <button class="expand-btn" title="Expand project" aria-expanded="false">
                <i class="fas fa-chevron-down"></i>
              </button>
            </div>

            <!-- Expandable Project Details -->
            <div class="project-expanded">
              <!-- Overview Section -->
              <div class="section-block">
                <h5><i class="fas fa-search"></i> Overview</h5>
                <p><?= nl2br(htmlspecialchars($proj['overview'])) ?></p>
              </div>

              <!-- Key Features / Impact -->
              <?php if (!empty($proj['impact'])): ?>
                <div class="section-block">
                  <h5><i class="fas fa-check-circle"></i> Key Features</h5>
                  <ul class="feature-list">
                    <?php foreach (explode(';', $proj['impact']) as $feature): ?>
                      <li><i class="fas fa-check"></i> <?= htmlspecialchars(trim($feature)) ?></li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              <?php endif; ?>

              <!-- Tech Stack -->
              <?php if (!empty($proj['tech_stack'])): ?>
                <div class="section-block">
                  <h5><i class="fas fa-cogs"></i> Technical Stack</h5>
                  <p><?= htmlspecialchars($proj['tech_stack']) ?></p>
                </div>
              <?php endif; ?>

              <!-- Project Link -->
              <?php if (!empty($proj['preview_link'])): ?>
                <div class="section-block">
                  <a href="<?= htmlspecialchars($proj['preview_link']) ?>" class="project-link" target="_blank">
                    <i class="fas fa-external-link-alt"></i> View Project
                  </a>
                </div>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endforeach; ?>
</section>

<?php require_once 'includes/footer.php'; ?>

<!-- Page-specific Styles & JS -->
<link rel="stylesheet" href="assets/css/projects.css">
<script defer src="assets/js/projects.js"></script>
