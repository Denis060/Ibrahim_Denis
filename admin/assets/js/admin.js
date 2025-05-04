// assets/js/admin.js

document.addEventListener("DOMContentLoaded", () => {
  const alertBox = document.getElementById("successAlert");

  if (alertBox) {
    // Fade out the alert after 3.5 seconds
    setTimeout(() => {
      alertBox.style.transition = "opacity 0.5s ease";
      alertBox.style.opacity = "0";
    }, 3500);

    // Hide and redirect after 4 seconds
    setTimeout(() => {
      alertBox.style.display = "none";
      const redirectUrl = alertBox.dataset.redirect;
      if (redirectUrl) {
        window.location.href = redirectUrl;
      }
    }, 4000);
  }
});
