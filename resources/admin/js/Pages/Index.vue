<template>
    <div class="mb-2 fixed bottom-2 right-6 z-10">
        <Link :href="route('admin.widget')" class="settings-button el-button el-button--primary el-button--large p-2 rounded-lg hover:rounded-3xl duration-500">
            <el-icon :size="18">
                <Icon icon="material-symbols:settings-rounded" />
            </el-icon>
        </Link>
    </div>
    <div class="pb-8">
        <transition name="el-zoom-in-center">
            <draggable class="flex flex-wrap gap-4 my-4"
                       v-model="widgetsData"
                       group="people"
                       @change="sortWidgets"
                       :options="{animation:1300}"
                       handle=".handle"
                       item-key="id">
                <template #item="{element, index}">
                    <el-card
                        class="relative widget dark:outline dark:outline-offset-2 dark:outline-neutral-900 dark:hover:outline-blue-950 duration-500"
                        :class="'widget-size-' + element.size"
                        v-if="element.active" body-class="p-3 h-[95%]">
                        <div class="absolute top-2 right-2">
                            <el-space>
                                <el-dropdown class="hidden xl:block">
                                    <el-button size="small" circle>
                                        <Icon icon="material-symbols:grid-view-outline" />
                                    </el-button>
                                    <template #dropdown>
                                        <el-dropdown-menu>
                                            <el-dropdown-item @click="changeSize(index, 1)">sm</el-dropdown-item>
                                            <el-dropdown-item @click="changeSize(index, 2)">lg</el-dropdown-item>
                                            <el-dropdown-item @click="changeSize(index, 3)">xl</el-dropdown-item>
                                        </el-dropdown-menu>
                                    </template>
                                </el-dropdown>
                                <el-button size="small" class="handle cursor-move" circle>
                                    <Icon icon="ion:move" />
                                </el-button>
                                <el-button type="danger" size="small" @click="deactivate(index)" circle plain>
                                    <Icon icon="material-symbols:close" />
                                </el-button>
                            </el-space>
                        </div>
                        <component :is="element.id" :data="element.data" :size="element.size"/>
                    </el-card>
                </template>
            </draggable>
        </transition>
    </div>

</template>
<script>
import MainLayout from "../Layouts/MainLayout.vue";
import LastNews from "../Widgets/Index/LastNews.vue";
import AboutWidget from "../Widgets/Index/AboutWidget.vue";
import NoteWidget from "../Widgets/Index/NoteWidget.vue";
import FeedbackWidget from "../Widgets/Index/FeedbackWidget.vue";
import throttle from "lodash/throttle";
import draggable from "vuedraggable";
import {ElMessage} from "element-plus";

export default {
    name: "Index",
    layout: MainLayout,
    components: {LastNews, AboutWidget, NoteWidget, FeedbackWidget, draggable},
    props: {
        widgets: Object,
    },
    data() {
        return {
            widgetsData: this.widgets.data,
        }
    },
    methods: {
        sortWidgets() {
            this.update()
        },
        changeSize(index, size) {
            this.widgetsData[index].size = size
            this.update()
        },
        deactivate(index) {
            this.widgetsData[index].active = false
            this.update()
        },
        update: throttle(function () {
            axios.post(route('admin.widget.update'), {
                widgets: this.widgetsData,
            }).catch(() => {
                ElMessage.error('Произошла ошибка при отправке данных')
            })
        }, 500)
    }
}
</script>

<style lang="scss">
.widget {
    h5 {
        margin-block-start: .5em !important;
    }
}
.settings-button:hover {
    transform: scale(1.3);
}
</style>
