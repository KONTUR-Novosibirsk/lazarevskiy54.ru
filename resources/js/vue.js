import {createApp, defineAsyncComponent} from 'vue'
import { createPinia } from 'pinia'
const pinia = createPinia()
import directives from "../admin/js/Shared/Directives/directives";
const app = () => createApp({})
const vue_apps = document.querySelectorAll('.vue_app');

vue_apps.forEach(function (el) {
    const vueApp = app();
    // Shop
    vueApp.component('CartComponent', defineAsyncComponent(() => import('./components/Cart/CartComponent.vue')))
    vueApp.component('ProductSorterComponent', defineAsyncComponent(() => import('./components/Shop/ProductSorterComponent.vue')))
    vueApp.component('ProductFilterComponent', defineAsyncComponent(() => import('./components/Shop/ProductFilterComponent.vue')))

    // Personal
    vueApp.component('AuthComponent', defineAsyncComponent(() => import('./components/Personal/Auth/AuthComponent.vue')))
    vueApp.component('AuthMobileComponent', defineAsyncComponent(() => import('./components/Personal/MobileAuth/AuthMobileComponent.vue')))
    vueApp.component('Account', defineAsyncComponent(() => import('./components/Personal/Account/Account.vue')))
    vueApp.component('LoginFormComponent', defineAsyncComponent(() => import('./components/Personal/Auth/LoginFormComponent.vue')))
    vueApp.component('RegisterFormComponent', defineAsyncComponent(() => import('./components/Personal/Auth/RegisterFormComponent.vue')))
    vueApp.component('PasswordResetFormComponent', defineAsyncComponent(() => import('./components/Personal/Auth/PasswordResetFormComponent.vue')))
    vueApp.component('PasswordEditFormComponent', defineAsyncComponent(() => import('./components/Personal/Auth/PasswordEditFormComponent.vue')))


    vueApp.component('QuestionFormComponent', defineAsyncComponent(() => import('./components/Questions/QuestionFormComponent.vue')))
    vueApp.component('ReviewFormComponent', defineAsyncComponent(() => import('./components/Reviews/ReviewFormComponent.vue')))
    vueApp.component('FeedbackFormComponent', defineAsyncComponent(() => import('./components/Feedback/FeedbackFormComponent.vue')))
    vueApp.use(pinia).use(directives).mount(el);
});

document.addEventListener('DOMContentLoaded', function () {

});
