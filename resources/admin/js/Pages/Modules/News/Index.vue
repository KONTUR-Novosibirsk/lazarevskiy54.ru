<template>
    <v-grid :data="news">
        <template #filter>
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <div class="flex items-center gap-2">
                        <el-input
                            v-model="formFilters.search"
                            style="max-width: 600px"
                            placeholder="Начните ввод"
                            class="input-with-select"
                            :clearable="true"
                        >
                            <template #prepend>
                                <el-button><Icon icon="icon-park-outline:search"/></el-button>
                            </template>
                            <template #append>
                                <el-select
                                    v-model="formFilters.active"
                                    placeholder="Выберите фильтр"
                                    style="width: 115px"
                                    :clearable="true"
                                >
                                    <el-option label="Опубликованные" value="1"/>
                                    <el-option label="Не опубликованные" value="0"/>
                                </el-select>
                            </template>
                        </el-input>
                        <el-button
                            type="primary"
                            size="small"
                            @click="toggleSortDirection"
                            title="Переключить направление сортировки"
                        >
                            <template v-if="sortAscending">
                                <i class="bi bi-sort-numeric-up"></i>
                            </template>
                            <template v-else>
                                <i class="bi bi-sort-numeric-down"></i>
                            </template>
                        </el-button>
                    </div>
                </div>

                <!-- Кнопка создания -->
                <Link :href="route('admin.news.store')" class="el-button el-button--primary">Создать</Link>
            </div>
        </template>
        <el-table-column prop="id" label="#" width="60" sortable="custom"/>
        <el-table-column prop="title" label="Название" sortable="custom">
            <template #default="scope">
                <template v-if="scope.row.title">{{ scope.row.title }}</template>
                <span class="text-red-700" v-else> Черновик #{{ scope.row.id }} </span>
            </template>
        </el-table-column>
        <el-table-column prop="publication_date" label="Дата публикации" sortable/>
        <el-table-column prop="is_active" label="Активность">
            <template #default="scope">
                <el-tag v-if="scope.row.active" type="success">Опубликовано</el-tag>
                <el-tag v-else type="danger">Черновик</el-tag>
            </template>
        </el-table-column>
        <el-table-column prop="sort" label="Порядок сортировки">
            <template #default="scope">
                <el-input-number
                    v-model="scope.row.sort"
                    @change="updateNewsSort(scope.row)"
                    size="small"
                    class="mr-2"
                />
            </template>
        </el-table-column>
        <el-table-column label="Управление">
            <template #default="scope">
                <el-space wrap>
                    <PreviewPage :url="route('admin.news.show', scope.row.id)"
                                 class="el-button el-button--primary el-button--small">
                        <i class="bi bi-eye-fill"></i>
                    </PreviewPage>
                    <Link :href="route('admin.news.edit', scope.row.id)"
                          class="el-button el-button--primary el-button--small">
                        Редактировать
                    </Link>
                    <v-modal-delete :url="route('admin.news.delete', scope.row.id)" :refresh="true"/>
                </el-space>
            </template>
        </el-table-column>
    </v-grid>
</template>

<script>
import FilterMixin from "../../../Shared/Mixins/FilterMixin";
import PreviewPage from "../../../Shared/PreviewPage.vue";
import VGrid from "../../../components/UI/Data/VGrid.vue";
import MainLayout from "../../../Layouts/MainLayout.vue";
import VModalDelete from "../../../components/UI/Feedback/VModalDelete.vue";
import {ElNotification} from "element-plus";

export default {
    name: "Index",
    layout: MainLayout,
    components: {VModalDelete, VGrid, PreviewPage},
    mixins: [FilterMixin],
    props: {
        news: {
            type: Object,
            default: {},
        }
    },
    data() {
        return {
            filterUrl: route('admin.news.index'),
            formFilters: {
                search: this.filters.search,
                active: this.filters.active
            },
            sortAscending: true
        }
    },
    methods: {
        updateNewsSort(news) {
            axios.post(route('admin.news.updateSort', news.id), {
                sort: news.sort
            }).then(() => {
                this.sortNews()
                ElNotification.success({ message: 'Сортировка обновлена', position: 'bottom-right' });
            }).catch(() => {
                ElNotification.error({ message: 'Ошибка при обновлении сортировки', position: 'bottom-right' });
            });
        },
        toggleSortDirection() {
            this.sortAscending = !this.sortAscending;
            this.sortNews();
        },
        sortNews() {
            if (!this.news || !this.news.data) return;

            const currentPage = this.news.meta.current_page || 1;

            axios.post(route('admin.news.getNewsSort'), {
                sort: this.sortAscending ? 'ASC' : 'DESC',
                page: currentPage
            }).then((response) => {
                this.news.data = response.data.news;
            }).catch(() => {
                ElNotification.error({ message: 'Ошибка при обновлении сортировки', position: 'bottom-right' });
            });
            this.news.data.sort((a, b) =>
                this.sortAscending ? a.sort - b.sort : b.sort - a.sort
            );
        }
    }
}
</script>

<style scoped>

</style>
