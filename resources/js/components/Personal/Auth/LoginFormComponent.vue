<template>
    <div class="feedback-popup__heading">
        Вход
    </div>
    <div class="feedback-popup__content auth-form">
        <form @submit.prevent="store">
            <div class="feedback-popup__item">
                <InputField name="login" type="login" label="login" v-model="form.login" :errors="errors['login']"/>
            </div>
            <div class="feedback-popup__item">
                <InputField name="password" type="password" label="Пароль" v-model="form.password" :errors="errors['password']"/>
            </div>
            <div class="feedback-popup__privacy" v-if="privacyPolicyLink">
                <CheckboxUi :label="privacyLabel" name="feedback" v-model="form.policy" :errors="errors['policy']"/>
            </div>
            <div v-if="errors['general']" class="invalid-feedback mb-[10px]">
                {{ errors['general'][0] }}
            </div>
            {{isModal}}
            <button type="submit" class="feedback-btn">Войти</button>
            <button type="button" class="outline-btn" @click="isModal ? $emit('changeType', 'register') : navigateTo('/account/register')">Регистрация</button>
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
    name: "LoginFormComponent",
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
            axios.post('/account/authenticate', this.form).then((response) => {
                window.location.href = '/account/me';
            }).catch((error) => {
                if (error.response['status'] === 422 || error.response['status'] === 401) {
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
