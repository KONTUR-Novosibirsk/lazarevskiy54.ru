import {Fancybox} from "@fancyapps/ui";
import "@fancyapps/ui/dist/fancybox/fancybox.css";

// Инициализация Fancybox 6
$(document).ready(function() {
    Fancybox.bind("[data-fancybox]", {
        autoFocus: false,
        trapFocus: false,
        placeFocusBack: false,
    });
});

