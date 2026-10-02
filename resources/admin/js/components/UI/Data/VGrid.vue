<script>
import VPagination from "./VPagination.vue";
import {useFilterStore} from "../../../stores/filter";
import {router} from "@inertiajs/vue3";

export default {
    name: "VGrid",
    emits: ['selectionChange'],
    components: {VPagination},
    props: {
        data: null,
        pagination: {
            type: Boolean,
            default: true,
        },
    },
    data() {
        return {
            loading: false,
        }
    },
    mounted() {
        router.on('start', (e) => {
            if (e.detail?.visit?.headers?.filter)
                this.loading = true
        })
        router.on('finish', () => {
            this.loading = false
        })
    },
    methods: {
        sortChange(data) {
            useFilterStore().order_by = data.prop
            useFilterStore().order_direction = data.order == 'descending' ? 'desc' : 'asc'
        },
        handleSelectionChange(data) {
            this.$emit('selectionChange', data)
        }
    }
}
</script>

<template>
    <div class="v-table relative overflow-hidden dark:outline dark:outline-offset-2 dark:outline-neutral-900 duration-500"
         :class="{'sm:rounded-t-lg': !!this.$slots.filter, 'sm:rounded-b-lg': pagination}">
        <div class="px-4 py-3 border-b border-gray-100 dark:border-neutral-700" v-if="!!this.$slots.filter">
            <slot name="filter"></slot>
        </div>
        <div class="">
            <el-table v-loading="loading" :data="data.data" @sortChange="sortChange"
                      @selectionChange="handleSelectionChange" style="width: 100%">
                <slot></slot>
                <template #append>
                    <slot name="append"></slot>
                </template>
            </el-table>
        </div>
        <div class="px-4 py-3" v-if="pagination">
            <v-pagination v-if="pagination" :disabled="loading" :meta="data.meta"/>
        </div>
    </div>
</template>

<style scoped>

</style>
