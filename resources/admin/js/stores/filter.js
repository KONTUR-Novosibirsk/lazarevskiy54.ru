import {defineStore} from 'pinia'

export const useFilterStore = defineStore('filter', {
    state: () => ({
        page: null,
        order_by: null,
        order_direction: null,
    }),
})
