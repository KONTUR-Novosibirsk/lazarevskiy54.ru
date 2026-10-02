<template>
    <el-form label-position="top">
        <el-row :gutter="20">
            <el-col :xs="24" :lg="16" :xl="18">
                <el-card header="Основное">
                    <form-item label="Название" :errors="errors['title']">
                        <el-input v-model="saleValue.title" :clearable="true"/>
                    </form-item>
                    <form-item label="Описание" :errors="errors['title']">
                        <v-editor v-model="saleValue.text"/>
                    </form-item>
                </el-card>
            </el-col>
            <el-col :xs="24" :lg="8" :xl="6">
                <div class="position-sticky-left-bar flex lg:flex-col-reverse">
                    <div class="">
                        <el-card header="Дополнительно" class="mb-3">
                            <form-item label="Алиас" :errors="errors['alias']">
                                <form-alias v-model="saleValue.alias" :title="saleValue.title"
                                            :in-real-time="aliasInRealTimeUpdate"/>
                            </form-item>
                            <form-item label="Дата начала" :errors="errors['start_date']">
                                <el-date-picker
                                    class="max-w-full"
                                    v-model="saleValue.start_date"
                                    type="datetime"
                                    format="YYYY-MM-DD HH:mm:ss"
                                    value-format="YYYY-MM-DD HH:mm:ss"
                                    placeholder="Дата начала"
                                />
                            </form-item>
                            <form-item label="Дата окончания" :errors="errors['end_date']">
                                <el-date-picker
                                    class="max-w-full"
                                    v-model="saleValue.end_date"
                                    type="datetime"
                                    format="YYYY-MM-DD HH:mm:ss"
                                    value-format="YYYY-MM-DD HH:mm:ss"
                                    placeholder="Дата окончания"
                                />
                            </form-item>
                            <form-item label="Порядок сортировки" :errors="errors['sort']">
                                <el-input-number v-model="saleValue.sort">
                                </el-input-number>
                            </form-item>
                        </el-card>
                        <el-card class="mb-3" body-class="p-2" header="Превью">
                            <v-upload-image v-model="saleValue.preview"
                                            :model_id="saleValue.id"
                                            :model_type="model"
                                            group="preview"
                            />
                        </el-card>
                        <div class="mb-2">
                            <Drawer title="SEO" button="Seo">
                                <template v-slot:body>
                                    <seo-component v-model="saleValue.seo" :errors="errors"></seo-component>
                                </template>
                            </Drawer>
                            <Drawer title="Галерея" button="Галерея">
                                <template v-slot:body>
                                    <v-upload-editor-images v-model="imagesData"
                                                            :model_id="saleValue.id"
                                                            :model_type="model"
                                                            group="editor"
                                    ></v-upload-editor-images>
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
import VEditor from "../../../components/UI/Form/VEditor.vue";
import Drawer from "../../../components/UI/Feedback/Drawer.vue";
import VUploadImage from "../../../components/UI/Form/VUploadImage.vue";
import FormAlias from "../../../components/UI/Form/FormAlias.vue";
import {ElNotification} from "element-plus";
import VUploadEditorImages from "../../../components/UI/Form/VUploadEditorImages.vue";

export default {
    name: "Edit",
    layout: MainLayout,
    mixins: [HandleErrorsMixin],
    props: {
        model: null,
        sale: null,
        images: null,
        preview: null,
    },
    data() {
        return {
            loading: false,
            imagesData: this.images.data,
            saleValue: {
                title: null,
                alias: null,
                text: '',
                start_date: null,
                end_date: null,
                seo: null,
                preview: null,
                sort: 0
            },
            aliasInRealTimeUpdate: true,
        }
    },
    components: {
        VUploadEditorImages,
        FormAlias, VUploadImage, Drawer,
        VEditor,
        FormItem,
        SeoComponent,
    },
    mounted() {
        if (this.sale) {
            this.saleValue = this.sale.data
            if (this.sale.data.title) {
                this.aliasInRealTimeUpdate = false
            }
        }
        if (this.preview)
            this.saleValue.preview = this.preview.data
    },
    methods: {
        save() {
            this.loading = true
            this.errors = []
            if (this.sale) {
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
            await axios.patch(route('admin.sale.update', this.sale.data.id), this.saleValue).then((response) => {
                this.saleValue = response.data.data
                ElNotification({
                    message: 'Акция обновлена',
                    type: 'success',
                    position: 'bottom-right',
                })
                this.errors = []
            }).catch((error) => {
                this.handleErrors(error)
            })
        },
        async store() {
            await axios.post(route('admin.sale.store'), this.saleValue).then((response) => {
                router.visit(route('admin.sale.edit', response.data.data.id))
                ElNotification({
                    message: 'Акция создана',
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

<style scoped>

</style>
