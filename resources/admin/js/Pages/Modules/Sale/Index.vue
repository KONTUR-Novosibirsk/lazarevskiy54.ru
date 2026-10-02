<template>
    <VGrid :data="sale">
        <template #filter>
            <div class="flex justify-between">
                <div class="flex items-center gap-2">
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
                <Link :href="route('admin.sale.create')" class="el-button el-button--primary">Создать</Link>
            </div>
        </template>
        <el-table-column prop="id" label="#" width="60" sortable="custom"/>
        <el-table-column prop="title" label="Название" sortable="custom"/>
        <el-table-column prop="created_at" label="Дата создания" sortable="custom">
            <template #default="scope">
                {{ scope.row.created_date_for_human }}
            </template>
        </el-table-column>
        <el-table-column prop="active" label="Активность">
            <template #default="scope">
                <el-tag v-if="scope.row.active" type="success">Активна</el-tag>
                <el-tag v-else type="danger">Не активна</el-tag>
            </template>
        </el-table-column>
        <el-table-column prop="sort" label="Порядок сортировки">
            <template #default="scope">
                <el-input-number
                    v-model="scope.row.sort"
                    @change="updateSaleSort(scope.row)"
                    size="small"
                    class="mr-2"
                />
            </template>
        </el-table-column>
        <el-table-column prop="active" label="Управление">
            <template #default="scope">
                <el-space wrap>
                    <PreviewPage :url="route('admin.sale.show', scope.row.id)"
                                 class="el-button el-button--primary el-button--small">
                        <i class="bi bi-eye-fill"></i>
                    </PreviewPage>
                    <Link :href="route('admin.sale.edit', scope.row.id)"
                          class="el-button el-button--primary el-button--small">
                        Редактировать
                    </Link>
                    <v-modal-delete :url="route('admin.sale.delete', scope.row.id)" :refresh="true">
                        <i class="bi bi-trash-fill"></i> Удалить
                    </v-modal-delete>
                </el-space>
            </template>
        </el-table-column>
    </VGrid>
</template>

<script>
import MainLayout from "../../../Layouts/MainLayout.vue";
import Pagination from "../../../Shared/Pagination.vue";
import FilterMixin from "../../../Shared/Mixins/FilterMixin";
import PreviewPage from "../../../Shared/PreviewPage.vue";
import VGrid from "../../../components/UI/Data/VGrid.vue";
import VModalDelete from "../../../components/UI/Feedback/VModalDelete.vue";
import {ElNotification} from "element-plus";

export default {
    name: "Index",
    layout: MainLayout,
    components: {VModalDelete, VGrid, PreviewPage, Pagination},
    mixins: [FilterMixin],
    props: {
        sale: {
            type: Object,
            default: {},
        }
    },
    data() {
        return {
            filterUrl: route('admin.sale.index'),
            formFilters: {
                search: this.filters.search,
                active: this.filters.active
            },
            sortAscending: true
        }
    },
    methods: {
        updateSaleSort(sale) {
            axios.post(route('admin.sale.updateSort', sale.id), {
                sort: sale.sort
            }).then(() => {
                this.sortSale()
                ElNotification.success({ message: 'Сортировка обновлена', position: 'bottom-right' });
            }).catch(() => {
                ElNotification.error({ message: 'Ошибка при обновлении сортировки', position: 'bottom-right' });
            });
        },
        toggleSortDirection() {
            this.sortAscending = !this.sortAscending;
            this.sortSale();
        },
        sortSale() {
            if (!this.sale || !this.sale.data) return;

            const currentPage = this.sale.meta.current_page || 1;

            axios.post(route('admin.sale.getSaleSort'), {
                sort: this.sortAscending ? 'ASC' : 'DESC',
                page: currentPage
            }).then((response) => {
                this.sale.data = response.data.sales;
            }).catch(() => {
                ElNotification.error({ message: 'Ошибка при обновлении сортировки', position: 'bottom-right' });
            });
            this.sale.data.sort((a, b) =>
                this.sortAscending ? a.sort - b.sort : b.sort - a.sort
            );
        }
    }
}
</script>

<style scoped>

</style>
