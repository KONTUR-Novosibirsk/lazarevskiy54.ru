<template>
    <div class="block lg:flex justify-between">
        <div class="mb-2">
            <template v-if="category">
                <el-dropdown>
                    <el-button type="primary" class="me-3">
                        Добавить
                        <el-icon class="el-icon--right">
                            <Icon icon="lsicon:down-outline"/>
                        </el-icon>
                    </el-button>
                    <template #dropdown>
                        <el-dropdown-menu>
                            <el-dropdown-item class="relative">
                                <Link class="no-underline stretched-link"
                                      :href="route('admin.shop.product.create', category.data.id)">Товар
                                </Link>
                            </el-dropdown-item>
                            <el-dropdown-item class="relative">
                                <Link class="no-underline stretched-link"
                                      :href="route('admin.shop.category.create', category.data.id)">
                                    Категорию
                                </Link>
                            </el-dropdown-item>
                        </el-dropdown-menu>
                    </template>
                </el-dropdown>

                <el-badge :value="offers_count" class="me-3" v-if="settings('with_trade_offers', false, 'shop')">
                    <Link :href="route('admin.shop.offer.index', category.data.id)" class="el-button el-button--primary">
                        Торговые предложения
                    </Link>
                </el-badge>

                <Link :href="route('admin.shop.category.edit', category.data.id)"
                      class="el-button el-button--primary">
                    Редактировать категорию
                </Link>

                <v-modal-delete :url="route('admin.shop.category.delete', category.data.id)"
                                size="default" :refresh="true"/>
            </template>
            <Link v-else :href="route('admin.shop.category.create', category ? category.data.id:null)"
                  class="el-button el-button--primary">Добавить категорию
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
        <div class="flex mb-2">
            <div class="inline-block mb-3">
                <el-input v-model="formFilters.search" :clearable="true" placeholder="Начните ввод для поиска"/>
            </div>
            <div class="ms-2" v-if="$page.props.auth.isDevAdmin">
                <Link :href="route('admin.settings', 'shop')" class="el-button el-button--danger">
                    <i class="bi bi-gear-fill me-1"></i>
                    Настройки
                </Link>
            </div>
        </div>

    </div>
    <el-row class="lg:flex-row-reverse" :gutter="20">
        <el-col :xs="24" :lg="10" :xl="6">
            <el-alert type="error" v-if="categories.data.length === 0" :closable="false">
                Категории отсутствуют
            </el-alert>
            <div v-else>
                <el-card body-class="p-2" class="mb-1" v-for="category in categories.data">
                    <div class="flex justify-between">
                        <Link :href="route('admin.shop.category.show', category.id)"
                              class="el-link el-link--default is-underline">
                            {{ category.title }}
                        </Link>
                        <div class="">
                            <el-input-number
                                v-model="category.sort"
                                @change="updateCategorySort(category)"
                                size="small"
                                class="mr-2"/>
                            <el-button size="small"><i class="bi bi-folder-fill me-1"></i> {{
                                    category.descendants_count
                                }}
                            </el-button>
                            <el-button size="small"><i class="bi bi-bag-fill me-1"></i>
                                {{ category.nested_products_count }}
                            </el-button>
                            <Link class="el-button el-button--primary el-button--small"
                                  :href="route('admin.shop.category.edit', category.id)"><i
                                class="bi bi-pencil-square"></i>
                            </Link>
                        </div>
                    </div>
                </el-card>
            </div>
        </el-col>
        <el-col :xs="24" :lg="14" :xl="18">
            <v-grid :data="products">
                <el-table-column prop="id" label="#" width="60px" sortable="custom"/>
                <el-table-column prop="title" label="Название" sortable="custom">
                    <template #default="prop">
                        <div class="flex">
                            <div>
                                <img :src="prop.row.first_preview ?? '/images/no_image.png'" alt=""
                                     class="product-image me-2" style="width: 50px;">
                            </div>
                            <div class="">
                                {{ prop.row.title }}
                            </div>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column prop="price" label="Стоимость" sortable="custom" width="150px"/>
                <el-table-column prop="sort" label="Порядок сортировки">
                    <template #default="prop">
                        <el-input-number
                            v-model="prop.row.sort"
                            @change="updateProductSort(prop.row)"
                            size="small"
                            class="mr-2"
                        />
                    </template>
                </el-table-column>
                <el-table-column label="Управление">
                    <template #default="prop">
                        <el-space wrap>
                            <Link :href="route('admin.shop.product.edit', prop.row.id)"
                                  class="el-button el-button--primary el-button--small">Изменить
                            </Link>
                            <v-modal-delete :url="route('admin.shop.product.delete', prop.row.id)" :refresh="true"/>
                        </el-space>
                    </template>
                </el-table-column>
            </v-grid>
        </el-col>
    </el-row>
</template>

<script>
import MainLayout from "../../../Layouts/MainLayout.vue";
import FilterMixin from "../../../Shared/Mixins/FilterMixin";
import PreviewPage from "../../../Shared/PreviewPage.vue";
import VGrid from "../../../components/UI/Data/VGrid.vue";
import VModalDelete from "../../../components/UI/Feedback/VModalDelete.vue";
import {ElNotification} from "element-plus";

export default {
    name: "Index",
    layout: MainLayout,
    mixins: [FilterMixin],
    components: {VModalDelete, VGrid, PreviewPage, MainLayout},
    props: {
        offers_count: 0,
        categories: {
            default: {},
            type: Object,
        },
        products: {
            default: {},
            type: Object,
        },
        category: null,
    },
    data() {
        return {
            filterUrl: this.category ? route('admin.shop.category.show', this.category.data.id) : route('admin.shop.index'),
            formFilters: {
                search: this.filters.search,
                active: this.filters.active
            },
        }
    },
    methods: {
        updateCategorySort(category) {
            axios.post(route('admin.shop.category.updateSort', category.id), {
                sort: category.sort
            }).then(() => {
                this.categories.data.sort((a, b) => a.sort - b.sort);
                ElNotification.success({ message: 'Сортировка обновлена', position: 'bottom-right' });
            }).catch(() => {
                ElNotification.error({ message: 'Ошибка при обновлении сортировки', position: 'bottom-right' });
            });
        },
        updateProductSort(product) {
            axios.post(route('admin.shop.product.updateSort', product.id), {
                sort: product.sort
            }).then(() => {
                this.sortProducts();
                ElNotification.success({ message: 'Сортировка обновлена', position: 'bottom-right' });
            }).catch(() => {
                ElNotification.error({ message: 'Ошибка при обновлении сортировки', position: 'bottom-right' });
            });
        },
        toggleSortDirection() {
            this.sortAscending = !this.sortAscending;
            this.sortProducts();
        },
        sortProducts() {
            if (!this.products || !this.products.data) return;

            const currentPage = this.products.meta.current_page || 1;

            axios.post(route('admin.shop.product.getProductsSort'), {
                sort: this.sortAscending ? 'DESC' : 'ASC',
                page: currentPage,
                category: this.category ? this.category.data : []
            }).then((response) => {
                this.products.data = response.data.products;
            }).catch(() => {
                ElNotification.error({ message: 'Ошибка при обновлении сортировки', position: 'bottom-right' });
            });
            this.products.data.sort((a, b) =>
                this.sortAscending ? a.sort - b.sort : b.sort - a.sort
            );
        }
    }
}
</script>

<style scoped>
.product-image {
    aspect-ratio: 4 / 3;
    object-fit: cover;
}
</style>
