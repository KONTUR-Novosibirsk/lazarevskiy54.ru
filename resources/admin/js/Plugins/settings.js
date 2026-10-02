import {usePage} from "@inertiajs/vue3";

export const settings = {
    install(app, options) {
        app.config.globalProperties.settings = function (key, defaultValue = null, group = 'main') {
            const settings = usePage().props.settings || [];
            return settings[group] && settings[group][key] ? settings[group][key] : defaultValue
        }
    }
}
