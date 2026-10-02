<template>
    <el-row :gutter="20" class="lg:flex-row-reverse">
        <el-col :xs="24" :lg="8">
            <el-card body-class="p-0">
                <div class="shadow-sm">
                    <img :src="galleryData.image ? galleryData.image.full : '/images/no_image.png'" alt=""
                         class="max-w-full object-cover aspect-[6/2]">
                </div>
                <div class="p-2">
                    <el-form label-position="top">
                        <form-item label="Название" :errors="errors['name']">
                            <el-input v-model="galleryData.name"/>
                        </form-item>
                        <form-item :errors="errors['alias']" label="Алиас">
                            <form-alias v-model="galleryData.alias" :title="galleryData.name"
                                        :in-real-time="false"/>
                        </form-item>
                        <form-item label="Описание" :errors="errors['text']">
                            <el-input v-model="galleryData.text" type="textarea"/>
                        </form-item>
                        <form-item :errors="errors['active']">
                            <el-checkbox v-model="galleryData.active" label="Активно"/>
                        </form-item>
                    </el-form>
                    <el-button type="primary" :loading="loading" @click="save">Сохранить</el-button>
                </div>
                <div class="p-2">
                    <Drawer button="SEO" title="SEO">
                        <template #body>
                            <SeoComponent v-model="galleryData.seo" :errors="errors"></SeoComponent>
                        </template>
                    </Drawer>
                    <el-button type="primary" @click="uploadInput.click()" class="ms-2" :loading="loadImages">
                        Загрузить фото
                    </el-button>
                    <input class="hidden" type="file" ref="upload_input" @change="uploadImagesOnServer" multiple>
                </div>
            </el-card>
        </el-col>
        <el-col :xs="24" :lg="16">
            <draggable v-if="images.length > 0"
                       class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2"
                       v-model="images"
                       group="people"
                       @change="sortImages"
                       handle=".handle"
                       :options="{animation:1300}"
                       item-key="id">
                <template #item="{element, index}">
                    <div class="relative">
                        <img v-if="element.image"
                             :src="element.image ? element.image.preview:'/images/no_image.png'" alt=""
                             class="handle handle w-full rounded-lg shadow-lg object-cover aspect-[16/12]">
                        <div class="absolute top-0 end-0 m-2 rounded-lg">
                            <div class="el-button el-button--small el-button--primary is-plain me-1" @click="changeCover(element)">
                                Сделать обложкой
                            </div>
                            <EditImage :image="element" :index="index" @updateImage="updateImage"
                                       class="me-1"/>
                            <v-modal-delete :url="route('admin.gallery.image.delete', element.id)" :index="index"
                                         @onDelete="deleteImage" icon="DeleteFilled" >
                                <Icon icon="material-symbols:delete-rounded"/>
                            </v-modal-delete>
                        </div>
                        <el-tag type="info" v-if="element.name" class="absolute bottom-2 right-2">
                            {{ element.name }}
                        </el-tag>
                    </div>
                </template>
            </draggable>
            <el-alert v-else type="error" :closable="false">Фотографии отсутствуют</el-alert>
        </el-col>
    </el-row>
</template>

<script>
import MainLayout from "../../../Layouts/MainLayout.vue";
import EditImage from "./EditImage.vue";
import SeoComponent from "../../../components/seo/SeoComponent.vue";
import draggable from "vuedraggable";
import HandleErrorsMixin from "../../../Shared/Mixins/HandleErrorsMixin";
import FormItem from "../../../components/UI/Form/FormItem.vue";
import FormAlias from "../../../components/UI/Form/FormAlias.vue";
import Drawer from "../../../components/UI/Feedback/Drawer.vue";
import {ElMessage, ElNotification} from "element-plus";
import VModalDelete from "../../../components/UI/Feedback/VModalDelete.vue";

export default {
    name: "Edit",
    layout: MainLayout,
    mixins: [HandleErrorsMixin],
    components: {
        VModalDelete,
        Drawer,
        FormAlias,
        FormItem,
        SeoComponent,
        EditImage,
        draggable
    },
    props: {
        gallery: {
            type: Object,
            default: {},
        }
    },
    data() {
        return {
            uploadInput: null,
            errors: [],
            loading: false,
            loadImages: false,
            images: {
                type: Object,
                default: {},
            },
            galleryData: {
                type: Object,
                default: {},
            }
        }
    },
    mounted() {
        this.uploadInput = this.$refs.upload_input
        this.galleryData = this.gallery.data
        this.images = this.gallery.data.images
    },
    methods: {
        sortImages() {
            axios.post(route('admin.gallery.image.sort'), {
                images: this.images
            }).catch((error) => {
                this.handleErrors(error)
                ElMessage.error('Ошибка при сохранении порядка сортировки')
            })
        },
        updateImage(index, image) {
            console.log(index, image);
            this.images[index] = image
        },
        changeCover(image) {
            this.update({
                image_id: image.image.id
            }, route('admin.gallery.updateCover', this.galleryData.id)).then(() => {
                this.galleryData.image = image.image
            })
        },
        save() {
            this.update(this.galleryData, route('admin.gallery.update', this.galleryData.id))
        },
        async update(data, route) {
            this.loading = true
            await axios.patch(route, data).then((response) => {
                this.errors = []
                this.$page.props.seo.title = response.data.data.name
                ElNotification.success({message: 'Данные сохранены', position: 'bottom-right'})
            }).catch((errors) => {
                this.handleErrors(errors)
            }).finally(() => {
                this.loading = false
            })
        },
        uploadImagesOnServer(event) {
            this.loadImages = true
            axios.post(route('admin.gallery.image.upload', this.galleryData.id), {
                images: event.target.files,
            }, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((response) => {
                this.images = response.data.data
                ElNotification.success({message: 'Изображение загружено', position: 'bottom-right'})
            }).catch((error) => {
                this.handleErrors(error)
            }).finally(() => {
                this.loadImages = false
            })
        },
        deleteImage(index) {
            this.images.splice(index, 1)
        },
    }
}
</script>

<style scoped>

</style>
