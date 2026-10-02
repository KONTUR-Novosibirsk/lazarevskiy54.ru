<template>
    <div class="feedback-popup__heading">
        <template v-if="completed">
            Спасибо за ваш отзыв
        </template>
        <template v-else>
            Оставить отзыв
        </template>
    </div>
    <div class="feedback-popup__content">
        <div class="" v-if="completed">
            В скором времени он появиться на нашем сайте:)
        </div>
        <form v-else @submit.prevent="store">
            <div class="feedback-popup__item">
                <InputField name="name" label="Имя" v-model="form.name" :errors="errors['name']"/>
            </div>
            <div class="feedback-popup__item">
                <TextField name="text" label="Ваш вопрос" v-model="form.text" :errors="errors['text']"/>
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
import TextField from "../Ui/Form/TextField.vue";
import InputField from "../Ui/Form/InputField.vue";
import {useRecaptchaStore} from "../../Stores/GoogleRecaptcha";

export default {
    name: "ReviewFormComponent",
    components: {InputField, TextField},
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
                text: null,
            }
        }
    },
    methods: {
        async generateToken() {
            this.form['g_recaptcha_token'] = await useRecaptchaStore().generateToken('review')
        },
        async store() {
            this.loading = true
            await this.generateToken()
            axios.post('/reviews/store', this.form).then((response) => {
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
