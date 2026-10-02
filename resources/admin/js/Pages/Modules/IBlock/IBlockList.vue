<template>
    <v-grid :data="infoBlocks" :pagination="false">
        <el-table-column prop="id" label="#" width="60"/>
        <el-table-column prop="title" label="Название">
            <template #default="prop">
                <Link class="el-link el-link--default is-underline"
                      :href="route('admin.iblock.element.index', prop.row.id)">
                    {{ prop.row.title }}
                </Link>
            </template>
        </el-table-column>
        <el-table-column label="Управление">
            <template #default="prop">
                <el-space wrap>
                    <Edit button-name="Изменить" size="small" :index="prop.$index" :i-block="prop.row"
                          :categories="categories"></Edit>
                    <v-modal-delete @onDelete="deleteInfoBlock" :index="prop.$index"
                                    :url="'/admin/iblock/delete/' + prop.row.id">Удалить
                    </v-modal-delete>
                </el-space>
            </template>
        </el-table-column>
    </v-grid>
</template>

<script>
import Edit from "./Edit.vue";
import VModalDelete from "../../../components/UI/Feedback/VModalDelete.vue";
import {useIBlockStore} from "../../../stores/iblock";
import VGrid from "../../../components/UI/Data/VGrid.vue";

export default {
    name: "IBlockList",
    components: {VGrid, Edit, VModalDelete},
    props: {
        categories: Array,
        infoBlocks: {
            type: Object,
            default: {},
        }
    },
    data() {
        return {
            iBlocks: useIBlockStore(),
        }
    },
    mounted() {
        this.iBlocks.setIBlocks(this.infoBlocks.data)
    },
    methods: {
        deleteInfoBlock(index) {
            this.iBlocks.delete(index)
        }
    }
}
</script>

<style scoped>

</style>
