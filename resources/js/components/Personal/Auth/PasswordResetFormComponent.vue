<template>
    <div class="feedback-popup__heading">Сброс пароля</div>
    <div v-if="completed" class="w-fit mb-[20px]">
        Ссылка для сброса пароля была отправлена на вашу почту, если аккаунт с таким email существует.
    </div>
    <div class="feedback-popup__content auth-form">
        <form @submit.prevent="sendResetLink">
            <div class="feedback-popup__item">
                <InputField name="email" type="email" label="E-mail" v-model="form.email" :errors="errors['email']"/>
            </div>
            <div class="feedback-popup__privacy" v-if="privacyPolicyLink">
                <CheckboxUi :label="privacyLabel" name="feedback" v-model="form.policy" :errors="errors['policy']"/>
            </div>
            <button class="feedback-btn" type="submit">Сбросить пароль</button>
            <button type="button" class="outline-btn" @click="isModal ? $emit('changeType', 'login') :  navigateTo('/account/login')">Вернуться к входу</button>
            <button type="button" class="outline-btn" @click="isModal ? $emit('changeType', 'register') : navigateTo('/account/register')">Регистрация</button>
        </form>
    </div>
    <div class="loader-frame" v-if="loading">
        <div class="loader"></div>
    </div>
</template>

<script>
import InputField from "../../Ui/Form/InputField.vue";
import {ElNotification} from "element-plus";
import CheckboxUi from "@/components/Ui/Form/CheckboxUi.vue";

export default {
    name: "PasswordResetFormComponent",
    components: {InputField, CheckboxUi},
    emits: ['changeType'],
    props: {
        isModal: {
            type: Boolean,
            default: true,
        },
        privacyPolicyLink: null,
    },
    data() {
        return {
            completed: false,
            loading: false,
            errors: [],
            form: {
                email: null,
                policy: false,
            }
        }
    },
    computed: {
        privacyLabel() {
            return `Я согласен на <a href="${this.privacyPolicyLink}">обработку персональных данных</a>`;
        },
    },
    methods: {
        navigateTo(url) {
            window.location.href = url;
        },
        sendResetLink() {
            this.loading = true
            axios.post('/account/password/send-reset-link', this.form).then((response) => {
                this.resetForm()
                this.completed = true
                ElNotification({
                    title: 'Система',
                    message: response.data.message,
                    type: 'success',
                    position: 'bottom-right',
                })
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
                email: null,
            }
            this.errors = []
        },
    }
}
</script>

<style scoped>

</style>
