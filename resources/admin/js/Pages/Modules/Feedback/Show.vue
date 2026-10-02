<template>
    <v-grid :data="feedbackData" v-loading="loading" @selectionChange="handleSelectionChange">
        <el-table-column type="selection" width="40"/>
        <el-table-column prop="id" label="#" width="70"/>
        <el-table-column prop="data" label="Подробности">
            <template #default="prop">
                <el-table-column v-for="(formItem, index) in config.form" v-if="index !== 'policy'" :label="formItem.label">
                    <template #default="prop">
                        {{ prop.row.data[index] }}
                    </template>
                </el-table-column>
            </template>
        </el-table-column>
        <el-table-column prop="created_at" label="Дата" width="200"/>
        <el-table-column label="Управление">
            <template #default="prop">
                <el-button @click="changeStatus(prop.row, prop.$index)"
                           :type="prop.row.status == 1 ? 'success':'danger'" size="small">
                    {{ prop.row.status == 1 ? 'Обработано' : 'Не обработано' }}
                </el-button>
                <v-modal-delete :url="route('admin.feedback.delete', prop.row.id)" :refresh="true"/>
            </template>
        </el-table-column>
        <template #append>
            <div class="p-3" v-show="!!selected">
                <el-button type="danger" size="small" @click="massDelete">Удалить отмеченные</el-button>
            </div>
        </template>
    </v-grid>
</template>

<script>
import MainLayout from "../../../Layouts/MainLayout.vue";
import VGrid from "../../../components/UI/Data/VGrid.vue";
import {ElMessage} from "element-plus";
import {router} from "@inertiajs/vue3";
import VModalDelete from "../../../components/UI/Feedback/VModalDelete.vue";

export default {
    name: "Show",
    layout: MainLayout,
    components: {VModalDelete, VGrid},
    props: {
        feedback: null,
        config: null,
    },
    data() {
        return {
            feedbackData: this.feedback,
            loading: false,
            selected: null,
        }
    },
    updated() {
        this.feedbackData = this.feedback
    },
    methods: {
        changeStatus(feedback, index) {
            this.loading = true
            axios.patch(route('admin.feedback.changeStatus', feedback.id)).then((response) => {
                this.feedbackData.data[index] = response.data
            }).catch(() => {
                ElMessage.error('Ошибка при изменении статуса')
            }).finally(() => {
                this.loading = false
            })
        },
        handleSelectionChange(data) {
            this.selected = data.length > 0 ? data : null
        },
        massDelete() {
            this.loading = true
            axios.delete(route('admin.feedback.massDelete', {
                items: this.selected
            })).then((response) => {
                ElMessage.error('Количество удаленных записей: ' + response.data.delete_count)
                router.reload({only: ['feedback']})
            }).catch(() => {
                ElMessage.error('Ошибка при удалении')
            }).finally(() => {
                this.loading = false
            })
        }
    }
}
</script>

<style scoped>

</style>
