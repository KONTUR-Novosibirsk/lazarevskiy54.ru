<template>
    <div class="relative" v-loading="loading">
        <img :src="getPreview" alt="" class="max-w-full preview">
        <div class="flex absolute top-0 start-0 m-1 rounded rounded-2">
            <el-space>
                <v-edit-image v-if="modelValue" :image="modelValue" @update="changeImage"
                              :circle="false" button-text="Изменить"/>
                <el-button :loading="loading" size="small" type="primary" @click="file.click()">
                    <Icon icon="material-symbols:cloud-upload" class="me-1"/>
                    Загрузить
                </el-button>
                <el-button v-if="modelValue" size="small" :loading="loading" type="danger" @click="deleteImage">
                    <Icon icon="material-symbols:delete-rounded" class="me-1"/>
                    Удалить
                </el-button>
            </el-space>
            <input @change="uploadPreview" type="file" class="hidden" ref="file">
        </div>
    </div>
</template>
<script>
import {ElMessage} from "element-plus";
import VEditImage from "../Other/VEditImage.vue";

export default {
    name: "VUploadImage",
    components: {VEditImage},
    props: {
        uploadUrl: String,
        modelValue: null,
        group: {
            type: String,
            default: 'main',
        },
        model_type: null,
        model_id: null,
        prefix: null
    },
    data() {
        return {
            loading: false,
            file: null,
        }
    },
    mounted() {
        this.image = this.preview
        this.file = this.$refs.file
    },
    computed: {
        getPreview() {
            return this.modelValue ? this.modelValue.preview : '/images/no_image.png'
        },
        url() {
            return this.uploadUrl ?? route('admin.storage.image.upload');
        },
    },
    methods: {
        uploadPreview(event) {
            this.loading = true
            axios.post(this.url, {
                imageable_type: this.model_type,
                imageable_id: this.model_id,
                group: this.group,
                image: event.target.files[0],
                prefix: this.prefix
            }, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((response) => {
                ElMessage.success('Изображение загружено')
                this.$emit('update:modelValue', response.data.data);
            }).catch((error) => {
                ElMessage.error('Произошла ошибка')
            }).finally(() => {
                    this.file.value = null;
                    this.loading = false;
                }
            )
        },
        changeImage(image) {
            this.$emit('update:modelValue', image);
        },
        deleteImage() {
            axios.delete(route('admin.storage.image.delete', this.modelValue.id)).then(() => {
                this.$emit('update:modelValue', null);
            }).catch(() => {
                ElMessage.error('Произошла ошибка при удалении')
            })
        }
    }
}
</script>

<style scoped>
.preview {
    aspect-ratio: 10/7;
    object-fit: cover;
}
</style>
