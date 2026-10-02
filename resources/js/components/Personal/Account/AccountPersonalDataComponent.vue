<template>
    <div class="feedback-popup__content auth-form">
        <form @submit.prevent="update">
            <div class="feedback-popup__item">
                <InputField name="full_name" type="text" label="ФИО" v-model="accountValue.full_name" :errors="errors['full_name']"/>
            </div>
            <div class="feedback-popup__item">
                <InputField required name="email" type="email" label="E-mail" v-model="accountValue.email" :errors="errors['email']"/>
            </div>
            <div class="feedback-popup__item">
                <InputField name="phone" type="phone" label="Телефон" v-model="accountValue.phone" :errors="errors['phone']"/>
            </div>
            <div class="feedback-popup__item">
                <InputField required name="password" type="password" label="Изменить пароль" placeholder="Не менее 6 символов" v-model="accountValue.password" :errors="errors['password']"/>
            </div>
            <div class="feedback-popup__item">
                <InputField required name="password_confirmation" type="password" label="Новый пароль еще раз" v-model="accountValue.password_confirmation" :errors="errors['password']"/>
            </div>
            <button class="feedback-btn" type="submit">Сохранить изменения</button>
        </form>
    </div>
    <div class="loader-frame" v-if="loading">
        <div class="loader"></div>
    </div>
</template>

<script>
import InputField from "@/components/Ui/Form/InputField.vue";
import { ElNotification } from "element-plus";

export default {
    name: "AccountPersonalDataComponent",
    components: { InputField },
    props: {
        personalData: {
            type: Object,
            default: () => ({})
        }
    },
    data() {
        return {
            completed: false,
            loading: false,
            accountValue: {
                full_name: '',
                email: '',
                phone: '',
                password: '',
                password_confirmation: '',
            },
            errors: {}
        }
    },
    mounted() {
        if (this.personalData) {
            this.accountValue.full_name = this.personalData.full_name || '';
            this.accountValue.email = this.personalData.email || '';
            this.accountValue.phone = this.personalData.phone || '';
        }
    },
    methods: {
        update() {
            this.loading = true;
            axios.patch('/account/me/update', this.accountValue)
                .then((response) => {
                    this.completed = true;
                    this.errors = [];
                    this.accountValue.password = ''
                    this.accountValue.password_confirmation = ''
                    ElNotification({
                        title: 'Система',
                        message: 'Данные успешно сохранены!',
                        type: 'success',
                        position: 'bottom-right',
                    });
                })
                .catch((error) => {
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
                })
                .finally(() => {
                    this.loading = false;
                });
        },
    }
}
</script>

<style scoped>

</style>
