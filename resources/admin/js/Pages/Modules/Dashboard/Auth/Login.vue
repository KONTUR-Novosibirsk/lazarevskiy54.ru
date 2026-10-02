<template>
    <div class="flex h-screen">
        <div class="m-auto">
            <div class="">
                <el-card style="width: 350px;" v-loading="loading">
                    <template #header>
                        <div class="flex justify-between">
                            <div class="my-auto">
                                Вход
                            </div>
                            <ThemeSwitcher class="p-2 bg-gray-200 dark:bg-neutral-700 rounded-full cursor-pointer"></ThemeSwitcher>
                        </div>
                    </template>
                    <el-form label-position="top">
                        <form-item label="Имя пользователя" :errors="errors['username']">
                            <el-input v-model="username"/>
                        </form-item>
                        <form-item label="Пароль" :errors="errors['password']">
                            <el-input v-model="password" type="password"/>
                        </form-item>
                        <div class="flex mb-3">
                            <el-switch v-model="remember" type="password" class="my-auto"/>
                            <div class="ms-2 my-auto">
                                Запомнить меня
                            </div>
                        </div>
                        <el-button type="primary" @click="login">Вход</el-button>
                    </el-form>
                </el-card>
            </div>
        </div>
    </div>
</template>

<script>
import {router} from '@inertiajs/vue3'
import FormItem from "../../../../components/UI/Form/FormItem.vue";
import {ElMessage} from "element-plus";
import HandleErrorsMixin from "../../../../Shared/Mixins/HandleErrorsMixin";
import LoginLayout from "../../../../Layouts/LoginLayout.vue";
import ThemeSwitcher from "../../../../components/ThemeSwitcher.vue";

export default {
    name: "Login",
    layout: LoginLayout,
    components: {ThemeSwitcher, FormItem},
    mixins: [HandleErrorsMixin],
    data() {
        return {
            loading: false,
            errors: {
                type: Array,
                default: [],
            },
            username: '',
            password: '',
            remember: false,
        }
    },
    methods: {
        login() {
            this.loading = true
            this.errors = []
            axios.post(route('admin.auth'), {
                username: this.username,
                password: this.password,
                remember: this.remember,
            }).then((response) => {
                if (response.data === false) {
                    ElMessage.error('Не удалось выполнить вход')
                } else {
                    router.visit(route('admin.index'))
                }
            }).catch((errors) => {
                this.handleErrors(errors)
            }).finally(() => {
                this.loading = false
            })
        }
    }
}
</script>

<style scoped>

</style>
