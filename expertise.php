<?php
require_once 'includes/db.php';
require_once 'includes/header.php';

// Fetch all visible expertise items from the database
$stmt = $pdo->prepare("SELECT * FROM expertise WHERE visible = 1 ORDER BY id ASC");
$stmt->execute();
$expertiseList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="expertise-section">
  <h2 class="section-title"><i class="fas fa-bolt"></i> Key Competencies</h2>
  <div class="section-underline"></div>

  <!-- Search Input -->
  <div class="expertise-search">
    <input type="text" id="expertiseSearchInput" placeholder="Search competencies... (Ctrl+K)">
  </div>

  <div class="expertise-cards">
    <?php foreach ($expertiseList as $item): ?>
      <div class="expertise-card">
        <!-- Header section -->
        <div class="expertise-header">
          <div class="expertise-icon">
            <!-- FontAwesome icon from DB or fallback -->
            <i class="<?= htmlspecialchars($item['icon_class'] ?? 'fas fa-star') ?>"></i>
            </div>

            <div class="expertise-info">
                <h3 class="expertise-title"><?= htmlspecialchars($item['title']) ?></h3>
                <p class="expertise-summary"><?= htmlspecialchars($item['subtitle']) ?></p>
            </div>

          <!-- Expand/Collapse toggle -->
          <button class="expand-btn" title="Expand"><i class="fas fa-chevron-down"></i></button>
        </div>

        <!-- Expanded Details -->
        <div class="expertise-expanded">
          <?php if (!empty($item['core_expertise'])): ?>
            <div class="section-block">
              <h4><i class="fas fa-lightbulb"></i> Core Expertise</h4>
              <ul class="feature-list">
                <?php foreach (explode(';', $item['core_expertise']) as $core): ?>
                  <li><i class="fas fa-circle-check"></i> <?= htmlspecialchars(trim($core)) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <?php if (!empty($item['key_achievements'])): ?>
            <div class="section-block">
              <h4><i class="fas fa-trophy"></i> Key Achievements</h4>
              <ul class="feature-list">
                <?php foreach (explode(';', $item['key_achievements']) as $achieve): ?>
                  <li><i class="fas fa-circle-check"></i> <?= htmlspecialchars(trim($achieve)) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <?php if (!empty($item['impact'])): ?>
            <div class="impact-box">
              <h4><i class="fas fa-bolt"></i> Impact</h4>
              <p><?= nl2br(htmlspecialchars($item['impact'])) ?></p>
            </div>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>

<!-- Include CSS & JavaScript -->
<link rel="stylesheet" href="assets/css/expertise.css">
<script defer src="assets/js/expertise.js"></script>
