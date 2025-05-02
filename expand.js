
document.addEventListener("DOMContentLoaded", function () {
  const toggles = document.querySelectorAll(".toggle-description");

  toggles.forEach(toggle => {
    toggle.addEventListener("click", () => {
      const card = toggle.closest(".experience-card");
      card.classList.toggle("expanded");
    });
  });
});
