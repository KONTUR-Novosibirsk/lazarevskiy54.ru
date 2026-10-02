<template>
    <div class="mb-2">
        <Link :href="route('admin.shop.filter.create')" class="el-button el-button--primary">Добавить</Link>
    </div>
    <v-grid :data="filters">
        <el-table-column prop="name" label="Название"></el-table-column>
        <el-table-column label="Управление">
            <template #default="prop">
                <el-space wrap>
                    <Link :href="route('admin.shop.filter.edit', prop.row.id)"
                          class="el-button el-button--primary el-button--small">Изменить
                    </Link>
                    <v-modal-delete :url="route('admin.shop.filter.delete', prop.row.id)" :refresh="true"/>
                </el-space>
            </template>
        </el-table-column>
    </v-grid>
</template>

<script>
import MainLayout from "../../../../Layouts/MainLayout.vue";
import VGrid from "../../../../components/UI/Data/VGrid.vue";
import VModalDelete from "../../../../components/UI/Feedback/VModalDelete.vue";

export default {
    name: "Index",
    layout: MainLayout,
    components: {VModalDelete, VGrid},
    props: {
        filters: null,
    }
}
</script>

<style scoped>

</style>
