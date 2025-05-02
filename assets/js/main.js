// Theme Toggle
const toggleBtn = document.querySelector('.theme-toggle');
const body = document.body;

toggleBtn?.addEventListener('click', () => {
  body.classList.toggle('light-theme');
});

// Social Popup Toggle
const socialToggle = document.querySelector('.social-toggle');
const popup = document.querySelector('.social-popup');

socialToggle?.addEventListener('click', () => {
  popup?.classList.toggle('hidden');
});

// Optional: Close popup when clicking outside
window.addEventListener('click', function (e) {
  if (popup && !popup.contains(e.target) && !socialToggle.contains(e.target)) {
    popup.classList.add('hidden');
  }
});

let lastScrollTop = 0;
const navbar = document.getElementById("navbar");

window.addEventListener("scroll", function () {
  let scrollTop = window.scrollY || document.documentElement.scrollTop;

  if (scrollTop > lastScrollTop) {
    // scrolling down
    navbar.classList.add("navbar-hidden");
  } else {
    // scrolling up
    navbar.classList.remove("navbar-hidden");
  }

  lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
});