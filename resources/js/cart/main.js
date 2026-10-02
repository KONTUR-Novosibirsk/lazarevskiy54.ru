import Cart from "./Cart";

document.addEventListener("DOMContentLoaded", () => {
    let cartButtons = document.querySelectorAll('.js__add_to_cart');
    Cart.addListeners(cartButtons)
});
