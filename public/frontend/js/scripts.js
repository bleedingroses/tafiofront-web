window.addEventListener("DOMContentLoaded", (event) => {
 // Navbar shrink function
 var navbarShrink = function () {
  const navbarCollapsible = document.body.querySelector("#mainNav");
  if (!navbarCollapsible) {
   return;
  }
  if (window.scrollY === 0) {
   navbarCollapsible.classList.remove("navbar-shrink");
  } else {
   navbarCollapsible.classList.add("navbar-shrink");
  }
 };

 // Shrink the navbar
 navbarShrink();

 // Shrink the navbar when page is scrolled
 document.addEventListener("scroll", navbarShrink);

 //sidebar open close js code
 let navLinks = document.querySelector(".nav-links");
 //menu bar
 let navMenu = document.querySelector("#nav-icon3");

 navMenu.addEventListener("click", () => {
  if (navMenu.classList.contains("open") === true) {
   navMenu.classList.remove("open");
   navLinks.style.left = "-100%";
  } else {
   navMenu.classList.add("open");
   navLinks.style.left = "0";
  }
 });

 //sidebar sub menu open close
 let produk = document.querySelector("#produk");
 let follow = document.querySelector("#follow");
 let phone = document.querySelector("#phone");
 let time = document.querySelector("#time");
 let search = document.querySelector("#search");
 let wa = document.querySelector("#wa");

 produk.addEventListener("click", () => {
  navLinks.classList.toggle("show");
 });

 follow.addEventListener("click", () => {
  navLinks.classList.toggle("show1");
 });

 phone.addEventListener("click", () => {
  navLinks.classList.toggle("show2");
 });

 time.addEventListener("click", () => {
  navLinks.classList.toggle("show3");
 });

 search.addEventListener("click", () => {
  navLinks.classList.toggle("show4");
 });
 wa.addEventListener("click", () => {
    navLinks.classList.toggle("show5");
   });
});
