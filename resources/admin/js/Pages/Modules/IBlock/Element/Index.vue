<template>
    <div class="flex justify-between mb-3">
        <Link :href="route('admin.iblock.element.create', infoBlock.data.id)" class="el-button el-button--primary">
            Создать
        </Link>
        <EditDescription :iblock="infoBlock.data"></EditDescription>
    </div>
    <el-alert v-if="elementsData.length === 0" type="error" :closable="false">Записи отсутствуют</el-alert>
    <draggable class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-3 mb-3"
               v-model="elementsData"
               group="people"
               @change="sortElements"
               @start="drag=true"
               @end="drag=false"
               handle=".handle"
               :options="{animation:1300}"
               item-key="id">
        <template #item="{element, index}">
            <div
                class="cursor-move flex flex-col items-center bg-white border border-neutral-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-neutral-100 dark:border-neutral-700 dark:bg-neutral-800 dark:hover:bg-neutral-700 draggable handle">
                <img class="object-cover rounded-t-lg h-36 aspect-[4/3] md:rounded-none md:rounded-s-lg"
                     :src="element.image ? element.image.preview:'/images/no_image.png'" alt="">
                <div class="flex flex-col justify-between py-2 px-4 leading-normal">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-neutral-900 dark:text-white !m-0">
                        {{ element.title }}</h5>
                    <p class="mb-3 font-normal text-neutral-700 dark:text-neutral-400">
                        <v-modal-delete :url="route('admin.iblock.element.delete', element.id)" :refresh="true"/>
                        <Link :href="route('admin.iblock.element.edit', element.id)"
                              class="el-button el-button--primary el-button--small">Изменить
                        </Link>
                    </p>
                </div>
            </div>
        </template>
    </draggable>
</template>

<script>
import MainLayout from "../../../../Layouts/MainLayout.vue";
import EditDescription from "../EditDescription.vue";
import draggable from "vuedraggable";
import VModalDelete from "../../../../components/UI/Feedback/VModalDelete.vue";

export default {
    name: "Index",
    layout: MainLayout,
    components: {VModalDelete, EditDescription, draggable},
    props: {
        infoBlock: {
            type: Object,
            required: true,
        },
        elements: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {
            elementsData: [],
        }
    },
    watch: {
        elements(newValue) {
            this.elementsData = newValue.data
        }
    },
    mounted() {
        this.elementsData = this.elements.data
        console.log(this.elementsData);
    },
    methods: {
        sortElements() {
            axios.post(route('admin.iblock.element.sort'), this.elementsData)
        },
    },
}
</script>

<style scoped>
</style>
