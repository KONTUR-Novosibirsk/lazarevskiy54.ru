import {createApp, h} from 'vue'
import {createInertiaApp} from '@inertiajs/vue3'
import {createPinia} from 'pinia'
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {ZiggyVue} from '../../../vendor/tightenco/ziggy/dist/index.esm'
import {Link} from '@inertiajs/vue3';
import {settings} from './Plugins/settings'
import directives from "./Shared/Directives/directives";
import ElementPlus from 'element-plus'
import ru from 'element-plus/dist/locale/ru.mjs'
import { Icon } from '@iconify/vue';

createInertiaApp({
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({el, App, props, plugin}) {
        const pinia = createPinia();
        const app = createApp({render: () => h(App, props)});
        app.use(settings)
            .use(ElementPlus, {
                locale: ru,
            })
            .use(plugin)
            .use(pinia)
            .use(directives)
            .use(ZiggyVue)
            .component("Link", Link)
            .component("Icon", Icon)
            .mount(el)
    },
    progress: {
        delay: 250,
        color: '#409eff',
    },
})



