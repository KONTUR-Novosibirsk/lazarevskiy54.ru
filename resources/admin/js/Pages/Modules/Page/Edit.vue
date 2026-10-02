<template>
    <el-form label-position="top">
        <el-row :gutter="20">
            <el-col :xs="24" :lg="16" :xl="18">
                <el-card header="Основное" class="mb-3">
                    <form-item label="Название" :errors="errors['title']">
                        <el-input v-model="pageValue.title"/>
                    </form-item>
                    <form-item label="Текст" :errors="errors['text']">
                        <v-editor v-model="pageValue.text"/>
                    </form-item>
                </el-card>
            </el-col>
            <el-col :xs="24" :lg="8" :xl="6">
                <div class="position-sticky-left-bar flex lg:flex-col-reverse">
                    <div class="">
                        <el-card header="Дополнительно" class="mb-3">
                            <form-item label="Алиас" :errors="errors['alias']">
                                <form-alias v-model="pageValue.alias" :title="pageValue.title"
                                            :in-real-time="aliasInRealTimeUpdate"/>
                            </form-item>
                            <form-item label="Шаблон страницы" :errors="errors['template']">
                                <el-select v-model="pageValue.template">
                                    <el-option v-for="template in templates" :label="template.value"
                                               :value="template.key"/>
                                </el-select>
                            </form-item>
                            <form-item label="Активность" :errors="errors['active']">
                                <el-select v-model="pageValue.active">
                                    <el-option label="Активно" :value="true"/>
                                    <el-option label="Не активно" :value="false"/>
                                </el-select>
                            </form-item>
                        </el-card>
                        <el-card class="mb-3" body-class="p-2" header="Превью">
                            <v-upload-image v-model="pageValue.preview"
                                            :model_id="pageValue.id"
                                            :model_type="model"
                                            group="preview"
                            />
                        </el-card>
                        <div class="mb-2">
                            <Drawer title="SEO" button="Seo">
                                <template v-slot:body>
                                    <seo-component v-model="pageValue.seo" :errors="errors"></seo-component>
                                </template>
                            </Drawer>
                            <Drawer title="Галерея" button="Галерея">
                                <template v-slot:body>
                                    <v-upload-editor-images v-model="imagesData"
                                                            :model_id="pageValue.id"
                                                            :model_type="model"
                                                            group="editor"/>
                                </template>
                            </Drawer>
                            <Drawer title="Файлы" button="Файлы">
                                <template v-slot:body>
                                    <v-upload-files v-model="pageValue.files"
                                                    :model_id="pageValue.id"
                                                    :model_type="model"
                                                    group="editor"/>
                                </template>
                            </Drawer>
                        </div>
                    </div>
                    <div class="mb-2">
                        <el-button :loading="loading" @click="save" type="primary">
                            Сохранить
                        </el-button>
                    </div>
                </div>
            </el-col>
        </el-row>
    </el-form>
</template>

<script>
import SeoComponent from "../../../components/seo/SeoComponent.vue";
import MainLayout from "../../../Layouts/MainLayout.vue";
import {router} from "@inertiajs/vue3";
import HandleErrorsMixin from "../../../Shared/Mixins/HandleErrorsMixin";
import FormItem from "../../../components/UI/Form/FormItem.vue";
import FormAlias from "../../../components/UI/Form/FormAlias.vue";
import Drawer from "../../../components/UI/Feedback/Drawer.vue";
import {ElNotification} from "element-plus";
import VEditor from "../../../components/UI/Form/VEditor.vue";
import VUploadImage from "../../../components/UI/Form/VUploadImage.vue";
import VUploadEditorImages from "../../../components/UI/Form/VUploadEditorImages.vue";
import VUploadFiles from "../../../components/UI/Form/VUploadFiles.vue";

export default {
    name: "Edit",
    layout: MainLayout,
    mixins: [HandleErrorsMixin],
    props: {
        files: null,
        model: null,
        page: null,
        images: null,
        preview: null,
        templates: null,
    },
    data() {
        return {
            loading: false,
            imagesData: this.images.data,
            pageValue: {
                title: null,
                alias: null,
                text: '',
                active: false,
                template: 'default',
                seo: null,
                preview: null,
                files: [],
            },
            aliasInRealTimeUpdate: true,
        }
    },
    components: {
        VUploadFiles,
        VUploadEditorImages,
        VUploadImage,
        VEditor,
        Drawer,
        FormAlias,
        FormItem,
        SeoComponent,
    },
    mounted() {
        if (this.page) {
            if (this.page.data.title) this.aliasInRealTimeUpdate = false
            this.pageValue = this.page.data
        }
        if(this.preview)
            this.pageValue.preview = this.preview.data
        if(this.files)
            this.pageValue.files = this.files.data
    },
    methods: {
        async save() {
            this.loading = true
            this.errors = []
            if (this.page) {
                await this.update()
            } else {
                await this.store()
            }
            this.loading = false
        },
        async update() {
            await axios.patch(route('admin.page.update', this.page.data.id), this.pageValue).then((response) => {
                this.pageValue = response.data.data
                ElNotification({
                    message: 'Страница сохранена',
                    type: 'success',
                    position: 'bottom-right',
                })
            }).catch((error) => {
                this.handleErrors(error)
            })
        },
        async store() {
            await axios.post(route('admin.page.store'), this.pageValue).then((response) => {
                router.visit(route('admin.page.edit', response.data.data.id))
                ElNotification({
                    title: 'Система',
                    message: 'Страница создана',
                    type: 'success',
                    position: 'bottom-right',
                })
            }).catch((error) => {
                this.handleErrors(error)
            })
        }
    }
}
</script>
