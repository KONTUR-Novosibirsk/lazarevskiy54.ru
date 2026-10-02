<script setup>
import {ref} from "vue";
import {Cropper} from "vue-advanced-cropper";
import "vue-advanced-cropper/dist/style.css";
import {ElMessage} from "element-plus";

const emit = defineEmits(['update'])
const props = defineProps({
    image: Object,
    circle: Boolean,
    buttonText: String,
})

const modal = ref(false);
const loading = ref(false);
const coordinates = ref(null);
const cropperRef = ref(null)

const changeHandler = event => {
    coordinates.value = event.coordinates;
}

const crop = () => {
    loading.value = true;
    axios.post(route('admin.storage.image.crop', props.image.id), coordinates.value).then((response) => {
        emit('update', response.data.data)
        ElMessage.success('Размеры изображения изменены')
    }).catch((error) => {
        ElMessage.error('Произошла ошибка при изменении размеров изображения')
    }).finally(() => {
        loading.value = false;
    })
}
</script>

<template>
    <el-button type="primary" @click="modal = true" size="small" :circle="circle">
        <template #default>
            <Icon icon="material-symbols:resize" :class="{'me-1':buttonText}" />
            {{ buttonText }}
        </template>
    </el-button>
    <el-dialog v-model="modal" title="Изменить изображение" :append-to-body="true">
        <div v-loading="loading" class="relative">
            <cropper v-if="image && modal" class="cropper max-w-full"
                     :src="image.full"
                     ref="cropperRef"
                     @change="changeHandler"
            />
            <div class="top-0 left-0 bg-neutral-950 p-2 opacity-90 absolute" v-if="coordinates">
                <div>Width: {{ coordinates.width }}</div>
                <div>Height: {{ coordinates.height }}</div>
            </div>
        </div>
        <template #footer>
            <el-button @click="crop" type="primary" :loading="loading">Обрезать</el-button>
        </template>
    </el-dialog>
</template>

<style scoped>
.cropper {
    min-height: 300px;
    max-height: 500px;
    width: 100%;
}
</style>
