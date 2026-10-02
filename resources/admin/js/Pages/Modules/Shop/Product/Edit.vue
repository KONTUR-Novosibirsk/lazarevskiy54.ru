<template>
    <el-row :gutter="20">
        <el-col :xs="24" :lg="12">
            <el-card header="Изображения товара" class="mb-2">
                <v-upload-images v-model="previewsData"
                                 :model_type="model"
                                 :model_id="productValue.id"
                                 group="preview"/>
            </el-card>
            <el-card header="Основное" class="mb-2">
                <el-form label-position="top">
                    <form-item label="Название" :errors="errors['title']">
                        <el-input v-model="productValue.title"/>
                    </form-item>
                    <form-item label="Описание" :errors="errors['description']">
                        <v-editor v-model="productValue.description"/>
                    </form-item>
                </el-form>
            </el-card>
        </el-col>
        <el-col :xs="24" :lg="12">
            <el-row :gutter="20">
                <el-col :xs="24" :lg="12">
                    <el-card header="Видимость" class="mb-2">
                        <el-form label-position="right">
                            <form-item label="Активно" :errors="errors['active']">
                                <el-switch v-model="productValue.active"/>
                            </form-item>
                            <form-item label="Хит продаж" :errors="errors['hit']">
                                <el-switch v-model="productValue.hit"/>
                            </form-item>
                            <form-item label="Отображать на главной" :errors="errors['show_on_index_page']">
                                <el-switch v-model="productValue.show_on_index_page"/>
                            </form-item>
                            <form-item label="Отображать на главной магазина"
                                       :errors="errors['show_on_shop_index_page']">
                                <el-switch v-model="productValue.show_on_shop_index_page"/>
                            </form-item>
                        </el-form>
                    </el-card>
                </el-col>
                <el-col :xs="24" :lg="12">
                    <el-card header="Дополнительно" class="mb-2">
                        <el-form label-position="top">
                            <form-item :errors="errors['category_id']" label="Категория">
                                <el-select v-model="productValue.category_id" filterable>
                                    <el-option v-for="category in categoriesForSelect"
                                               :value="category.key" :label="category.value"/>
                                </el-select>
                            </form-item>
                            <form-item :errors="errors['alias']" label="Алиас">
                                <form-alias v-model="productValue.alias" :title="productValue.title"
                                            :in-real-time="aliasInRealTimeUpdate"/>
                            </form-item>
                            <form-item label="Цена" :errors="errors['price']">
                                <el-input-number v-model="productValue.price" class="w-full" controls-position="right"/>
                            </form-item>
                            <form-item label="Старая цена" :errors="errors['old_price']">
                                <el-input-number v-model="productValue.old_price" class="w-full"
                                                 controls-position="right"/>
                            </form-item>
                            <form-item label="Порядок сортировки" :errors="errors['sort']">
                                <el-input-number v-model="productValue.sort">
                                </el-input-number>
                            </form-item>
                        </el-form>
                    </el-card>
                    <div class="mb-2">
                        <Drawer title="SEO" button="Seo">
                            <template v-slot:body>
                                <seo-component v-model="productValue.seo" :errors="errors"></seo-component>
                            </template>
                        </Drawer>
                        <Drawer title="Галерея" button="Галерея">
                            <template v-slot:body>
                                <v-upload-editor-images v-model="imagesData"
                                                        :model_id="productValue.id"
                                                        :model_type="model"
                                                        group="editor"/>
                            </template>
                        </Drawer>
                        <Drawer title="Атрибуты" button="Атрибуты">
                            <template v-slot:body>
                                <AttributesComponent :attributes="attributes"
                                                     v-model="productValue.attributes_for_edit"
                                                     :errors="errors"/>
                            </template>
                        </Drawer>
                    </div>
                    <el-button type="primary" @click="save" :loading="loading">Сохранить</el-button>
                    <el-button type="danger" @click="clone" :loading="cloning">Клонировать</el-button>
                </el-col>
            </el-row>
        </el-col>
    </el-row>
</template>

<script>

import SeoComponent from "../../../../components/seo/SeoComponent.vue";
import MainLayout from "../../../../Layouts/MainLayout.vue";
import {router} from "@inertiajs/vue3";
import AttributesComponent from "./AttributesComponent.vue";
import HandleErrorsMixin from "../../../../Shared/Mixins/HandleErrorsMixin";
import VUploadImages from "../../../../components/UI/Form/VUploadImages.vue";
import FormItem from "../../../../components/UI/Form/FormItem.vue";
import VEditor from "../../../../components/UI/Form/VEditor.vue";
import FormAlias from "../../../../components/UI/Form/FormAlias.vue";
import Drawer from "../../../../components/UI/Feedback/Drawer.vue";
import VUploadEditorImages from "../../../../components/UI/Form/VUploadEditorImages.vue";
import {ElNotification} from "element-plus";

export default {
    name: "ProductEditorComponent",
    layout: MainLayout,
    mixins: [HandleErrorsMixin],
    props: {
        attributes: null,
        model: null,
        product: null,
        previewImages: null,
        images: null,
        parent_category: {
            type: Object,
        },
        categories: {
            type: Object,
            default: {},
        },
    },
    data() {
        return {
            ready: false,
            loading: false,
            cloning: false,
            previewsData: this.previewImages.data,
            imagesData: this.images.data,
            productValue: {
                attributes_for_edit: null,
                category_id: 0,
                price: 0,
                old_price: 0,
                active: true,
                hit: false,
                show_on_index_page: false,
                show_on_shop_index_page: false,
                title: null,
                alias: null,
                description: null,
                seo: null,
                sort: 0
            },
            aliasInRealTimeUpdate: true,
        }
    },
    components: {
        VUploadEditorImages,
        Drawer,
        FormAlias,
        VEditor,
        FormItem,
        VUploadImages,
        AttributesComponent,
        SeoComponent,
    },
    mounted() {
        if (this.parent_category) this.productValue.category_id = this.parent_category.data.id
        if (this.product) {
            if (this.product.data.title) this.aliasInRealTimeUpdate = false
            this.productValue = this.product.data
        }
    },
    computed: {
        uploadPreviewUrl() {
            if (this.product) {
                return '/admin/shop/product/uploadPreview/' + this.product.data.id
            }
            return '/admin/shop/product/uploadPreview'
        },
        categoriesForSelect() {
            let categories = [];
            for (let category of this.categories.data) {
                categories.push({
                    key: category.id,
                    value: category.title,
                })
            }
            return categories
        }
    },
    methods: {
        clone() {
            this.cloning = true
            axios.get(route('admin.shop.product.clone', this.product.data.id)).then((response) => {
                ElNotification.success({message: 'Товар скопирован', position: 'bottom-right'})
                router.visit(route('admin.shop.product.edit', response.data.data.id));
            }).catch((error) => this.handleErrors(error)).finally(() => this.cloning = false)
        },
        async save() {
            if (this.loading) return
            this.errors = []
            this.loading = true
            if (this.product) {
                await this.update()
            } else {
                await this.store()
            }
            this.loading = false
        },
        async store() {
            await axios.post(route('admin.shop.product.store'), this.productValue).then((response) => {
                if (response.status === 201) {
                    router.visit(route('admin.shop.product.edit', response.data.data.id))
                }
            }).catch((error) => {
                this.handleErrors(error)
            })
        },
        async update() {
            await axios.patch('/admin/shop/product/update/' + this.product.data.id, this.productValue).then((response) => {
                ElNotification.success({message: 'Данные сохранены', position: 'bottom-right'})
            }).catch((error) => {
                this.handleErrors(error)
            })
        }
    }
}
</script>

<style lang="scss" scoped>
.add-image {
    border: 4px dashed #494949;
    cursor: pointer;

    &:hover {
        opacity: 0.7;
    }

}
</style>
