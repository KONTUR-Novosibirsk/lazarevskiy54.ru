<template>
    <VGrid :data="services">
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
                    <div class="ms-2" v-if="$page.props.auth.isDevAdmin">
                        <Link :href="route('admin.settings', 'services')" class="el-button el-button--danger">
                            <i class="bi bi-gear-fill me-1"></i>
                            Настройки
                        </Link>
                    </div>
                </div>
                <div>
                    <Link :href="this.service ? route('admin.services.create.child', this.service.data.id) : route('admin.services.create')"
                          class="el-button el-button--primary">
                        Создать
                    </Link>
                </div>
            </div>
        </template>
        <el-table-column prop="id" label="#" width="60" sortable="custom"/>
        <el-table-column prop="name" label="Название" sortable="custom" min-width="200">
            <template #default="scope">
                <Link
                    :href="route('admin.services.show', scope.row.id)"
                    class="hover:underline">
                    {{ scope.row.name }}
                </Link>
            </template>
        </el-table-column>
        <el-table-column prop="is_active" label="Активность" width="170">
            <template #default="scope">
                <el-button-group>
                    <el-button
                        size="small"
                        :type="scope.row.is_active ? 'success' : ''"
                        @click="scope.row.is_active = 1; updateField(scope.row, 'is_active')"
                    >
                        Активен
                    </el-button>

                    <el-button
                        size="small"
                        :type="!scope.row.is_active ? 'danger' : ''"
                        @click="scope.row.is_active = 0; updateField(scope.row, 'is_active')"
                    >
                        Неактивен
                    </el-button>
                </el-button-group>
            </template>
        </el-table-column>
        <el-table-column prop="is_featured" label="На главной" width="170" >
            <template #default="scope">
                <el-button-group>
                    <el-button
                        size="small"
                        :type="scope.row.is_featured ? 'success' : ''"
                        @click="scope.row.is_featured = 1; updateField(scope.row, 'is_featured')"
                    >
                        Активен
                    </el-button>

                    <el-button
                        size="small"
                        :type="!scope.row.is_featured ? 'danger' : ''"
                        @click="scope.row.is_featured = 0; updateField(scope.row, 'is_featured')"
                    >
                        Неактивен
                    </el-button>
                </el-button-group>
            </template>
        </el-table-column>
        <el-table-column prop="sort_order" label="Приоритет отображения" width="180" >
            <template #default="scope">
                <el-input-number
                    v-model="scope.row.sort_order"
                    size="small"
                    :min="0"
                    @change="updateField(scope.row, 'sort_order')"
                />
            </template>
        </el-table-column>
        <el-table-column prop="created_at" label="Дата создания" width="200" sortable="custom"/>
        <el-table-column label="Управление">
            <template #default="scope">
                <el-space wrap>
                    <Link :href="route('admin.services.edit', scope.row.id)"
                          class="el-button el-button--primary el-button--small">
                        Редактировать
                    </Link>
                    <v-modal-delete :url="route('admin.services.delete', scope.row.id)" :refresh="true"/>
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
        services: null,
        service: null,
    },
    data() {
        return {
            filterUrl: this.service ? route('admin.services.show', this.service.data.id) : route('admin.services.index'),
            formFilters: {
                search: this.filters.search,
                active: this.filters.is_active
            },
            sortAscending: true
        }
    },
    methods: {
        async updateField(row, field) {
            try {
                await axios.patch(
                    route('admin.services.updatePartial', row.id), {[field]: row[field]}
                )
            } catch (e) {
                ElNotification({
                    title: 'Ошибка',
                    message: 'Не удалось сохранить',
                    type: 'error',
                })
            }
        }

    }
}
</script>

<style scoped>

</style>
