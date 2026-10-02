<template>
    <el-button type="primary" @click="modal = true" v-if="!hide">
        {{ buttonName }}
    </el-button>
    <el-dialog :title="buttonName" v-model="modal">
        <el-form label-position="top">
            <form-item label="Имя" :errors="errors['name']">
                <el-input v-model="questionData.name"/>
            </form-item>
            <form-item label="Вопрос" :errors="errors['question']">
                <v-editor v-model="questionData.question"/>
            </form-item>
            <form-item label="Ответ" :errors="errors['response']">
                <v-editor v-model="questionData.response"/>
            </form-item>
        </el-form>
        <el-button @click="save" type="primary" :loading="loading">Сохранить</el-button>
    </el-dialog>
</template>

<script>
import VEditor from "../../../components/UI/Form/VEditor.vue";
import {router} from "@inertiajs/vue3";
import HandleErrorsMixin from "../../../Shared/Mixins/HandleErrorsMixin";
import FormItem from "../../../components/UI/Form/FormItem.vue";
import {ElNotification} from "element-plus";

export default {
    name: "QuestionForm",
    mixins: [HandleErrorsMixin],
    components: {FormItem, VEditor},
    props: {
        question: null,
        index: null,
        hide: false,
    },
    data() {
        return {
            loading: false,
            modal: false,
            questionData: {
                name: '',
                question: '',
                response: '',
            }
        }
    },
    updated() {
        if (this.question) this.questionData = {...this.question}
    },
    computed: {
        buttonName() {
            return this.question ? 'Изменить' : 'Добавить'
        }
    },
    methods: {
        showModal() {
            this.modal = !this.modal
        },
        save() {
            this.loading = true
            this.errors = []
            if (this.question) {
                this.update()
            } else {
                this.store()
            }
        },
        update() {
            axios.patch(route('admin.question.update', this.questionData.id), this.questionData).then((response) => {
                ElNotification.success({message: 'Отзыв обновлен', position: 'bottom-right'})
                this.modal = false
                this.questionData = response.data.data
                this.$emit('update', {...this.questionData}, this.index)
            }).catch((error) => {
                this.handleErrors(error)
            }).finally(() => {
                this.loading = false

            })
        },
        store() {
            axios.post(route('admin.question.store'), this.questionData).then((response) => {
                ElNotification.success({message: 'Отзыв добавлен', position: 'bottom-right'})
                this.modal = false
                router.get(route('admin.question.index'))
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

</style>
