<template>
    <div class="mb-3">
        <Link :href="route('admin.shop.offer.create', category.data.id)" class="el-button el-button--primary">
            Добавить
        </Link>
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
    <v-grid :data="offers">
        <el-table-column prop="id" label="#" width="60"/>
        <el-table-column prop="name" label="Название"/>
        <el-table-column label="Сортировка">
            <template #default="prop">
                <el-input-number
                    v-model="prop.row.sort"
                    @change="updateOfferSort(prop.row)"
                    size="small"
                    class="mr-2"/>
            </template>
        </el-table-column>
        <el-table-column label="Управление">
            <template #default="prop">
                <el-space wrap>
                    <Link :href="route('admin.shop.offer.edit', prop.row.id)"
                          class="el-button el-button--primary el-button--small me-1">Изменить
                    </Link>
                    <v-modal-delete :url="route('admin.shop.offer.delete', prop.row.id)" :refresh="true"/>
                </el-space>
            </template>
        </el-table-column>
    </v-grid>
</template>

<script>
import MainLayout from "../../../../Layouts/MainLayout.vue";
import VGrid from "../../../../components/UI/Data/VGrid.vue";
import VModalDelete from "../../../../components/UI/Feedback/VModalDelete.vue";
import {ElNotification} from "element-plus";

export default {
    name: "Index",
    layout: MainLayout,
    components: {VModalDelete, VGrid},
    props: {
        category: null,
        offers: null,
    },
    data() {
        return {
            sortAscending: false
        }
    },
    methods: {
        updateOfferSort(offer) {
            axios.post(route('admin.shop.offer.updateSort', offer.id), {
                sort: offer.sort
            }).then(() => {
                this.sortOffers()
                ElNotification.success({ message: 'Сортировка обновлена', position: 'bottom-right' });
            }).catch(() => {
                ElNotification.error({ message: 'Ошибка при обновлении сортировки', position: 'bottom-right' });
            });
        },
        toggleSortDirection() {
            this.sortAscending = !this.sortAscending;
            this.sortOffers();
        },
        sortOffers() {
            if (!this.offers || !this.offers.data) return;

            const currentPage = this.offers.meta.current_page || 1;

            axios.post(route('admin.shop.offer.getOfferSort'), {
                sort: this.sortAscending ? 'DESC' : 'ASC',
                page: currentPage,
                categoryId: this.category.data.id
            }).then((response) => {
                this.offers.data = response.data.offers;
            }).catch(() => {
                ElNotification.error({ message: 'Ошибка при обновлении сортировки', position: 'bottom-right' });
            });
            this.offers.data.sort((a, b) =>
                this.sortAscending ? a.sort - b.sort : b.sort - a.sort
            );
        }
    }
}
</script>

<style scoped>

</style>
