<template>
    <el-row :gutter="20">
        <el-col :xs="24" :lg="14" class="mb-3">
            <el-card>
                <div class="mb-1">
                    <span class="fw-bold">Имя:</span> {{ orderData.user_name }}
                </div>
                <div class="mb-1">
                    <span class="fw-bold">Телефон:</span> {{ orderData.user_phone }}
                </div>
                <div class="mb-1">
                    <span class="fw-bold">E-mail:</span> {{ orderData.user_email }}
                </div>
                <div class="">
                    <span class="fw-bold">Адрес:</span> {{ orderData.address }}
                </div>
            </el-card>
        </el-col>
        <el-col :xs="24" :lg="10" class="mb-3">
            <el-card v-loading="loading" class="flex flex-col">
                <div class="mb-2">
                    <div class="mb-1">
                        <span class="fw-bold">Создан:</span> {{ orderData.date_for_human }}
                    </div>
                    <div class="">
                        <span class="fw-bold">Обновлен:</span> {{ orderData.updated_at }}
                    </div>
                </div>
                <el-button class="w-full" size="large" :type="orderData.status === 0 ? 'danger' : 'success'"
                           @click="changeStatus">
                    {{ orderData.status === 0 ? 'В работе' : 'Завершен' }}
                </el-button>
            </el-card>
        </el-col>
    </el-row>

    <el-table :data="productsData" border>
        <el-table-column label="Товар" prop="title">
            <template #default="prop">
                <div class="flex" v-if="prop.row.title">
                    <div>
                        <img :src="prop.row.first_preview ?? '/images/no_image.png'" alt=""
                             class="product-image me-2" style="width: 50px;">
                    </div>
                    <div class="">
                        {{ prop.row.title }}
                    </div>
                </div>
                <div v-for="attr in prop.row.attributesValue" :key="attr.id">
                    <span class="font-extrabold">{{ attr.attribute.name }}:</span> {{ attr.value }}
                </div>
            </template>
        </el-table-column>
        <el-table-column label="Цена" prop="currentPrice">
            <template #default="prop">
                <template v-if="prop.row.currentPrice">
                    {{ prop.row.currentPrice }}<span v-html="settings('currency', 'рубль', 'shop')"></span>
                </template>
            </template>
        </el-table-column>
        <el-table-column prop="count" label="Количество"/>
        <el-table-column label="Итого">
            <template #default="prop">
                <template v-if="prop.row.count"> {{ prop.row.currentPrice * prop.row.count }}<span
                    v-html="settings('currency', 'рубль', 'shop')"></span></template>
                <template v-else>{{ prop.row.amount }} <span v-html="settings('currency', 'рубль', 'shop')"></span>
                </template>
            </template>
        </el-table-column>
    </el-table>

</template>

<script>
import MainLayout from "../../../../Layouts/MainLayout.vue";

export default {
    name: "Show",
    layout: MainLayout,
    props: {
        products: null,
        order: null,
    },
    data() {
        return {
            loading: false,
            orderData: this.order.data
        }
    },
    computed: {
        productsData() {
            const products = [...this.products.data]
            products.push({
                price: null,
                count: null,
                amount: this.orderData.price
            })
            return products
        }
    },
    methods: {
        changeStatus() {
            this.loading = true
            axios.patch(route('admin.shop.order.changeStatus', this.orderData.id), {
                status: this.orderData.status === 0 ? 5 : 0
            }).then((response) => {
                this.orderData = response.data.data
            }).catch((errors) => {
                if (errors.response['status'] === 422) {
                    this.alertsStore.add('error', 'Ошибка валидации')
                } else {
                    this.alertsStore.add('error', 'Неизвестная ошибка')
                }
            }).finally(() => {
                this.loading = false
            })
        }
    }
}
</script>

<style scoped>

</style>
