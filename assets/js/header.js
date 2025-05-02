// assets/js/header.js
let lastScrollTop = 0;
const navbar = document.getElementById("main-header");

window.addEventListener("scroll", function () {
  let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
  if (scrollTop > lastScrollTop) {
    navbar.style.top = "-100px"; // hide on scroll down
  } else {
    navbar.style.top = "0"; // show on scroll up
  }
  lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
});


// Toggle experience detail visibility on click
function toggleDetails(element) {
    const details = element.nextElementSibling;
    details.classList.toggle('active');
  }
  