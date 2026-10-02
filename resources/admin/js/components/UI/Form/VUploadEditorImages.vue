<template>
    <div class="mb-3">
        <label role="button">
            <el-button type="primary" :loading="loading" @click="file.click()">Загрузить</el-button>
            <input class="hidden" ref="file" type="file" @change="upload" multiple>
        </label>
    </div>
    <div class="grid grid-cols-3 gap-3">
        <div v-for="(file, index) in modelValue || []" :key="index"
             class="relative">
            <div class="absolute m-1 top-0 right-0">
                <el-tooltip content="Вставить в редактор" placement="top">
                    <el-button @click="insertImage(file['full'])" size="small"
                               type="primary" circle>
                        <Icon icon="material-symbols:arrows-more-down-rounded"/>
                    </el-button>
                </el-tooltip>
                <el-tooltip content="Удалить" placement="top">
                    <el-button @click="deleteImage(file)" size="small"
                               type="danger" :disabled="disableDeleteButton" circle>
                        <Icon icon="material-symbols:delete-rounded"/>
                    </el-button>
                </el-tooltip>
            </div>
            <img v-bind:src="file['preview']" class="rounded-md max-w-full"
                 style="aspect-ratio: 16/12; object-fit: cover">
        </div>
    </div>
    <el-alert v-if="(modelValue || []).length === 0" type="error" :closable="false">Изображения отсутствуют</el-alert>
</template>

<script>
import {useEditorStore} from "../../../stores/editor";
import {ElMessage} from "element-plus";

export default {
    name: "VUploadEditorImages",
    props: {
        group: {
            type: String,
            default: 'main',
        },
        model_type: {
            type: String,
        },
        model_id: {
            type: Number,
            default: null,
        },
        csrf_token: {
            type: String,
        },
        uploadUrl: null,
        modelValue: {
            type: Array,
            default: {},
        }
    },
    data() {
        return {
            loading: false,
            deleting: false,
            editorStore: useEditorStore(),
            file: null,
        }
    },
    mounted() {
        this.file = this.$refs.file
    },
    computed: {
        url() {
            return this.uploadUrl ?? route('admin.storage.image.upload');
        },
        disableDeleteButton() {
            return this.loading || this.deleting;
        },
    },
    methods: {
        insertImage(url) {
            this.editorStore.insertImage(url)
        },
        deleteImage(image) {
            this.deleting = true;
            axios.delete(route('admin.storage.image.delete', image.id))
                .then((response) => {
                    let newImageData = [...this.modelValue];
                    let index = newImageData.indexOf(image)
                    newImageData.splice(index, 1)
                    this.$emit('update:modelValue', newImageData)
                    ElMessage({
                        message: 'Изображение удалено',
                        grouping: true,
                        type: 'success',
                    })
                }).catch((error) => {
                ElMessage.error('Ошибка удаления изображения')
            }).finally(() => this.deleting = false)
        },
        async upload(event) {
            this.loading = true;
            for (let file in [...event.target.files]) {
                await axios.post(this.url, {
                    imageable_type: this.model_type,
                    imageable_id: this.model_id,
                    image: event.target.files[file],
                    group: this.group,
                }, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then((response) => {
                    ElMessage.success('Изображение загружено')
                    this.$emit('update:modelValue', [...this.modelValue, ...[response.data.data]])
                }).catch((error) => {
                    ElMessage.error('Произошла ошибка')
                });
            }
            this.loading = false;
        }
    },
}
</script>
