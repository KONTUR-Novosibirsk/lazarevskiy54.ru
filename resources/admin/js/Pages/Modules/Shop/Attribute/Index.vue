<template>
    <v-grid :data="attributes">
        <template #filter>
            <div class="flex justify-between">
                <div class="">
                    <el-input
                        v-model="formFilters.search"
                        style="max-width: 600px"
                        placeholder="Начните ввод для поиска"
                        class="input-with-select"
                        :clearable="true"
                    >
                        <template #prepend>
                            <el-button><Icon icon="icon-park-outline:search"/></el-button>
                        </template>
                        <template #append>
                            <el-select v-model="formFilters.type" placeholder="Выберите фильтр" style="width: 115px"
                                       :clearable="true">
                                <el-option value="input" label="Строка"/>
                                <el-option value="select" label="Выпадающий список"/>
                                <el-option value="multi_select" label="Множественный выбор"/>
                            </el-select>
                        </template>
                    </el-input>
                </div>

                <FormModal/>
            </div>
        </template>
        <el-table-column prop="name" label="Название" sortable="custom"/>
        <el-table-column prop="type" label="Тип" sortable="custom">
            <template #default="prop">
                {{ types[prop.row.type] }}
            </template>
        </el-table-column>
        <el-table-column label="Управление">
            <template #default="prop">
                <el-space wrap>
                    <FormModal :attribute="prop.row" size="small"/>
                    <v-modal-delete :url="route('admin.shop.attribute.delete', prop.row.id)" :refresh="true"/>
                </el-space>
            </template>
        </el-table-column>
    </v-grid>
</template>

<script>
import MainLayout from "../../../../Layouts/MainLayout.vue";
import FormModal from "./FormModal.vue";
import FilterMixin from "../../../../Shared/Mixins/FilterMixin";
import VGrid from "../../../../components/UI/Data/VGrid.vue";
import VModalDelete from "../../../../components/UI/Feedback/VModalDelete.vue";

export default {
    name: "Index",
    layout: MainLayout,
    components: {VModalDelete, VGrid, FormModal},
    mixins: [FilterMixin],
    props: {
        attributes: {
            type: Object,
            default: {},
        }
    },
    data() {
        return {
            filterUrl: route('admin.shop.attribute.index'),
            formFilters: {
                search: this.filters.search,
                type: this.filters.type
            },
            types: {
                select: 'Выпадающий список',
                input: 'Строка',
                multi_select: 'Множественный выбор',
            }
        }
    }
}
</script>

<style scoped>

</style>
