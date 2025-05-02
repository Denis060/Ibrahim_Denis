<?php
require_once 'includes/db.php';
require_once 'includes/header.php';

// Fetch all certifications ordered by issue_date
$stmt = $pdo->query("SELECT * FROM certifications ORDER BY issue_date DESC");
$certifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="education-section">
  <h2 class="section-title">Certifications & Credentials</h2>
  <div class="section-underline"></div>

  <div class="education-cards">
    <?php foreach ($certifications as $cert): ?>
      <div class="education-card">
        <div class="edu-header">
          <!-- Placeholder icon or logo -->
          <div class="edu-logo">
            <i class="fas fa-certificate fa-2x" style="color: var(--primary-color); margin-top: 10px;"></i>
          </div>

          <div class="edu-info">
            <!-- Certificate Title -->
            <h3 class="edu-institution"><?= htmlspecialchars($cert['title']) ?></h3>

            <!-- Issuer -->
            <p class="edu-degree"><?= htmlspecialchars($cert['issuer']) ?></p>

            <!-- Optional details -->
            <?php if (!empty($cert['details'])): ?>
              <p class="edu-details"><?= htmlspecialchars($cert['details']) ?></p>
            <?php endif; ?>

            <!-- Issue Date and Credential URL -->
            <div class="edu-meta">
              <span><i class="fas fa-calendar-alt"></i> <?= date('F Y', strtotime($cert['issue_date'])) ?></span>
              <?php if (!empty($cert['credential_url'])): ?>
                <span>
                  <i class="fas fa-external-link-alt"></i>
                  <a href="<?= htmlspecialchars($cert['credential_url']) ?>" target="_blank">View Credential</a>
                </span>
              <?php endif; ?>
            </div>
          </div>

          <!-- Expand/Collapse Button -->
          <button class="expand-btn"><i class="fas fa-chevron-down"></i></button>
        </div>

        <!-- Expandable Skills Section -->
        <div class="edu-expanded">
          <?php if (!empty($cert['skills'])): ?>
            <h4>Skills Acquired</h4>
            <div class="badge-container">
              <?php foreach (explode(',', $cert['skills']) as $skill): ?>
                <span class="badge"><?= htmlspecialchars(trim($skill)) ?></span>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>

<!-- Styles & Scripts -->
<link rel="stylesheet" href="assets/css/education.css"> <!-- You can reuse the same CSS -->
<script defer src="assets/js/education.js"></script>
