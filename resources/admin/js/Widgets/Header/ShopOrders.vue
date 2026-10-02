<template>
    <el-badge :value="data.count" :hidden="data.count == 0" :offset="[-4, 2]">
        <div class="el-header-item" @click="$inertia.get(route('admin.shop.order.index'))">
            <Icon class="m-auto" icon="material-symbols:shopping-cart-rounded" />
        </div>
    </el-badge>
</template>

<script>
export default {
    name: "ShopOrders",
    props: {
        data: {},
    },
    mounted() {

    }
}
</script>

<style scoped>

</style>
