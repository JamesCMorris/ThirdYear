
//JavaScript script to toggle the mobile menu//
const menuToggle = document.getElementById("menu-toggle");
const menuNav = document.getElementById("menu-nav");

const toggleMenu = () => {
  console.log("Called toggle menu")
  menuNav.classList.toggle("menu-toggle");
}

menuToggle.addEventListener("click", toggleMenu);
