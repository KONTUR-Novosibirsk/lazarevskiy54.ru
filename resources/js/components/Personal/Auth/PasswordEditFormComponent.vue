<template>
    <h3>Изменение пароля</h3>
    <div>
        <form @submit.prevent="update">
            <div>
                <InputField name="password" type="password" label="Пароль" v-model="form.password" :errors="errors['password']"/>
            </div>
            <div>
                <InputField name="password_confirmation" type="password" label="Подтверждение пароля" v-model="form.password_confirmation" :errors="errors['password']"/>
            </div>
            <button type="submit">Изменить пароль</button>
        </form>
    </div>
    <div class="loader-frame" v-if="loading">
        <div class="loader"></div>
    </div>
</template>

<script>
import InputField from "../../Ui/Form/InputField.vue";
import {ElNotification} from "element-plus";

export default {
    name: "PasswordEditFormComponent",
    components: {InputField},
    data() {
        return {
            completed: false,
            loading: false,
            errors: [],
            form: {
                token: null,
                email: null,
                password: null,
                password_confirmation: null,
            }
        }
    },
    created() {
        const urlParams = new URLSearchParams(window.location.search);
        this.form.token = urlParams.get('token');
        this.form.email = urlParams.get('email');

        if (!this.form.token || !this.form.email) {
            ElNotification({
                title: 'Ошибка',
                message: 'Отсутствует входные параметры',
                type: 'error',
                position: 'bottom-right',
            });
            window.location.href = '/account/password/reset';
        }
    },
    methods: {
        update() {
            this.loading = true
            axios.patch('/account/password/update', this.form).then((response) => {
                this.resetForm()
                this.completed = true
                ElNotification({
                    title: 'Система',
                    message: 'Пароль изменен',
                    type: 'success',
                    position: 'bottom-right',
                })
                window.location.href = '/account/login'
            }).catch((error) => {
                switch (error.response.status) {
                    case 422:
                        this.errors = error.response.data.errors;
                        break;
                    default:
                        ElNotification({
                            title: 'Ошибка',
                            message: 'Произошла неизвестная ошибка',
                            type: 'error',
                            position: 'bottom-right',
                        });
                }
            }).finally(() => {
                this.loading = false
            })
        },

        resetForm() {
            this.form = {
                password: null,
                password_confirmation: null,
            }
            this.errors = []
        },
    }
}
</script>

<style scoped>

</style>
