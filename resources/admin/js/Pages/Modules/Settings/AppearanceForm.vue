<script>
import HandleErrorsMixin from "../../../Shared/Mixins/HandleErrorsMixin";
import FormItem from "../../../components/UI/Form/FormItem.vue";
import FormFile from "../../../components/UI/Form/FormFile.vue";
import {ElNotification} from "element-plus";

export default {
    name: "AppearanceForm",
    components: {FormFile, FormItem},
    mixins: [HandleErrorsMixin],
    data() {
        return {
            loading: false,
            form: {
                favicon: '/' + this.settings('favicon', 'default-favicon.ico'),
            }
        }
    },
    methods: {
        save() {
            this.loading = true
            this.errors = []
            axios.post(route('admin.settings.appearance'), this.form, {
                headers: {
                    "Content-Type": "multipart/form-data",
                }
            }).then((response) => {
                ElNotification({
                    type: 'success',
                    title: 'Система',
                    message: 'Данные сохранены',
                    position: 'bottom-right',
                })
            }).catch((error) => {
                this.handleErrors(error)
            }).finally(() => {
                this.loading = false
            })
        }
    }
}
</script>

<template>
    <el-form label-position="top">
        <form-item label="Фавикон" :errors="errors['favicon']">
            <form-file v-model="form.favicon"></form-file>
        </form-item>
        <el-button type="primary" :loading="loading" @click="save">Сохранить</el-button>
    </el-form>
</template>
