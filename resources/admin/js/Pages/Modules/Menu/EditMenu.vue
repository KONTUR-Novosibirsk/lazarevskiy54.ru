<template>
    <el-row :gutter="20">
        <el-col :xs="24" :lg="12">
            <el-card body-class="p-3" class="mb-1" shadow="none">
                <div class="ms-2 flex justify-between">
                    <div class="my-auto">
                        Меню
                    </div>
                    <div class="my-auto">
                        <menu-link-component :category="category"
                                             button-name="Добавить ссылку"
                                             @add="addLink"
                        ></menu-link-component>
                        <el-button type="primary" size="small" @click="save" :loading="loading">
                            Сохранить меню
                        </el-button>
                    </div>
                </div>
            </el-card>
            <nestedMenuComponent
                :children="menuItems" :class="{'dashed':menuItems.length == 0}"
                group="menu"/>

        </el-col>
        <el-col :xs="24" :lg="12">
            <template v-for="(list, index) in templateList">
                <div class="mb-4" v-if="templateList[index].items.length > 0">
                    <el-card class="mb-1" body-class="p-4" shadow="none">
                        {{ list.name }}
                    </el-card>
                    <draggable
                        :list="templateList[index].items"
                        class="list"
                        :group="{ name: 'menu'}"
                        item-key="id">
                        <template #item="{element}">
                            <el-card class="mb-1 ms-1 rounded-none cursor-pointer" body-class="p-2" shadow="none">
                                <div class="flex justify-between">
                                    {{ element.name }}
                                    <i class="bi bi-diagram-3" title="Имеет ветвление" v-if="element.branch_class"></i>
                                </div>
                            </el-card>
                        </template>
                    </draggable>
                </div>
            </template>
        </el-col>
    </el-row>
</template>

<script>
import draggable from "vuedraggable";
import nestedMenuComponent from "./NestedMenuComponent.vue";
import MenuLinkComponent from "./MenuLinkComponent.vue";
import MainLayout from "../../../Layouts/MainLayout.vue";
import HandleErrorsMixin from "../../../Shared/Mixins/HandleErrorsMixin";
import {ElNotification} from "element-plus";

export default {
    name: "EditMenu",
    mixins: [HandleErrorsMixin],
    layout: MainLayout,
    components: {
        MenuLinkComponent,
        draggable,
        nestedMenuComponent
    },
    props: {
        category: null,
        templateItems: {
            type: Object,
            default: {},
        },
        nestedItems: {
            type: Object,
            default: {},
        },
    },
    data() {
        return {
            loading: false,
            templateList: [],
            menuItems: [],
        }
    },
    mounted() {
        this.menuItems = this.nestedItems.data
        this.templateList = this.templateItems.data
    },
    methods: {
        addLink(item) {
            this.menuItems.push(item)
        },
        save() {
            this.loading = true
            axios.patch('/admin/menu/updateMenuItems/' + this.category.id, {
                menuItems: this.menuItems,
            }).then((response) => {
                this.menuItems = response.data.data
                ElNotification.success({message: 'Меню сохранено', position: 'bottom-right'})
            }).catch((error) => {
                this.handleErrors(error)
            }).finally(() => {
                this.loading = false
            })
        }
    }
}
</script>

<style scoped>
.dashed {
    border: 1px dashed #1a202c;
    padding: 20px;
    margin: 0.2rem 0.1rem 0.2rem .6rem;
}
</style>
