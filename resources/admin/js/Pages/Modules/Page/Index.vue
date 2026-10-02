<template>
    <VGrid :data="pages">
        <template #filter>
            <div class="flex justify-between">
                <div class="">
                    <el-input
                        v-model="formFilters.search"
                        style="max-width: 600px"
                        placeholder="Начните ввод для поиска"
                        class="input-with-select"
                        :clearable="true"
                    >
                        <template #prepend>
                            <el-button><Icon icon="icon-park-outline:search"/></el-button>
                        </template>
                        <template #append>
                            <el-select v-model="formFilters.active" placeholder="Выберите фильтр" style="width: 115px"
                                       :clearable="true">
                                <el-option label="Активные" value="1"/>
                                <el-option label="Не активные" value="0"/>
                            </el-select>
                        </template>
                    </el-input>
                </div>

                <Link :href="route('admin.page.create')" class="el-button el-button--primary">Создать</Link>
            </div>
        </template>
        <el-table-column prop="id" label="#" width="60" sortable="custom"/>
        <el-table-column prop="title" label="Название" sortable="custom"/>
        <el-table-column prop="created_at" label="Дата создания" sortable="custom">
            <template #default="scope">
                {{ scope.row.created_date_for_human }}
            </template>
        </el-table-column>
        <el-table-column prop="active" label="Активность" sortable="custom">
            <template #default="scope">
                <el-tag v-if="scope.row.active" type="success">Опубликовано</el-tag>
                <el-tag v-else type="danger">Черновик</el-tag>
            </template>
        </el-table-column>
        <el-table-column prop="active" label="Управление">
            <template #default="scope">
                <el-space wrap>
                    <PreviewPage :url="route('admin.page.show', scope.row.id)"
                                 class="el-button el-button--primary el-button--small">
                        <i class="bi bi-eye-fill"></i>
                    </PreviewPage>
                    <Link :href="route('admin.page.edit', scope.row.id)"
                          class="el-button el-button--primary el-button--small">
                        Редактировать
                    </Link>
                    <v-modal-delete :url="route('admin.page.delete', scope.row.id)" :refresh="true">
                        <i class="bi bi-trash-fill me-1"></i> Удалить
                    </v-modal-delete>
                </el-space>
            </template>
        </el-table-column>
    </VGrid>
</template>

<script>
import MainLayout from "../../../Layouts/MainLayout.vue";
import FilterMixin from "../../../Shared/Mixins/FilterMixin";
import PreviewPage from "../../../Shared/PreviewPage.vue";
import VGrid from "../../../components/UI/Data/VGrid.vue";
import VModalDelete from "../../../components/UI/Feedback/VModalDelete.vue";

export default {
    name: "Index",
    layout: MainLayout,
    components: {VModalDelete, VGrid, PreviewPage},
    mixins: [FilterMixin],
    props: {
        pages: {
            type: Object,
            default: {},
        }
    },
    data() {
        return {
            filterUrl: route('admin.page.index'),
            formFilters: {
                search: this.filters.search,
                active: this.filters.active
            },
        }
    }
}
</script>

<style scoped>

</style>
