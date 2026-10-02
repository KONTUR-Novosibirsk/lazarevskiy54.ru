<template>
    <el-button @click="modal = true" v-if="!hide" type="primary">
        {{ buttonName }}
    </el-button>
    <el-dialog v-model="modal" :title="buttonName" :append-to-body="true">
        <el-form label-position="top">
            <form-item label="Имя" :errors="errors['name']">
                <el-input v-model="reviewData.name"/>
            </form-item>
            <form-item label="Должность/Профессия" :errors="errors['job_title']">
                <el-input v-model="reviewData.job_title"/>
            </form-item>
            <form-item label="Отзыв" :errors="errors['text']">
                <v-editor v-model="reviewData.text"/>
            </form-item>
        </el-form>
        <el-button @click="save" type="primary" :loading="loading">
            Сохранить
        </el-button>
    </el-dialog>
</template>

<script>
import VEditor from "../../../components/UI/Form/VEditor.vue";
import {router} from "@inertiajs/vue3";
import HandleErrorsMixin from "../../../Shared/Mixins/HandleErrorsMixin";
import FormItem from "../../../components/UI/Form/FormItem.vue";
import {ElNotification} from "element-plus";

export default {
    name: "ReviewForm",
    components: {FormItem, VEditor},
    mixins: [HandleErrorsMixin],
    props: {
        review: null,
        index: null,
        hide: false,
    },
    data() {
        return {
            loading: false,
            modal: false,
            reviewData: {
                name: '',
                job_title: '',
                text: '',
            }
        }
    },
    updated() {
        if (this.review) this.reviewData = {...this.review}
    },
    computed: {
        buttonName() {
            return this.hide ? null : 'Добавить'
        }
    },
    methods: {
        showModal() {
            this.modal = !this.modal
        },
        save() {
            this.loading = true
            this.errors = []
            if (this.review) {
                this.update()
            } else {
                this.store()
            }
        },
        update() {
            axios.patch(route('admin.review.update', this.reviewData.id), this.reviewData).then((response) => {
                ElNotification.success({message: 'Отзыв обновлен', position: 'bottom-right'})
                this.reviewData = response.data.data
                this.$emit('updateReview', {...this.reviewData}, this.index)
                this.modal = false
            }).catch((error) => {
                this.handleErrors(error)
            }).finally(() => {
                this.loading = false

            })
        },
        store() {
            axios.post(route('admin.review.store'), this.reviewData).then((response) => {
                ElNotification.success({message: 'Отзыв добавлен', position: 'bottom-right'})
                this.modal = false
                router.get(route('admin.review.index'))
            }).catch((error) => {
                this.handleErrors(error)
            }).finally(() => {
                this.loading = false
            })
        }
    }
}
</script>
