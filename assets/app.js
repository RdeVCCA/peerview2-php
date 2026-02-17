/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 * To get JS packages, use `php bin/console importmap:require PACKAGE_NAME`.
 */

const navMenuButton = document.querySelector("#navigation-menu-button");
const navMenu = document.querySelector("#navigation-menu");
const navMenuShadow = document.querySelector("#navigation-menu-shadow");

navMenuButton.addEventListener("click", function () {
    if (navMenu.classList.contains("opened") || navMenu.classList.contains("closed")) {
        navMenu.classList.toggle("opened");
        navMenu.classList.toggle("closed");
        navMenuShadow.classList.toggle("opened");
        navMenuShadow.classList.toggle("closed");
    } else {
        navMenu.classList.add("opened");
        navMenuShadow.classList.add("opened");
    }
});
