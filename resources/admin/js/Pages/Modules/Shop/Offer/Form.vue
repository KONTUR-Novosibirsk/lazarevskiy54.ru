<template>
    <el-row :gutter="20">
        <el-col :xs="24" :lg="18">
            <el-card class="mb-2">
                <el-form label-position="top">
                    <form-item label="Название" :errors="errors['name']">
                        <el-input v-model="tradeOffer.name"/>
                    </form-item>
                </el-form>
            </el-card>
            <div class="">
                <h4 :class="{'text-danger': errors['products']}" class="mb-3">Товары</h4>
                <el-row :gutter="20">
                    <el-col :xs="24" :lg="12">
                        <el-scrollbar height="500">
                            <el-alert v-if="tradeOffer.products.length === 0" type="error" :closable="false">
                                Список пуст
                            </el-alert>
                            <el-card v-for="(product, index) in tradeOffer.products" class="mb-1">
                                <div class="flex justify-between">
                                    <div class="">
                                        <div class="">{{ product.title }}</div>
                                        <div class="text-xs mb-1">
                                            Цена: {{ product.price }}
                                            <span v-html="settings('currency', 'Р', 'shop')"></span>
                                        </div>
                                        <el-tag v-for="attribute in getProductAttributes(product)" class="me-1">
                                            {{ attribute }}
                                        </el-tag>
                                    </div>
                                    <div class="">
                                        <a :href="route('admin.shop.product.edit', product.id)"
                                           class="el-button el-button--primary el-button--small" target="_blank">Изменить
                                        </a>
                                        <el-button type="danger" @click="deleteProduct(index)" icon="Delete"
                                                   size="small"/>
                                    </div>
                                </div>
                            </el-card>
                        </el-scrollbar>
                    </el-col>
                    <el-col :xs="24" :lg="12">
                        <el-scrollbar height="500">
                            <el-alert v-if="productsData.length === 0" type="error" :closable="false">
                                Список пуст
                            </el-alert>
                            <el-card v-for="(product) in productsData" class="mb-1">
                                <div class="flex justify-between">
                                    <div class="">
                                        <div class="">{{ product.title }}</div>
                                        <div class="text-muted small mb-1">
                                            Цена: {{ product.price }}
                                            <span v-html="settings('currency', 'Р', 'shop')"></span>
                                        </div>
                                        <el-tag v-for="attribute in getProductAttributes(product)" class="me-1">
                                            {{ attribute }}
                                        </el-tag>
                                    </div>
                                    <div class="">
                                        <a :href="route('admin.shop.product.edit', product.id)"
                                           class="el-button el-button--primary el-button--small" target="_blank">Изменить
                                        </a>
                                        <el-button type="success" @click="addProduct(product)" icon="CirclePlus"
                                                   size="small"/>
                                    </div>
                                </div>
                            </el-card>
                        </el-scrollbar>
                    </el-col>
                </el-row>
            </div>
            <div class="m-2">
                <el-button @click="save" type="primary" :loading="loading">Сохранить</el-button>
            </div>
        </el-col>
        <el-col :xs="24" :lg="6">
            <el-card header="Атрибуты" class="mb-3">
                <el-form label-position="top">
                    <form-item label="Добавить атрибут"
                               :errors="errors['attributes']">
                        <el-select v-model="attribute_id" filterable>
                            <el-option v-for="attribute in attributesData" :value="attribute.key"
                                       :label="attribute.value"/>
                        </el-select>
                    </form-item>
                </el-form>
            </el-card>
            <draggable class=""
                       v-model="tradeOffer.attributes"
                       group="people"
                       handle=".handle"
                       :options="{animation:1300}"
                       item-key="id">
                <template #item="{element, index}">
                    <el-card class="mb-1">
                        <div class="flex justify-between">
                            {{ element.name }}
                            <div class="">
                                <el-button class="cursor-move me-1 handle" type="primary" size="small">
                                    <i class="bi bi-arrows-vertical"></i>
                                </el-button>
                                <el-button type="danger" size="small" @click="deleteAttribute(index)"><i
                                    class="bi bi-trash-fill"></i></el-button>
                            </div>
                        </div>
                    </el-card>
                </template>
            </draggable>
        </el-col>
    </el-row>
</template>

<script>
import MainLayout from "../../../../Layouts/MainLayout.vue";
import HandleErrorsMixin from "../../../../Shared/Mixins/HandleErrorsMixin";
import {router} from "@inertiajs/vue3";
import draggable from "vuedraggable";
import FormItem from "../../../../components/UI/Form/FormItem.vue";
import {ElNotification} from "element-plus";

export default {
    name: "Form",
    layout: MainLayout,
    components: {FormItem, MainLayout, draggable},
    mixins: [HandleErrorsMixin],
    props: {
        category: null,
        attributes: null,
        products: null,
        offer: null,
    },
    data() {
        return {
            loading: false,
            attribute_id: null,
            product_id: null,
            tradeOffer: {
                name: '',
                category_id: null,
                attributes: [],
                products: [],
            },
        }
    },
    watch: {
        attribute_id() {
            this.selectAttribute(this.attribute_id)
            this.attribute_id = null;
        }
    },
    mounted() {
        if (this.offer) {
            this.tradeOffer = {...this.tradeOffer, ...this.offer.data}
        }
        if (this.category) {
            this.tradeOffer.category_id = this.category.data.id
        }

    },
    computed: {
        attributesData() {
            let data = []
            for (let index in this.attributes.data) {
                let attribute = this.tradeOffer.attributes.find((element) => element.id == this.attributes.data[index]['id'])
                if (!attribute) {
                    data.push({
                        key: this.attributes.data[index]['id'],
                        value: this.attributes.data[index]['name'],
                    })
                }
            }
            return data;
        },
        productsData() {
            let data = []
            for (let index in this.products.data) {
                let attribute = this.tradeOffer.products.find((element) => element.id == this.products.data[index]['id'])
                if (!attribute) {
                    data.push(this.products.data[index])
                }
            }
            return data;
        }
    },
    methods: {
        getProductAttributes(product) {
            const attributes = [];
            (this.tradeOffer.attributes || []).forEach((attribute) => {
                let attributeValue = product.attributes.find((f) => f.attribute_id == attribute.id)
                if (attributeValue)
                    attributes.push(attributeValue.value)
            })
            return attributes
        },
        selectAttribute(id) {
            let attribute = this.attributes.data.find((element) => element.id == id)
            if (attribute) {
                this.tradeOffer.attributes.push(attribute);
            }
        },
        deleteAttribute(index) {
            this.tradeOffer.attributes.splice(index, 1)
        },
        addProduct(product) {
            this.tradeOffer.products.push(product)
        },
        deleteProduct(index) {
            this.tradeOffer.products.splice(index, 1)
        },
        async save() {
            this.loading = true
            this.errors = []
            if (this.offer) {
                await this.update()
            } else {
                await this.store()
            }
            this.loading = false
        },
        async store() {
            await axios.post(route('admin.shop.offer.store'), this.tradeOffer).then((response) => {
                ElNotification.success({message: 'Торговое предложение создано', position: 'bottom-right'})
                router.visit(route('admin.shop.offer.edit', response.data.data.id))
            }).catch((errors) => {
                this.handleErrors(errors)
            })
        },
        async update() {
            await axios.patch(route('admin.shop.offer.update', this.tradeOffer.id), this.tradeOffer).then((response) => {
                this.tradeOffer = response.data.data
                ElNotification.success({message: 'Данные обновлены', position: 'bottom-right'})
            }).catch((errors) => {
                this.handleErrors(errors)
            })
        }
    }
}
</script>

<style scoped>

</style>
