import VClipboard from "./VClipboard";
import VClickOutside from "./VClickOutside";

export default {
    install(Vue) {
        Vue.directive('clipboard', VClipboard)
        Vue.directive('click-outside', VClickOutside)
    }
}
