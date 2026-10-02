<template>
    <div class="feedback-popup__heading">
        Регистрация
    </div>
    <div class="feedback-popup__content auth-form">
        <form @submit.prevent="store">
            <div class="feedback-popup__item">
                <InputField name="login" type="login" label="login" v-model="form.login" :errors="errors['login']"/>
            </div>
            <div class="feedback-popup__item">
                <InputField name="full_name" type="full_name" label="ФИО" v-model="form.full_name" :errors="errors['full_name']"/>
            </div>
            <div class="feedback-popup__item">
                <InputField name="email" type="email" label="E-mail" v-model="form.email" :errors="errors['email']"/>
            </div>
            <div class="feedback-popup__item">
                <InputField name="password" type="password" label="Пароль" v-model="form.password" :errors="errors['password']"/>
            </div>
            <div class="feedback-popup__item">
                <InputField name="password_confirmation" type="password" label="Подтверждение пароля" v-model="form.password_confirmation" :errors="errors['password_confirmation']"/>
            </div>
            <div class="feedback-popup__privacy" v-if="privacyPolicyLink">
                <CheckboxUi :label="privacyLabel" name="feedback" v-model="form.policy" :errors="errors['policy']"/>
            </div>
            <button type="submit" class="feedback-btn">Зарегистрироваться</button>
            <button type="button" class="outline-btn" @click="isModal ? $emit('changeType', 'login') : navigateTo('/account/login')">Уже есть аккаунт? Войти</button>
            <button type="button" class="outline-btn" @click="isModal ? $emit('changeType', 'password_reset') : navigateTo('/account/password/reset')">Забыли пароль?</button>
        </form>
    </div>
    <div class="loader-frame" v-if="loading">
        <div class="loader"></div>
    </div>
</template>

<script>
import InputField from "../../Ui/Form/InputField.vue";
import CheckboxUi from "@/components/Ui/Form/CheckboxUi.vue";

export default {
    name: "RegisterFormComponent",
    components: {InputField, CheckboxUi},
    emits: ['changeType'],
    props: {
        privacyPolicyLink: null,
        isModal: {
            type: Boolean,
            default: true,
        },
    },
    data() {
        return {
            loading: false,
            errors: [],
            form: {
                email: null,
                password: null,
                policy: false,
            }
        }
    },
    methods: {
        navigateTo(url) {
            window.location.href = url;
        },
        store() {
            this.loading = true
            axios.post('/account/store', this.form).then((response) => {
                window.location.href = '/account/me';
            }).catch((error) => {
                if (error.response['status'] === 422) {
                    this.errors = error.response.data.errors
                }
            }).finally(() => {
                this.loading = false
            })
        }
    },
    computed: {
        privacyLabel() {
            return `Я согласен на <a href="${this.privacyPolicyLink}">обработку персональных данных</a>`;
        },
    }
}
</script>

<style scoped>

</style>
