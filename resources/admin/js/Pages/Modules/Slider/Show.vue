<template>
    <Link :href="route('admin.slide.create', slider.data.id)" class="el-button el-button--primary mb-3">Добавить
    </Link>
    <el-alert v-if="slides.data.length === 0" type="error" :closable="false" class="p-3">Слайды отсутствуют
    </el-alert>
    <draggable v-else class="grid grid-cols-1 lg:grid-cols-4 xl:grid-cols-5 gap-4"
               v-model="slidesData"
               @change="sortSlides"
               :options="{animation:1300}"
               item-key="id">
        <template #item="{element, index}">
            <el-card :header="element.title" class="handle" body-class="p-0 relative">
                <img v-if="element.image" :src="element.image.preview" alt="" class="object-cover h-48 w-full">
                <img v-else src="/images/no_image.png" alt="" class="object-cover h-48 w-full">
                <div class="py-3">
                    <span class="px-2">Сортировка:</span>
                    <el-input-number
                        v-model="element.sort"
                        @change="updateSlideSort(element)"
                        size="small"
                        class="mr-2"
                    />
                </div>
                <div class="absolute top-2 right-2">
                    <Link :href="route('admin.slide.edit', element.id)"
                          class="el-button el-button--primary el-button--small">
                        Изменить
                    </Link>
                    <v-modal-delete :url="route('admin.slide.delete', element.id)" :refresh="true"/>
                </div>
            </el-card>
        </template>
    </draggable>
</template>

<script>
import MainLayout from "../../../Layouts/MainLayout.vue";
import draggable from "vuedraggable";
import VModalDelete from "../../../components/UI/Feedback/VModalDelete.vue";
import {ElNotification} from "element-plus";

export default {
    name: "Show",
    layout: MainLayout,
    components: {VModalDelete, draggable},
    props: {
        slider: null,
        slides: null,
    },
    data() {
        return {
            slidesData: this.slides.data
        }
    },
    methods: {
        sortSlides() {
            axios.patch(route('admin.slide.sort'), this.slidesData)
        },
        updateSlideSort(slide) {
            axios.post(route('admin.slide.updateSort', slide.id), {
                sort: slide.sort
            }).then(() => {
                this.slidesData.sort((a, b) => a.sort - b.sort);
                ElNotification.success({ message: 'Сортировка обновлена', position: 'bottom-right' });
            }).catch(() => {
                ElNotification.error({ message: 'Ошибка при обновлении сортировки', position: 'bottom-right' });
            });
        }
    }
}
</script>

<style scoped>

</style>
