<template>
    <div v-if="$page.props.auth.isDevAdmin" class="mb-3">
        <CategoryFormModal @addCategory="addCategory"/>
        <Edit button-name="Добавить" :category="null"></Edit>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-3 mb-3">
        <el-card body-class="p-2" v-for="(category, index) in categoriesData || []" :key="category.id">
            <div class="flex justify-between">
                <el-button link>
                    <Icon icon="material-symbols:folder" class="me-1"/>
                    <Link :href="route('admin.iblock.category.show', category.id)"
                          class="el-link el-link--default is-underline">
                        {{ category.name }}
                    </Link>
                </el-button>
                <div class="my-auto">
                    <CategoryFormModal :category="category" :index="index" size="small"
                                       @updateCategory="updateCategory"/>
                    <v-modal-delete :url="route('admin.iblock.category.delete', category.id)" :index="index"
                                 @onDelete="deleteCategory">Удалить
                    </v-modal-delete>
                </div>
            </div>
        </el-card>
    </div>

    <IBlockList :info-blocks="infoBlocks" :categories="categories.data"/>
</template>

<script>
import Edit from "./Edit.vue";
import IBlockList from "./IBlockList.vue";
import FormModal from "./Category/CategoryFormModal.vue";
import CategoryFormModal from "./Category/CategoryFormModal.vue";
import VGrid from "../../../components/UI/Data/VGrid.vue";
import MainLayout from "../../../Layouts/MainLayout.vue";
import VModalDelete from "../../../components/UI/Feedback/VModalDelete.vue";

export default {
    name: "Index",
    layout: MainLayout,
    components: {VModalDelete, VGrid, CategoryFormModal, FormModal, IBlockList, Edit},
    props: {
        categories: {
            type: Object,
            default: {},
        },
        infoBlocks: {
            type: Object,
            default: {},
        }
    },
    data() {
        return {
            categoriesData: [],
        }
    },
    mounted() {
        this.categoriesData = this.categories.data
    },
    methods: {
        deleteCategory(index) {
            this.categoriesData.splice(index, 1)
        },
        addCategory(category) {
            this.categoriesData.push(category)
        },
        updateCategory(index, category) {
            this.categoriesData[index] = category
        }
    }
}
</script>

<style scoped>

</style>
