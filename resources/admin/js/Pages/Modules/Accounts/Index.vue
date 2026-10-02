<template>
    <VGrid :data="accounts">
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
                    </el-input>
                </div>
            </div>
        </template>
        <el-table-column prop="id" label="#" width="60" sortable="custom"/>
        <el-table-column prop="full_name" label="ФИО" sortable="custom"/>
        <el-table-column prop="login" label="Логин" sortable="custom"/>
        <el-table-column prop="email" label="Email" sortable="custom"/>
        <el-table-column prop="phone" label="Телефон" sortable="custom"/>
        <el-table-column prop="order_count" label="Количество заказов"/>
        <el-table-column label="Управление">
            <template #default="{row}">
                <el-button
                    @click="toggleConfirmed(row)"
                    :type="row.is_confirmed == 1 ? 'success':'danger'"
                    size="small"
                >
                    {{ row.is_confirmed == 1 ? 'Разрешено' : 'Не разрешено' }}
                </el-button>
                <v-modal-delete :url="route('admin.accounts.destroy', row.id)" :refresh="true"/>
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
        accounts: null,
    },
    data() {
        return {
            filterUrl: route('admin.accounts.index'),
            formFilters: {
                search: this.filters.search,
                active: this.filters.active
            },
        }
    },
    methods: {
        async toggleConfirmed(row) {
            row.is_confirmed = !row.is_confirmed;
            await axios.patch(route('admin.accounts.toggle-confirmed', row.id))
                .then((response) => {
                    if(response.data.is_confirmed) {
                        ElNotification({
                            title: 'Система',
                            message: response.data.message,
                            type: 'message',
                            position: 'bottom-right',
                        });
                    }
                })
                .catch((error) => {
                    ElNotification({
                        title: 'Ошибка',
                        message: 'Произошла неизвестная ошибка',
                        type: 'error',
                        position: 'bottom-right',
                    });
                });
        },
    }
}
</script>

<style scoped>

</style>
