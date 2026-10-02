<template>
    <el-form label-position="top">
        <el-row :gutter="20">
            <el-col :xs="24" :lg="16" :xl="18">
                <el-card class="mb-3">
                    <template #header>Основное</template>
                    <form-item label="Название" :errors="errors['title']">
                        <el-input v-model="newsValue.title"/>
                    </form-item>
                    <form-item label="Название" :errors="errors['text']">
                        <v-editor v-model="newsValue.text"/>
                    </form-item>
                </el-card>
            </el-col>
            <el-col :xs="24" :lg="8" :xl="6">
                <div class="position-sticky-left-bar flex flex-col lg:flex-col-reverse">
                    <div class="">
                        <el-card class="mb-3">
                            <template #header>Дополнительно</template>
                            <form-item label="Дата публикации" :errors="errors['publication_date']">
                                <el-date-picker
                                    class="max-w-full"
                                    v-model="newsValue.publication_date"
                                    type="datetime"
                                    format="YYYY-MM-DD HH:mm:ss"
                                    value-format="YYYY-MM-DD HH:mm:ss"
                                    placeholder="Дата публикации"
                                />
                            </form-item>
                            <form-item label="Алиас" :errors="errors['alias']">
                                <form-alias
                                    :in-real-time="aliasInRealTimeUpdate"
                                    v-model="newsValue.alias"
                                    :title="newsValue.title"
                                    placeholder="Алиас"
                                />
                            </form-item>
                            <form-item label="Порядок сортировки" :errors="errors['sort']">
                                <el-input-number v-model="newsValue.sort">
                                </el-input-number>
                            </form-item>
                        </el-card>

                        <el-card class="mb-3" body-class="p-2">
                            <template #header>Превью</template>
                            <v-upload-image v-model="newsValue.preview"
                                            :model_type="model"
                                            :model_id="newsValue.id"
                                            group="preview"
                            ></v-upload-image>
                        </el-card>

                        <div class="mb-2">
                            <Drawer title="SEO" button="Seo">
                                <template v-slot:body>
                                    <seo-component v-model="newsValue.seo" :errors="errors"></seo-component>
                                </template>
                            </Drawer>
                            <Drawer title="Галерея" button="Галерея">
                                <template v-slot:body>
                                    <v-upload-editor-images v-model="imagesData"
                                                            :model_type="model"
                                                            :model_id="newsValue.id"
                                                            group="editor"/>
                                </template>
                            </Drawer>
                            <Drawer title="Файлы" button="Файлы">
                                <template v-slot:body>
                                    <v-upload-files v-model="newsValue.files"
                                                    :model_id="news.data.id"
                                                    :model_type="model"
                                                    group="editor"
                                    ></v-upload-files>
                                </template>
                            </Drawer>
                        </div>
                    </div>

                    <div class="mb-2">
                        <el-button :loading="isUpdate" @click="update" type="primary">
                            {{ this.updateOrPublish }}
                        </el-button>
                        <el-button :loading="isUpdateDraft" @click="updateDraft">
                            Сохранить как черновик
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
import HandleErrorsMixin from "../../../Shared/Mixins/HandleErrorsMixin";
import FormItem from "../../../components/UI/Form/FormItem.vue";
import FormAlias from "../../../components/UI/Form/FormAlias.vue";
import {ElNotification} from "element-plus";
import Drawer from "../../../components/UI/Feedback/Drawer.vue";
import VUploadEditorImages from "../../../components/UI/Form/VUploadEditorImages.vue";
import VUploadFiles from "../../../components/UI/Form/VUploadFiles.vue";
import VEditor from "../../../components/UI/Form/VEditor.vue";
import VUploadImage from "../../../components/UI/Form/VUploadImage.vue";

export default {
    name: "Edit",
    layout: MainLayout,
    mixins: [HandleErrorsMixin],
    props: {
        model: null,
        news: null,
        images: null,
        upload_url: '/admin/index',
    },
    data() {
        return {
            newsValue: {
                title: null,
                alias: null,
                text: null,
                publication_date: null,
                active: false,
                seo: null,
                files: [],
                sort: 0
            },
            imagesData: this.images.data,
            aliasInRealTimeUpdate: true,
            isUpdate: false,
            isUpdateDraft: false,
        }
    },
    components: {
        VUploadImage,
        VEditor,
        VUploadFiles,
        VUploadEditorImages,
        Drawer,
        FormAlias,
        FormItem,
        SeoComponent,
    },
    mounted() {
        if (this.news) {
            if (this.news.data.title) this.aliasInRealTimeUpdate = false
            this.newsValue = this.news.data
        }
    },
    computed: {
        updateOrPublish() {
            return this.newsValue.active === true ? 'Сохранить' : 'Опубликовать'
        }
    },
    methods: {
        update() {
            this.errors = []
            this.isUpdate = true
            axios.patch(route('admin.news.update', this.news.data.id), this.newsValue).then((response) => {
                this.newsValue = response.data.data
                ElNotification({
                    title: 'Система',
                    message: 'Новость сохранена',
                    type: 'success',
                    position: 'bottom-right',
                })
            }).catch((error) => {
                this.handleErrors(error)
            }).finally(() => {
                this.isUpdate = false
            })
        },
        updateDraft() {
            this.errors = []
            this.isUpdateDraft = true
            axios.patch(route('admin.news.saveDraft', this.news.data.id), this.newsValue).then((response) => {
                this.newsValue = response.data.data
                ElNotification({
                    title: 'Система',
                    message: 'Сохранено как черновик',
                    type: 'success',
                    position: 'bottom-right',
                })
            }).catch((error) => {
                this.handleErrors(error)
            }).finally(() => {
                this.isUpdateDraft = false
            })
        }
    }
}
</script>
