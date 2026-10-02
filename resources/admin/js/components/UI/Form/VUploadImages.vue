<template>
    <div v-loading="loading">
        <draggable class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2"
                   :list="modelValue ?? []"
                   group="people"
                   @change="sortImages"
                   handle=".handle"
                   :options="{animation:1300}"
                   item-key="id" ref="draggable">
            <template #item="{element, index}">
                <div class="draggable relative">
                    <div class="absolute top-0 end-0 m-2 rounded-lg">
                        <el-space>
                            <v-edit-image :image="element" @update="changeImage" :circle="true"/>
                            <el-button type="danger" size="small" @click="deleteImage(element)"
                                       :disabled="disableDeleteButton" circle>
                                <Icon icon="material-symbols:delete-rounded" />
                            </el-button>
                        </el-space>
                    </div>
                    <img v-bind:src="element['preview']" class="handle w-full rounded-lg shadow-lg"
                         style="aspect-ratio: 16/12; object-fit: cover">
                </div>
            </template>
            <template #header>
                <div class="">
                    <div
                        class="border-dashed border-4 border-neutral-700 rounded-lg relative duration-500 hover:border-blue-600"
                        :class="{'opacity-70 border-blue-600': dragAndDrop}"
                        @drop.stop.prevent="drop"
                        @dragover.stop.prevent="dragover"
                        @dragleave.stop.prevent="dragleave"
                        @click="inputFile.click()"
                        style="aspect-ratio: 16/12; object-fit: cover">
                        <div class="flex stretched-link w-100 h-full cursor-pointer">
                            <div class="m-auto flex flex-col opacity-80">
                                <el-icon :size="30" class="m-auto">
                                    <Icon icon="material-symbols:cloud-upload"/>
                                </el-icon>
                                <div class="text-xs text-center">
                                    Нажмите или перетащите файлы для загрузки
                                </div>
                            </div>
                        </div>
                        <input class="hidden" type="file" @change="upload" ref="inputFile" multiple>
                    </div>
                </div>
            </template>
        </draggable>

    </div>
</template>

<script>
import draggable from "vuedraggable";
import {ElMessage} from "element-plus";
import VEditImage from "../Other/VEditImage.vue";

export default {
    name: "VUploadImages",
    components: {VEditImage, draggable},
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
            draggable: null,
            inputFile: null,
            dragAndDrop: false,
        }
    },
    mounted() {
        this.inputFile = this.$refs.inputFile;
        this.draggable = this.$refs.draggable;
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
        dragover() {
            this.dragAndDrop = true;
        },
        dragleave() {
            this.dragAndDrop = false;
        },
        drop(event) {
            this.uploadFiles(event.dataTransfer.files);
            this.dragAndDrop = false;
        },
        sortImages(data) {
            this.$emit('update:modelValue', [...this.draggable.list])
            axios.post(route('admin.storage.images.sort'), {
                images: this.draggable.list,
            }).catch((error) => {
                ElMessage.error('Не удалось выполнить сортировку')
            })
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
        upload(event) {
            this.uploadFiles(event.target.files);
        },
        async uploadFiles(files) {
            this.loading = true;
            for (let file in [...files]) {
                await axios.post(this.url, {
                    imageable_type: this.model_type,
                    imageable_id: this.model_id,
                    image: files[file],
                    group: this.group,
                }, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then((response) => {
                    ElMessage.success({message: 'Изображение загружено', grouping: true})
                    this.$emit('update:modelValue', [...this.modelValue, ...[response.data.data]])
                }).catch((error) => {
                    ElMessage.error('Произошла ошибка')
                });
            }
            this.loading = false;
        },
        changeImage(image) {
            const newDataImages = this.modelValue;
            const imageIndex = newDataImages.findIndex(f => f.id == image.id);
            newDataImages[imageIndex] = image;
            this.$emit('update:modelValue', newDataImages);
        }
    },
}
</script>

<style scoped>
.handle {
    cursor: move;
}
</style>
