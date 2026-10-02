<template>
    <div class="products-sorter">
        <div>Сортировать по:</div>
        <a v-for="(attribute, index) in attributes" @click.stop="changeSort(index)"
           :class="{'asc': column === index && direction === 'asc', 'desc': column === index && direction === 'desc'}"
        >{{ attribute }}</a>
    </div>
</template>

<script>
import {useProductFilterStore} from "../../Stores/filter";

export default {
    name: "ProductSorterComponent",
    props: {
        data: null,
        attributes: null,
        url: null,
    },
    data() {
        return {
            column: null,
            direction: null,
        }
    },
    mounted() {
        useProductFilterStore().$subscribe((mutation, state) => {
            if (state.data.sort.column) {
                this.column = state.data.sort.column
                this.direction = state.data.sort.direction
            }
        })
        if (this.data.length && this.data.length > 0) {
            useProductFilterStore().data = this.data
        }
        useProductFilterStore().url = this.url
    },
    methods: {
        changeSort(attribute) {
            let direction = 'asc'
            if (useProductFilterStore().data.sort && useProductFilterStore().data.sort.column == attribute) {
                direction = useProductFilterStore().data.sort.direction == 'asc' ? 'desc' : 'asc'
            }
            useProductFilterStore().setSortData({
                column: attribute,
                direction: direction,
            })

        }
    }
}
</script>

<style scoped>

</style>
