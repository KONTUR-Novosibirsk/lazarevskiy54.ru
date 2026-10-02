<template>
    <div class="feedback-popup__heading">
        <template v-if="completed">
            Заказ оформлен
        </template>
        <template v-else>
            Оформление заказа
        </template>
    </div>
    <div class="feedback-popup__content">
        <div class="" v-if="completed">
            Подробная информация отправлена на ваш email
        </div>
        <form v-else @submit.prevent="store">
            <div class="feedback-popup__item">
                <InputField name="user_name" label="Имя" v-model="form.user_name" :errors="errors['user_name']"/>
            </div>
            <div class="feedback-popup__item">
                <InputField name="user_email" label="Email" v-model="form.user_email" :errors="errors['user_email']"/>
            </div>
            <div class="feedback-popup__item">
                <PhoneField name="user_phone" label="Ваш телефон" v-model="form.user_phone"
                            :errors="errors['user_phone']"/>
            </div>
            <div class="feedback-popup__item">
                <TextField name="text" label="Адрес доставки" v-model="form.address" :errors="errors['address']"/>
            </div>
            <p class="feedback-popup__privacy" v-if="privacyPolicyLink">
                Нажимая на кнопку я даю согласие на обработку <a :href="privacyPolicyLink">персональных данных</a>
            </p>
            <button type="submit" class="feedback-btn">Заказать</button>
        </form>
    </div>
    <div class="loader-frame" v-if="loading">
        <div class="loader"></div>
    </div>
</template>

<script>
import InputField from "../Ui/Form/InputField.vue";
import PhoneField from "../Ui/Form/PhoneField.vue";
import TextField from "../Ui/Form/TextField.vue";

export default {
    name: "OrderComponent",
    components: {InputField, PhoneField, TextField},
    props: {
        privacyPolicyLink: null,
    },
    data() {
        return {
            completed: false,
            loading: false,
            errors: [],
            form: {
                user_name: null,
                user_phone: null,
                user_email: null,
                address: null,
            }
        }
    },
    methods: {
        store() {
            this.loading = true
            axios.post('/shop/order/store', this.form).then((response) => {
                this.$emit('success');
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
