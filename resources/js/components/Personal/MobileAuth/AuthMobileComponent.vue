<template>
    <div class="w-[500px] feedback-popup__content auth-form" v-if="completedPhone">
        <form @submit.prevent="submitPin" action="">
            <div class="feedback-popup__item !mb-[20px]">
                <h2 class="mb-[20px]">Подтверждение</h2>
                <div class="text-center text-[13px] mb-[20px]">Мы отправили код подтверждения на номер
                    {{ form.phone }}
                    <button type="button" @click="completedPhone = false" class="text-blue-600">Изменить
                    </button>
                </div>
                <div class="flex justify-center gap-[15px]">
                    <input
                        v-for="(value, index) in pin"
                        :key="index"
                        v-model="pin[index]"
                        maxlength="1"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        class="!w-[50px] !h-[50px] text-[24px] text-center border-[1px] border-border !rounded-[6px]"
                        @input="onInput($event, index)"
                        @keydown.backspace="onBackspace(index)"
                        ref="pinInput"
                    />
                </div>
            </div>
            <button type="submit" class="feedback-btn w-full mb-[20px]">Подтвердить
            </button>
            <div v-if="replayPass" class="mb-[20px]">
                <p class="text-center text-text ">Получить новый код можно через {{ timer }} сек.
                </p>
            </div>
            <div v-else-if="!replayPass" class="mb-[20px]">
                <button type="button" class="w-full text-[15px]" @click="phoneCheck">Получить новый код</button>
            </div>
        </form>
    </div>
    <form class="feedback-popup__content auth-form" v-else @submit.prevent="phoneCheck">
        <h2 class="mb-[20px]">Вход</h2>
        <div class="feedback-popup__item !mb-[20px]">
            <PhoneField @click="startInput" :placeholder="'+7 (___) ___-__-__'" name="user_phone" label="Телефон"
                        v-model="form.phone"
                        :errors="errors['phone']"/>
        </div>
        <div class="feedback-popup__privacy" v-if="privacyPolicyLink">
            <CheckboxUi :label="privacyLabel" name="feedback" v-model="form.policy" :errors="errors['policy']"/>
        </div>
        <button type="submit" class="feedback-btn mb-[20px]">Подтвердить</button>
    </form>
</template>

<script>
import InputField from "@/components/Ui/Form/InputField.vue";
import PhoneField from "@/components/Ui/Form/PhoneField.vue";
import FeedbackMixin from "@/Share/Mixins/FeedbackMixin.js";
import CheckboxUi from "@/components/Ui/Form/CheckboxUi.vue";

export default {
    name: "AuthFormComponent",
    components: {InputField, PhoneField, CheckboxUi},
    mixins: [FeedbackMixin],
    props: {
        privacyPolicyLink: null,
    },
    data() {
        return {
            completed: false,
            completedPhone: false,
            // 1 - тел. отправлен и идёт таймер, 2 - отправить снова
            timer: 60,
            replayPass: true,
            loading: false,
            errors: [],
            form: {
                phone: null,
            },
            policy: false,
            pin: ["", "", "", ""],
        }

    },
    computed: {
        checkAction() {
            const authElement = document.getElementById('auth');
            if (authElement && authElement.getAttribute('data-action')) {
                return authElement.getAttribute('data-action');
            }
            return '';
        },
        privacyLabel() {
            return `Я согласен на <a href="${this.privacyPolicyLink}">обработку персональных данных</a>`;
        },
    },
    methods: {
        startInput(event) {
            if (event.target.value === "") {
                event.target.value = "+7"
            }
        },

        phoneCheck() {
            if (this.loading === true) {
                return;
            }

            this.loading = true;
            // axios.post('/account/create',
            //     {phone: this.form.phone},
            //     {
            //         headers: {
            //             'Accept': 'application/json',
            //             'Content-Type': 'application/json'
            //         }
            //     })
            //     .then((res) => {
            //         if (res.status == 200) {
            //             this.completedPhone = true;
            //             this.PassTimer();
            //         }
            //     })
            //     .catch((error) => {
            //         if (error.response['status'] === 422) {
            //             this.errors = error.response.data.errors
            //         }
            //     })
            //     .finally(() => {
            //         this.loading = false;
            //     });
            this.completedPhone = true;
            this.PassTimer();
            this.loading = false;
        },
        codeCheck(pincode) {
            if (this.loading === true) {
                return;
            }
            this.loading = true;
            axios.post(`/account/store?action=${this.checkAction}`,
                {
                    phone: this.form.phone,
                    code: pincode,
                },
                {
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then((res) => {
                    window.location.reload();
                })
                .catch((error) => {
                    if (error.response['status'] === 422) {
                        this.errors = error.response.data.errors
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        // auth pincode
        onInput(event, index) {
            const value = event.target.value;
            if (/\d/.test(value)) {
                this.pin[index] = value;
                if (index < this.pin.length - 1) {
                    this.$refs.pinInput[index + 1].focus();
                }
            } else {
                this.pin[index] = "";
            }

        },
        onBackspace(index) {
            if (this.pin[index] === "" && index > 0) {
                this.$refs.pinInput[index - 1].focus();
            }
        },

        submitPin() {
            const pinCode = this.pin.join("");
            this.codeCheck(pinCode);
        },

        PassTimer() {
            this.replayPass = 1;
            let interval = setInterval(() => {
                if (this.timer > 0) {
                    this.timer--;
                } else {
                    clearInterval(interval);
                    this.timer = 60;
                    this.replayPass = false;
                }
            }, 1000); // обновление каждую секунду
        }

    }
}
</script>
