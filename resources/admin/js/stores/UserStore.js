import {defineStore} from 'pinia'

export const useUserStore = defineStore('user-store', {
    state: () => ({
        sidebarCollapse: true,
        sidebarIsSmall: false,
    }),
})
