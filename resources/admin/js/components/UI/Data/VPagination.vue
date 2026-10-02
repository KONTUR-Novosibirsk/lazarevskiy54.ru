<script>
import {router} from "@inertiajs/vue3";

export default {
    name: "VPagination",
    props: {
        meta: null,
    },
    methods: {
        handleSizeChange(perPage) {
            axios.patch(route('admin.user.changePerPage'), {
                'per_page': perPage,
            }).then(response => {
                this.$inertia.reload()
            })
        },
        handleCurrentChange(current) {
            const pageInfo = (this.meta.links || []).find(f => f.label == current)
            if (pageInfo.url)
                router.visit(pageInfo.url, {
                    method: 'get',
                    preserveScroll: true,
                })
        }
    }
}
</script>

<template>
    <el-pagination
        v-model:current-page="meta.current_page"
        v-model:page-size="meta.per_page"
        :page-sizes="[10, 20, 30, 50, 100]"
        :small="false"
        :background="true"
        layout="total, sizes, prev, pager, next, jumper"
        :total="meta.total"
        @size-change="handleSizeChange"
        @current-change="handleCurrentChange"
    />
</template>

<style scoped>

</style>
