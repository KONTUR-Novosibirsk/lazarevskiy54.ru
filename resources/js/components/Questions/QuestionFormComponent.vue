<template>
    <div class="feedback-popup__heading">
        <template v-if="completed">
            Ваш вопрос отправлен
        </template>
        <template v-else>
            Задать вопрос
        </template>

    </div>
    <div class="feedback-popup__content">
        <div class="" v-if="completed">
            В скором времени вы получите ответ:)
        </div>
        <form v-else @submit.prevent="store">
            <div class="feedback-popup__item">
                <InputField name="name" label="Имя" v-model="form.name" :errors="errors['name']"/>
            </div>
            <div class="feedback-popup__item">
                <InputField name="email" type="email" label="E-mail" v-model="form.email" :errors="errors['email']"/>
            </div>
            <div class="feedback-popup__item">
                <TextField name="question" label="Ваш вопрос" v-model="form.question" :errors="errors['question']"/>
            </div>
            <p class="feedback-popup__privacy" v-if="privacyPolicyLink">
                Нажимая на кнопку я даю согласие на обработку <a :href="privacyPolicyLink">персональных данных</a>
            </p>
            <button type="submit" class="feedback-btn">Отправить</button>
        </form>
    </div>
    <div class="loader-frame" v-if="loading">
        <div class="loader"></div>
    </div>
</template>

<script>

import InputField from "../Ui/Form/InputField.vue";
import TextField from "../Ui/Form/TextField.vue";
import {useRecaptchaStore} from "../../Stores/GoogleRecaptcha";

export default {
    name: "QuestionFormComponent",
    components: {TextField, InputField},
    props: {
        privacyPolicyLink: null,
    },
    data() {
        return {
            completed: false,
            loading: false,
            errors: [],
            form: {
                name: null,
                email: null,
                question: null,
            }
        }
    },
    methods: {
        async generateToken() {
            this.form['g_recaptcha_token'] = await useRecaptchaStore().generateToken('question')
        },
        async store() {
            this.loading = true
            await this.generateToken()
            axios.post('/questions/store', this.form).then((response) => {
                this.completed = true
            }).catch((error) => {
                if (error.response['status'] === 422) {
                    this.errors = error.response.data.errors
                }
            }).finally(() => {
                this.loading = false
            })
        }
    }
}
</script>

<style scoped>

</style>
