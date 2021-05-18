/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************!*\
  !*** ./resources/js/user.js ***!
  \******************************/
document.addEventListener("DOMContentLoaded", function (event) {
  var showNavbar = function showNavbar(toggleId, navId, bodyId, headerId) {
    var toggle = document.getElementById(toggleId),
        nav = document.getElementById(navId),
        bodypd = document.getElementById(bodyId),
        headerpd = document.getElementById(headerId); // Validate that all variables exist

    if (toggle && nav && bodypd && headerpd) {
      toggle.addEventListener('click', function () {
        // show navbar
        nav.classList.toggle('show'); // change icon

        toggle.classList.toggle('bx-x'); // add padding to body

        bodypd.classList.toggle('body-pd'); // add padding to header

        headerpd.classList.toggle('body-pd');
      });
    }
  };

  showNavbar('header-toggle', 'nav-bar', 'body-pd', 'header');
  /*===== LINK ACTIVE =====*/

  var linkColor = document.querySelectorAll('.nav_link');

  function colorLink() {
    if (linkColor) {
      linkColor.forEach(function (l) {
        return l.classList.remove('active');
      });
      this.classList.add('active');
    }
  }

  linkColor.forEach(function (l) {
    return l.addEventListener('click', colorLink);
  }); // Your code to run since DOM is loaded and ready
});
/******/ })()
;