<template>
    <el-form label-position="top">
        <el-row :gutter="20">
            <el-col :xs="24" :lg="16" :xl="18">
                <el-card header="Основное" class="mb-2">
                    <form-item label="Название" :errors="errors['title']">
                        <el-input v-model="categoryValue.title"/>
                    </form-item>
                    <form-item label="Описание" :errors="errors['description']">
                        <v-editor v-model="categoryValue.description"/>
                    </form-item>
                </el-card>
            </el-col>
            <el-col :xs="24" :lg="8" :xl="6">
                <el-card header="Дополнительно" class="mb-3">
                    <form-item label="Категория" :errors="errors['parent_id']">
                        <el-select v-model="categoryValue.parent_id" filterable>
                            <el-option v-for="parentCategory in categoriesForSelect"
                                       :value="parentCategory.key"
                                       :label="parentCategory.value"
                            ></el-option>
                        </el-select>
                    </form-item>
                    <form-item :errors="errors['alias']" label="Алиас">
                        <form-alias v-model="categoryValue.alias" :title="categoryValue.title"
                                    :in-real-time="aliasInRealTimeUpdate"/>
                    </form-item>
                    <form-item label="Фильтр" :errors="errors['filter_id']">
                        <el-select v-model="categoryValue.filter_id" filterable>
                            <el-option v-for="selectFilter in filters"
                                       :value="selectFilter.key"
                                       :label="selectFilter.value"
                            ></el-option>
                        </el-select>
                    </form-item>
                    <form-item label="Отображать на главной странице" :errors="errors['show_on_index_page']">
                        <el-select v-model="categoryValue.show_on_index_page">
                            <el-option label="Да" :value="true"/>
                            <el-option label="Нет" :value="false"/>
                        </el-select>
                    </form-item>
                    <form-item label="Порядок сортировки" :errors="errors['sort']">
                        <el-input-number v-model="categoryValue.sort">
                        </el-input-number>
                    </form-item>
                </el-card>
                <el-card class="mb-3" body-class="p-2" header="Превью">
                    <v-upload-image :model_id="categoryValue.id" :model_type="model"
                                    v-model="categoryValue.preview" group="preview"/>
                </el-card>
                <div class="mb-2">
                    <Drawer title="SEO" button="Seo">
                        <template v-slot:body>
                            <seo-component v-model="categoryValue.seo" :errors="errors"></seo-component>
                        </template>
                    </Drawer>
                    <Drawer title="Галерея" button="Галерея">
                        <template v-slot:body>
                            <v-upload-editor-images :model_id="categoryValue.id" :model_type="model"
                                                    group="editor" v-model="imagesData"/>
                        </template>
                    </Drawer>
                </div>
                <el-button :loading="loading" type="primary" @click="save">Сохранить</el-button>
            </el-col>
        </el-row>
    </el-form>
</template>

<script>
import SeoComponent from "../../../../components/seo/SeoComponent.vue";
import MainLayout from "../../../../Layouts/MainLayout.vue";
import {router} from '@inertiajs/vue3'
import HandleErrorsMixin from "../../../../Shared/Mixins/HandleErrorsMixin";
import FormItem from "../../../../components/UI/Form/FormItem.vue";
import VEditor from "../../../../components/UI/Form/VEditor.vue";
import FormAlias from "../../../../components/UI/Form/FormAlias.vue";
import VUploadImage from "../../../../components/UI/Form/VUploadImage.vue";
import Drawer from "../../../../components/UI/Feedback/Drawer.vue";
import VUploadEditorImages from "../../../../components/UI/Form/VUploadEditorImages.vue";
import {ElNotification} from "element-plus";

export default {
    name: "Edit",
    layout: MainLayout,
    mixins: [HandleErrorsMixin],
    props: {
        filters: null,
        attributes: null,
        model: null,
        preview: null,
        category: null,
        images: null,
        categories: {
            type: Object,
            default: {},
        },
        parentCategory: null,
    },
    data() {
        return {
            loading: false,
            imagesData: this.images.data,
            categoryValue: {
                parent_id: 0,
                title: null,
                preview: null,
                alias: null,
                show_on_index_page: false,
                description: null,
                seo: null,
                filter_id: null,
                sort: 0
            },
            aliasInRealTimeUpdate: true,
        }
    },
    components: {
        VUploadEditorImages,
        Drawer,
        VUploadImage,
        FormAlias,
        VEditor,
        FormItem,
        SeoComponent,
    },
    mounted() {
        if (this.category) {
            this.categoryValue = this.category.data;
            if (this.category.data.title) this.aliasInRealTimeUpdate = false;
            if (this.category.data.parent_id) this.categoryValue.parent_id = this.category.data.parent_id;
            else this.categoryValue.parent_id = 0;
        }
        if (this.preview)
            this.categoryValue.preview = this.preview.data;
        if (this.parentCategory) {
            this.categoryValue.parent_id = this.parentCategory.data.id;
        }
    },
    computed: {
        categoriesForSelect() {
            let categories = [];
            categories.push({
                key: 0,
                value: 'Root',
            })
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
        async save() {
            this.errors = []
            this.loading = true
            if (this.category) {
                await this.update()
            } else {
                await this.store()
            }
            this.loading = false
        },
        async store() {
            await axios.post(route('admin.shop.category.store'), this.categoryValue).then((response) => {
                router.visit(route('admin.shop.category.edit', response.data.data.id))
                ElNotification.success({message: 'Новая категория создана', position: 'bottom-right'})
            }).catch((error) => {
                this.handleErrors(error)
            })
        },
        async update() {
            await axios.patch(route('admin.shop.category.update', this.category.data.id), this.categoryValue).then((response) => {
                ElNotification.success({message: 'Данные сохранены', position: 'bottom-right'})
            }).catch((error) => {
                this.handleErrors(error)
            })
        }
    }

}
</script>
