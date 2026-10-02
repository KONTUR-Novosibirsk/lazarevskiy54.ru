<template>
    <v-grid :data="questionsData">
        <template #filter>
            <div class="flex justify-between">
                <div class="w-80">
                    <el-select v-model="formFilters.status" :clearable="true" placeholder="Статус">
                        <el-option value="2" label="Требуют ответа"/>
                        <el-option value="1" label="Опубликованные"/>
                        <el-option value="0" label="На модерации"/>
                    </el-select>
                </div>
                <QuestionForm class="mb-2"/>
                <QuestionForm :index="questionForEditIndex"
                              :question="questionForEdit"
                              :hide="true" @update="updateQuestion"
                              ref="modal"
                />
            </div>
        </template>
        <el-table-column prop="id" label="#" width="60" sortable="custom"/>
        <el-table-column prop="name" label="Имя" sortable="custom"/>
        <el-table-column prop="created_at" label="Дата" sortable="custom"/>
        <el-table-column prop="status" label="Статус" sortable="custom">
            <template #default="prop">
                <el-tag type="warning" v-if="!prop.row.response">Требуется ответ</el-tag>
                <el-tag type="success" v-else-if="prop.row.status == 1">Одобрено</el-tag>
                <el-tag type="danger" v-else>На модерации</el-tag>
            </template>
        </el-table-column>
        <el-table-column label="Управление">
            <template #default="prop">
                <el-space wrap>
                    <el-button type="primary" size="small" @click="moderate(prop.$index, prop.row)"
                               :loading="prop.$index == moderateIndex">
                        Изменить статус
                    </el-button>
                    <el-button type="primary" size="small" @click="setQuestionForEdit(prop.row, prop.$index)">
                        Изменить
                    </el-button>
                    <v-modal-delete :url="route('admin.question.delete', prop.row.id)" :refresh="true"/>
                </el-space>
            </template>
        </el-table-column>
    </v-grid>
</template>

<script>
import MainLayout from "../../../Layouts/MainLayout.vue";
import FilterMixin from "../../../Shared/Mixins/FilterMixin";
import QuestionForm from "./QuestionForm.vue";
import VGrid from "../../../components/UI/Data/VGrid.vue";
import {ElMessage} from "element-plus";
import HandleErrorsMixin from "../../../Shared/Mixins/HandleErrorsMixin";
import VModalDelete from "../../../components/UI/Feedback/VModalDelete.vue";

export default {
    name: "Index",
    layout: MainLayout,
    mixins: [FilterMixin, HandleErrorsMixin],
    props: {
        questions: null,
    },
    components: {VModalDelete, VGrid, QuestionForm},
    data() {
        return {
            formModal: null,
            questionForEdit: null,
            questionForEditIndex: null,
            questionsData: this.questions,
            moderateIndex: null,
            filterUrl: route('admin.question.index'),
            formFilters: {
                status: this.filters.status
            },
        }
    },
    mounted() {
        this.formModal = this.$refs.modal
    },
    updated() {
        this.questionsData = this.questions
    },
    methods: {
        setQuestionForEdit(question, index) {
            this.questionForEditIndex = index
            this.questionForEdit = question
            this.formModal.showModal()
        },
        updateQuestion(question, index) {
            this.questionsData.data[index] = question
            this.questionForEditIndex = null
            this.questionForEdit = null
        },
        moderate(index, question) {
            if (!question.response) {
                ElMessage.error('Для публикации требуется ответ')
                return
            }
            this.moderateIndex = index
            axios.patch(route('admin.question.status.change', question.id)).then((response) => {
                this.questionsData.data[index] = response.data.data
            }).catch((error) => {
                this.handleErrors(error)
            }).finally(() => {
                this.moderateIndex = null
            })
        },
    }
}
</script>

<style scoped>

</style>
