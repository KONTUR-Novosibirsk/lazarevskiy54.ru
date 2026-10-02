import {defineStore} from 'pinia'

export const useMenuStore = defineStore('menu', {
    state: () => ({menu: null}),
    actions: {
        getMenu() {
            return this.menu
        },
        setMenu(menu) {
            this.menu = menu
        },
        add(menuItem) {
            this.menu.push(menuItem)
        },
        update(menuItem) {
            console.log(menuItem);
            return
            this.recursive(this.menu, menuItem)
        },
        recursive(menu, menuItem) {
            for (let item in menu) {
                if (item.id === menuItem['id']) {
                    console.log(item);
                }
                this.recursive(item.children, menuItem)
            }
        },
    },
})
