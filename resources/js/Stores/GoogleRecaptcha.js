import {defineStore} from 'pinia'
import {load} from "recaptcha-v3";

export const useRecaptchaStore = defineStore('google-recaptcha', {
    state: () => ({
        recaptcha_status: false,
        recaptcha_key: null,
    }),
    actions: {
        async generateToken(action) {
            if (!this.recaptcha_key) {
                await this.getRecaptchaInfo()
            }
            if (this.recaptcha_status) {
                const recaptcha = await load(this.recaptcha_key)
                return await recaptcha.execute(action)
            }
            return 'no_required'
        },
        async getRecaptchaInfo() {
            await axios.get('/google/recaptcha-info').then((response) => {
                this.recaptcha_status = response.data.recaptcha_status
                this.recaptcha_key = response.data.recaptcha_key
            })
        }
    }
})
