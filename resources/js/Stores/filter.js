import {defineStore} from 'pinia'
import pickBy from "lodash/pickBy";
import {toRaw} from 'vue'
import Cart from "../cart/Cart";

export const useProductFilterStore = defineStore('product-filters', {
    state: () => ({
        url: null,
        queries: {},
        data: {
            price: null,
            filterData: null,
            sort: {
                column: null,
                direction: null,
            },
        },
        sortAttributes: {},
    }),
    actions: {
        setSortData(sortData) {
            this.data.sort = sortData
            this.getProducts()
        },
        setFilterData(filterData, priceData) {
            this.data.filterData = filterData
            this.data.price = priceData
            this.getProducts()
        },
        getProducts() {
            axios.get(this.url, {
                params: pickBy(toRaw(this.data))
            }).then((response) => {
                window.history.pushState({}, '', response.data.url);
                let products = document.querySelector('.js-filter-products')
                products.innerHTML = response.data.html
                Cart.addListeners(products.querySelectorAll('.js__add_to_cart'))
            })
        }
    }
})
