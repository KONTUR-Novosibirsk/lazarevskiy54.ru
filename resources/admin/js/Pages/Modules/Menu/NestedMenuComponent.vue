<template>
    <div class="menu_builder">
        <draggable
            class="dragArea list"
            tag="div"
            :list="children"
            :group="{ name: 'menu' }"
            item-key="id"
        >
            <template #item="{ element, index }">
                <div class="ms-1">
                    <el-card body-class="p-2.5" class="mb-1 rounded-none cursor-pointer" shadow="none">
                        <div class="flex justify-between">
                            <div class="my-auto">
                                {{ element.name }}
                                <i class="bi bi-link-45deg" v-if="element['url']"></i>
                            </div>
                            <div class="flex">
                                <div class="el-button el-button--small" v-if="element.branch_class"
                                     :class="{'el-button--primary': element.is_branched}"
                                     title="Имеет возможность ветвление" @click="updateBranch(element, index)">
                                    <i class="bi bi-diagram-3"></i>
                                </div>
                                <menu-link-component v-model="children[index]"
                                                     v-if="element['url']"
                                                     button-name="Изменить ссылку"
                                                     :index="index"
                                                     @update="update"
                                >
                                    <i class="bi bi-link-45deg"></i>
                                </menu-link-component>

                                <v-modal-delete @onDelete="deleteMenuItem"
                                             v-if="element['id']"
                                             :url="'/admin/menu/deleteMenuItem/' + element.id"
                                             :index="index"
                                >
                                    <i class="bi bi-trash-fill"></i>
                                </v-modal-delete>
                            </div>
                        </div>
                    </el-card>
                    <nestedMenuComponent :children="element.children"/>
                </div>
            </template>
        </draggable>
    </div>
</template>
<script>
import draggable from "vuedraggable";
import MenuLinkComponent from "./MenuLinkComponent.vue";
import VModalDelete from "../../../components/UI/Feedback/VModalDelete.vue";
import {ElMessage} from "element-plus";

export default {
    name: "NestedMenuComponent",
    props: {
        children: {
            required: true,
            type: Array
        }
    },
    components: {
        VModalDelete,
        draggable,
        MenuLinkComponent,
    },
    methods: {
        deleteMenuItem(index) {
            this.children.splice(index, 1)
        },
        update(menuItem, index) {
            this.children[index] = menuItem
        },
        updateBranch(menuItem, index) {
            menuItem.is_branched = !menuItem.is_branched
            if (menuItem.is_branched)
                ElMessage.success('Ветвление включено')
            else
                ElMessage.success('Ветвление выключено')
            this.update(menuItem, index)
        },
    },
};
</script>
<style scoped>
.dashed {
    outline: 1px dashed;
    padding: 5px;
}
</style>
