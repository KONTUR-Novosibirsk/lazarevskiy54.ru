<template>
    <div class="mb-2">
        <el-input v-model="formFilters.search" :clearable="true" placeholder="Начните ввод" class="w-72"/>
    </div>

    <el-alert type="error" v-if="notes.meta.total === 0" :closable="false">Заметки отсутствуют</el-alert>
    <div v-else class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-3 mb-3">
        <el-card class="col" v-for="note in notes.data">
            {{ note.text }}

            <template #header class="mt-auto">
                <div class="flex justify-between">
                    {{ note.created_at }}
                    <v-modal-delete :url="route('admin.widget.note.delete.refresh', note.id)" :refresh="true"/>
                </div>
            </template>
        </el-card>
    </div>
    <div class="px-4 py-2">
        <v-pagination :meta="notes.meta"/>
    </div>
</template>

<script>
import MainLayout from "../../../../Layouts/MainLayout.vue";
import FilterMixin from "../../../../Shared/Mixins/FilterMixin";
import VPagination from "../../../../components/UI/Data/VPagination.vue";
import VModalDelete from "../../../../components/UI/Feedback/VModalDelete.vue";

export default {
    name: "Index",
    layout: MainLayout,
    components: {VModalDelete, VPagination},
    mixins: [FilterMixin],
    props: {
        notes: null,
    },
    data() {
        return {
            filterUrl: route('admin.widget.note.index'),
            formFilters: {
                search: this.filters.search,
            },
        }
    }
}
</script>
