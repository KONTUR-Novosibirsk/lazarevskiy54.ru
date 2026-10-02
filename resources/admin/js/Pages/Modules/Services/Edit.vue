<template>
    <el-form label-position="top">
        <el-row :gutter="20">
            <el-col :xs="24" :lg="16" :xl="6">
                <el-card header="Основное">
                    <form-item label="Название" :errors="errors['name']">
                        <el-input v-model="serviceValue.name" :clearable="true"/>
                    </form-item>
                    <form-item label="Алиас" :errors="errors['alias']">
                        <form-alias v-model="serviceValue.alias" :title="serviceValue.name"
                                    :in-real-time="aliasInRealTimeUpdate"/>
                    </form-item>
                    <form-item label="Стоимость" :errors="errors['price']">
                        <el-input v-model="serviceValue.price" clearable/>
                    </form-item>
                    <form-item label="Родительский раздел" :errors="errors['parent_id']">
                        <el-select v-model="serviceValue.parent_id" filterable>
                            <el-option :value="null" label="Основной раздел"/>
                            <el-option
                                v-for="parent in parents"
                                :key="parent.id"
                                :value="parent.id"
                                :label="parent.name"
                            />
                        </el-select>
                    </form-item>
                </el-card>
            </el-col>
            <el-col :xs="24" :lg="16" :xl="12">
                <el-card header="Контент" class="mb-3">
                    <form-item label="Контент" :errors="errors['content']">
                        <v-editor v-model="serviceValue.content"/>
                    </form-item>
                    <form-item label="Описание" :errors="errors['description']">
                        <v-editor v-model="serviceValue.description"/>
                    </form-item>
                </el-card>
                <Drawer title="SEO" button="Seo">
                    <template v-slot:body>
                        <seo-component v-model="serviceValue.seo" :errors="errors"></seo-component>
                    </template>
                </Drawer>
                <Drawer title="Галерея" button="Галерея">
                    <template v-slot:body>
                        <v-upload-editor-images v-model="editorData"
                                                :model_id="serviceValue.id"
                                                :model_type="model"
                                                group="editor"
                        ></v-upload-editor-images>
                    </template>
                </Drawer>
            </el-col>
            <el-col :xs="24" :lg="8" :xl="6">
                <div class="position-sticky-left-bar flex lg:flex-col-reverse">
                    <div class="">
                        <el-card header="Настройки" class="mb-3">
                            <form-item label="Активность" :errors="errors['is_active']">
                                <el-select v-model="serviceValue.is_active">
                                    <el-option label="Активно" :value="true"/>
                                    <el-option label="Не активно" :value="false"/>
                                </el-select>
                            </form-item>
                            <form-item label="Активность на главной" :errors="errors['is_active']">
                                <el-select v-model="serviceValue.is_featured">
                                    <el-option label="Активно" :value="true"/>
                                    <el-option label="Не активно" :value="false"/>
                                </el-select>
                            </form-item>
                            <form-item label="Приоритет сортировки" :errors="errors['sort_order']">
                                <el-input-number v-model="serviceValue.sort_order" :min="0"/>
                            </form-item>
                        </el-card>
                        <el-card class="mb-3" body-class="p-2" header="Превью">
                            <v-upload-image v-model="previewData"
                                            :model_id="serviceValue.id"
                                            :model_type="model"
                                            group="preview"
                            />
                        </el-card>
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
import VUploadImage from "../../../components/UI/Form/VUploadImage.vue";
import VEditor from "../../../components/UI/Form/VEditor.vue";
import FormAlias from "../../../components/UI/Form/FormAlias.vue";
import Drawer from "../../../components/UI/Feedback/Drawer.vue";
import {ElNotification} from "element-plus";
import VUploadEditorImages from "../../../components/UI/Form/VUploadEditorImages.vue";

export default {
    name: "Edit",
    layout: MainLayout,
    mixins: [HandleErrorsMixin],
    props: {
        model: null,
        editor: null,
        preview: null,
        service: null,
        parent: null,
        parents: null,
    },
    data() {
        return {
            loading: false,
            editorData: this.editor.data,
            previewData: this.preview?.data ?? null,
            serviceValue: {
                name: null,
                alias: null,
                price: null,
                content: '',
                description: '',
                is_active: true,
                is_featured: false,
                sort_order: 0,
                seo: null,
                parent_id: this.parent,
            },
            aliasInRealTimeUpdate: true,
        }
    },
    components: {
        VUploadEditorImages,
        Drawer, FormAlias, VEditor, VUploadImage, FormItem,
        MainLayout,
        SeoComponent,
    },
    mounted() {
        if (this.service) {
            this.serviceValue = this.service.data
            if (this.service.data.name) {
                this.aliasInRealTimeUpdate = false
            }
        }
    },
    methods: {
        save() {
            this.loading = true
            this.errors = []
            if (this.service) {
                this.update().finally(() => {
                    this.loading = false
                })
            } else {
                this.store().finally(() => {
                    this.loading = false
                })
            }
        },
        async update() {
            await axios.put(route('admin.services.update', this.service.data.id), this.serviceValue).then((response) => {
                router.visit(route('admin.services.edit', response.data.data.id));
                ElNotification.success({message: 'Услуга сохранена', position: 'bottom-right'});
            }).catch((error) => {
                this.handleErrors(error)
            })
        },
        async store() {
            await axios.post(route('admin.services.store'), this.serviceValue).then((response) => {
                router.visit(route('admin.services.edit', response.data.data.id));
                ElNotification.success({message: 'Услуга создана', position: 'bottom-right'});
            }).catch((error) => {
                this.handleErrors(error)
            })
        }
    }
}
</script>

<style scoped>

</style>
