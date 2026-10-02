<template>
    <v-grid :data="orders">
        <el-table-column prop="id" label="№ Заказа" width="100px"/>
        <el-table-column prop="user_name" label="Имя"/>
        <el-table-column prop="user_phone" label="Телефон"/>
        <el-table-column prop="date_for_human" label="Дата"/>
        <el-table-column prop="price" label="Сумма заказа">
            <template #default="prop">
                {{ prop.row.price }} <span v-html="settings('currency', 'рубль', 'shop')"></span>
            </template>
        </el-table-column>
        <el-table-column prop="status" label="Статус">
            <template #default="prop">
                <el-tag type="danger" v-if="prop.row.status === 0">В работе</el-tag>
                <el-tag type="warning" v-if="prop.row.status === 1">Отправлен</el-tag>
                <el-tag type="success" v-else-if="prop.row.status === 5">Завершен</el-tag>
            </template>
        </el-table-column>
        <el-table-column label="Управление">
            <template #default="prop">
                <el-space wrap>
                    <Link :href="route('admin.shop.order.show', prop.row.id)"
                          class="el-button el-button--primary el-button--small">
                        Список покупок
                    </Link>
                    <v-modal-delete :url="route('admin.shop.order.delete', prop.row.id)" :refresh="true"/>
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
        orders: {
            type: Object,
            default: {},
        }
    },
    data() {
        return {}
    },
}
</script>

<style scoped>

</style>
