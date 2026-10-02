<template>
    <el-breadcrumb>
        <el-breadcrumb-item>
            <Link :href="route('admin.index')">Главная</Link>
        </el-breadcrumb-item>
        <el-breadcrumb-item v-for="(item, index) in $page.props.seo.breadcrumbs?.data">
            <Link :href="item.url">{{ item.name }}</Link>
        </el-breadcrumb-item>
    </el-breadcrumb>
</template>

<script>
export default {
    name: "Breadcrumbs",
}
</script>

<style scoped>

</style>
