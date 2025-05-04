<?php
require_once '../includes/db.php';
require_once 'includes/header.php';

// ✅ Overview Counts
$totals = [
  'projects'       => $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn(),
  'experience'     => $pdo->query("SELECT COUNT(*) FROM experience")->fetchColumn(),
  'education'      => $pdo->query("SELECT COUNT(*) FROM education")->fetchColumn(),
  'recognition'    => $pdo->query("SELECT COUNT(*) FROM recognition")->fetchColumn(),
  'certifications' => $pdo->query("SELECT COUNT(*) FROM certifications")->fetchColumn(),
  'admins'         => $pdo->query("SELECT COUNT(*) FROM admins")->fetchColumn()
];

// ✅ Recent Activity
$recent_projects = $pdo->query("SELECT title, created_at FROM projects ORDER BY created_at DESC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);
$recent_experience = $pdo->query("SELECT role, company, start_date FROM experience ORDER BY start_date DESC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);

// ✅ Charts Data
$projectsByYear = $pdo->query("
  SELECT YEAR(created_at) AS year, COUNT(*) AS count
  FROM projects
  GROUP BY year
  ORDER BY year
")->fetchAll(PDO::FETCH_KEY_PAIR);

$expertiseData = $pdo->query("
  SELECT title, COUNT(*) AS count
  FROM expertise
  GROUP BY title
  ORDER BY count DESC
  LIMIT 5
")->fetchAll(PDO::FETCH_KEY_PAIR);
?>

<!-- 🌍 Public Preview Button -->
<div style="text-align: right; margin-bottom: 15px;">
  <a href="../index.php" target="_blank" class="btn btn-preview">🌍 View Public Site</a>
</div>

<!-- 🌙 Dark Mode Toggle -->
<div class="theme-toggle">
  <label class="switch">
    <input type="checkbox" id="themeToggle">
    <span class="slider round"></span>
  </label>
  <span id="modeLabel">🌙 Dark</span>
</div>

<div class="edit-project-container">
  <h2>📊 Admin Dashboard</h2>

  <!-- 🔹 Overview Stats -->
  <div class="dashboard-grid">
    <?php foreach ($totals as $key => $count): ?>
      <div class="dashboard-card">
        <h3><?= $count ?></h3>
        <p><?= ucfirst($key) ?></p>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- 🔹 Quick Links -->
  <div style="margin-top: 30px;">
    <h3>🚀 Quick Access</h3>
    <div class="dashboard-links">
      <a href="manage_about.php" class="btn">🧑 Manage About</a>
      <a href="manage_projects.php" class="btn">📁 Manage Projects</a>
      <a href="manage_experience.php" class="btn">💼 Manage Experience</a>
      <a href="manage_education.php" class="btn">🎓 Manage Education</a>
      <a href="manage_certifications.php" class="btn">📜 Manage Certifications</a>
      <a href="manage_recognition.php" class="btn">🏅 Manage Recognition</a>
      <a href="manage_expertise.php" class="btn">🧠 Manage Expertise</a>
      <a href="manage_categories.php" class="btn">🗂️ Project Categories</a>
      <a href="manage_course_categories.php" class="btn">📘 Course Categories</a>
      <a href="manage_admins.php" class="btn">🛡️ Manage Admins</a>
      <a href="manage_files.php" class="btn">📂 File Manager</a>
    </div>
  </div>

  <!-- 🔹 Recent Activity -->
  <div style="margin-top: 40px;">
    <h3>🕓 Recent Activity</h3>
    <div class="dashboard-recent">
      <div>
        <h4>📁 Projects</h4>
        <ul>
          <?php foreach ($recent_projects as $p): ?>
            <li><strong><?= htmlspecialchars($p['title']) ?></strong> — <?= date('M d, Y', strtotime($p['created_at'])) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div>
        <h4>💼 Experience</h4>
        <ul>
          <?php foreach ($recent_experience as $e): ?>
            <li><strong><?= htmlspecialchars($e['role']) ?></strong> @ <?= htmlspecialchars($e['company']) ?> — <?= $e['start_date'] ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>

  <!-- 🔹 Charts -->
  <div style="margin-top: 40px;">
    <h3>📈 Dashboard Insights</h3>
    <div style="display: flex; gap: 40px; flex-wrap: wrap;">
      <div style="flex: 1; min-width: 300px;">
        <canvas id="projectsChart"></canvas>
      </div>
      <div style="flex: 1; min-width: 300px;">
        <canvas id="expertiseChart"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const projectCtx = document.getElementById('projectsChart').getContext('2d');
const expertiseCtx = document.getElementById('expertiseChart').getContext('2d');

new Chart(projectCtx, {
  type: 'bar',
  data: {
    labels: <?= json_encode(array_keys($projectsByYear)) ?>,
    datasets: [{
      label: 'Projects per Year',
      data: <?= json_encode(array_values($projectsByYear)) ?>,
      backgroundColor: '#3b82f6'
    }]
  },
  options: {
    plugins: { legend: { display: false } },
    scales: { y: { beginAtZero: true } }
  }
});

new Chart(expertiseCtx, {
  type: 'doughnut',
  data: {
    labels: <?= json_encode(array_keys($expertiseData)) ?>,
    datasets: [{
      data: <?= json_encode(array_values($expertiseData)) ?>,
      backgroundColor: ['#06b6d4', '#f59e0b', '#10b981', '#ef4444', '#6366f1']
    }]
  },
  options: {
    plugins: {
      title: { display: true, text: 'Top 5 Expertise Areas' },
      legend: { position: 'bottom' }
    }
  }
});
</script>

<?php require_once 'includes/admin_footer.php'; ?>
