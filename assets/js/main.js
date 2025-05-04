document.addEventListener("DOMContentLoaded", () => {
  const themeToggleBtn = document.querySelector(".theme-toggle");
  const socialToggleBtn = document.querySelector(".social-toggle");
  const socialPopup = document.querySelector(".social-popup");

  // ================================
  // 1. Dark / Light Mode Toggle
  // ================================
  themeToggleBtn.addEventListener("click", () => {
    const body = document.body;
    const isLight = body.classList.contains("light-mode");
    body.classList.toggle("light-mode");
    body.classList.toggle("dark-mode");

    // Save preference in cookie
    document.cookie = `theme=${isLight ? "dark" : "light"}; path=/; max-age=31536000`;
  });

  // ================================
  // 2. Toggle Social Popup
  // ================================
  socialToggleBtn.addEventListener("click", () => {
    socialPopup.classList.toggle("hidden");
  });

  // ================================
  // 3. Keyboard Shortcut (Ctrl + K)
  // ================================
  document.addEventListener("keydown", (e) => {
    if (e.ctrlKey && e.key.toLowerCase() === 'k') {
      e.preventDefault();
      socialPopup.classList.toggle("hidden");
    }
  });

  // ================================
  // 4. Sticky Navbar Show/Hide on Scroll
  // ================================
  let lastScrollY = window.scrollY;
  const navbar = document.getElementById("navbar");

  window.addEventListener("scroll", () => {
    if (window.scrollY > lastScrollY) {
      navbar.classList.add("navbar-hidden");
    } else {
      navbar.classList.remove("navbar-hidden");
    }
    lastScrollY = window.scrollY;
  });
});
