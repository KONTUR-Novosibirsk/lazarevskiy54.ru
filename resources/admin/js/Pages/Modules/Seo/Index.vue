<template>
    <v-grid :data="urls">
        <template #filter>
            <div class="flex justify-between">
                <EditUrl name="Добавить"/>
                <Link class="el-button el-button--primary" :href="route('admin.seo.template.index')">
                    Шаблонные SEO
                </Link>
            </div>
        </template>
        <el-table-column prop="url" label="URL" sortable="custom"></el-table-column>
        <el-table-column prop="seo.title" label="Заголовок" sortable="custom"></el-table-column>
        <el-table-column label="Управление">
            <template #default="scope">
                <el-space wrap>
                    <EditUrl name="Изменить" :url-seo="scope.row" size="small"/>
                    <v-modal-delete :url="route('admin.url_seo.delete', scope.row.id)" :refresh="true"/>
                </el-space>
            </template>
        </el-table-column>
    </v-grid>
</template>

<script>
import MainLayout from "../../../Layouts/MainLayout.vue";
import Pagination from "../../../Shared/Pagination.vue";
import EditUrl from "./EditUrl.vue";
import FilterMixin from "../../../Shared/Mixins/FilterMixin";
import VGrid from "../../../components/UI/Data/VGrid.vue";
import VModalDelete from "../../../components/UI/Feedback/VModalDelete.vue";

export default {
    name: "Index",
    layout: MainLayout,
    components: {VModalDelete, VGrid, EditUrl, Pagination},
    mixins: [FilterMixin],
    props: {
        urls: {
            type: Object,
            default: {},
        }
    },
    data() {
        return {
            filterUrl: route('admin.seo.index'),
            formFilters: {
                search: null,
            },
        }
    },
}
</script>
