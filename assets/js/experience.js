document.addEventListener('DOMContentLoaded', () => {
  const toggles = document.querySelectorAll('.toggle-description');

  toggles.forEach(button => {
    button.addEventListener('click', () => {
      const card = button.closest('.experience-card');

      // Collapse all other cards
      document.querySelectorAll('.experience-card.expanded').forEach(exp => {
        if (exp !== card) exp.classList.remove('expanded');
      });

      // Toggle this one
      card.classList.toggle('expanded');
    });
  });
});
