<template>
    <div class="mb-3">
        <category-component @add="add" button-name="Добавить меню"/>
    </div>
    <el-table :data="categoriesData" border>
        <el-table-column prop="id" label="#"/>
        <el-table-column prop="name" label="Название"/>
        <el-table-column prop="code" label="Код"/>
        <el-table-column prop="name" label="Управление">
            <template #default="prop">
                <el-space wrap>
                    <category-component button-name="Изменить" size="small" class="me-1"
                                        v-model="categoriesData[prop.$index]"/>
                    <Link class="el-button--primary el-button el-button--small"
                          :href="route('admin.menu.show', prop.row.id)">
                        Редактировать
                    </Link>
                    <v-modal-delete @onDelete="deleteCategory" :index="prop.$index"
                                    :url="route('admin.menu.delete', prop.row.id)">Удалить
                    </v-modal-delete>
                </el-space>
            </template>
        </el-table-column>
    </el-table>
</template>

<script>
import CategoryComponent from "./CategoryComponent.vue";
import VModalDelete from "../../../components/UI/Feedback/VModalDelete.vue";
import MainLayout from "../../../Layouts/MainLayout.vue";

export default {
    name: "Index",
    layout: MainLayout,
    components: {MainLayout, VModalDelete, CategoryComponent},
    props: {
        categories: {
            type: Object,
            default: {},
        }
    },
    data() {
        return {
            modal: null,
            loading: false,
            categoriesData: this.categories
        }
    },
    methods: {
        deleteCategory(index) {
            this.categoriesData.splice(index, 1)
        },
        add(category) {
            this.categoriesData.push(category)
        }
    },

}
</script>

<style scoped>

</style>
