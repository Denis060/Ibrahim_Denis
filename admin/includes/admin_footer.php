  <!-- Footer Section -->
  <footer class="site-footer">
    <p>&copy; <?= date('Y') ?> Ibrahim Denis Fofanah. All Rights Reserved.</p>
  </footer>
  <!-- For Experience -->
   <script>


  const toggle = document.getElementById('themeToggle');
  const label = document.getElementById('modeLabel');

  toggle.addEventListener('change', function() {
    document.body.classList.toggle('light-mode');
    label.textContent = this.checked ? '☀️ Light' : '🌙 Dark';
  });
</script>

  <script src="assets/js/admin.js" defer></script>
  
  
  


</body>
</html>
