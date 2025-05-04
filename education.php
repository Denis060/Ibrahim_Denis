<?php
require_once 'includes/db.php';
require_once 'includes/header.php';

// Fetch all education entries
$educationStmt = $pdo->query("SELECT * FROM education ORDER BY start_year DESC");
$educations = $educationStmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare nested structure: education → categories → courses
$educationData = [];

foreach ($educations as $edu) {
  $education_id = $edu['id'];

  // Fetch categories for this education
  $catStmt = $pdo->prepare("SELECT * FROM course_categories WHERE education_id = ?");
  $catStmt->execute([$education_id]);
  $categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);

  // Fetch courses for each category
  foreach ($categories as &$category) {
    $cat_id = $category['id'];
    $courseStmt = $pdo->prepare("SELECT * FROM courses WHERE category_id = ?");
    $courseStmt->execute([$cat_id]);
    $category['courses'] = $courseStmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Assign categories to current education entry
  $edu['categories'] = $categories;
  $educationData[] = $edu;
}
?>

<section class="education-section">
  <h2 class="section-title">🎓 Educational Journey</h2>
  <div class="section-underline"></div>

  <div class="education-cards">
    <?php foreach ($educationData as $edu): ?>
      <div class="education-card"> <!-- Full card wrapper -->

        <!-- Header Section -->
        <div class="edu-header">
          <!-- School Logo -->
          <img src="uploads/<?= htmlspecialchars($edu['logo']) ?>" class="edu-logo" alt="<?= htmlspecialchars($edu['institution']) ?> Logo">

          <!-- School Info -->
          <div class="edu-info">
            <h3 class="edu-institution"><?= htmlspecialchars($edu['institution']) ?></h3>
            <p class="edu-degree"><?= htmlspecialchars($edu['degree']) ?> in <?= htmlspecialchars($edu['field']) ?></p>

            <?php if (!empty($edu['details'])): ?>
              <p class="edu-details"><?= htmlspecialchars($edu['details']) ?></p>
            <?php endif; ?>

            <div class="edu-meta">
              <span><i class="fas fa-calendar-alt"></i> <?= $edu['start_year'] ?> - <?= $edu['end_year'] ?></span>
              <span><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($edu['location']) ?></span>
            </div>
          </div>

          <!-- Expand/Collapse Toggle -->
          <button class="expand-btn"><i class="fas fa-chevron-down"></i></button>
        </div>

        <!-- Expandable Section (Courses per Category) -->
        <div class="edu-expanded">
          <?php foreach ($edu['categories'] as $cat): ?>
            <div class="course-category">
              <h4><?= htmlspecialchars($cat['category_name']) ?></h4>
              <ul>
                <?php foreach ($cat['courses'] as $course): ?>
                  <li>
                    <strong><?= htmlspecialchars($course['course_name']) ?></strong><br>
                    <small><?= htmlspecialchars($course['specialization']) ?></small>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endforeach; ?>
        </div>

      </div> <!-- End of .education-card -->
    <?php endforeach; ?>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>

<!-- Page-specific assets -->
<link rel="stylesheet" href="assets/css/education.css">
<script>// education.js

document.addEventListener('DOMContentLoaded', function () {
  const expandButtons = document.querySelectorAll('.expand-btn');

  expandButtons.forEach(button => {
    button.addEventListener('click', function () {
      const card = this.closest('.education-card');
      card.classList.toggle('expanded');

      const icon = this.querySelector('i');
      icon.classList.toggle('fa-chevron-down');
      icon.classList.toggle('fa-chevron-up');
    });
  });
});
</script>
<script defer src="assets/js/education.js"></script>
