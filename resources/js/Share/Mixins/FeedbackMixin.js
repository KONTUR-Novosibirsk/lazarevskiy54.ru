import {useRecaptchaStore} from "../../Stores/GoogleRecaptcha";

export default {
    props: {
        privacyPolicyLink: null,
    },
    data() {
        return {
            name: '',
            completed: false,
            loading: false,
            errors: [],
        }
    },
    mounted() {

    },
    methods: {
        async generateToken() {
            this.form['g_recaptcha_token'] = await useRecaptchaStore().generateToken('feedback')
        },
        async store() {
            this.loading = true
            await this.generateToken()
            axios.post('/feedback/store/' + this.name, this.form).then((response) => {
                this.completed = true
            }).catch((error) => {
                if (error.response['status'] === 422) {
                    this.errors = error.response.data.errors
                }
            }).finally(() => {
                this.loading = false
            })
        }
    },
}
