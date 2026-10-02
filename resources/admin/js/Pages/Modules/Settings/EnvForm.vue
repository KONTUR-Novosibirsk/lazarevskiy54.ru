<script>
import HandleErrorsMixin from "../../../Shared/Mixins/HandleErrorsMixin";
import {ElNotification} from "element-plus";
import FormItem from "../../../components/UI/Form/FormItem.vue";

export default {
    name: "EnvForm",
    components: {FormItem},
    mixins: [HandleErrorsMixin],
    props: {
        envArray: null
    },
    data() {
        return {
            envArrayValue: {
                debug: null,
                mailHost: null,
                mailPort: null,
                mailUserName: null,
                mailPassword: null,
                mailEncryption: null
            },

            loading: false,
            command: null,
        }
    },
    mounted() {
        if (this.envArray) {
            this.envArrayValue.debug = this.envArray.APP_DEBUG === 'true';
            this.envArrayValue.mailHost = this.envArray.MAIL_HOST;
            this.envArrayValue.mailPort = this.envArray.MAIL_PORT;
            this.envArrayValue.mailUserName = this.envArray.MAIL_USERNAME;
            this.envArrayValue.mailPassword = this.envArray.MAIL_PASSWORD;
            this.envArrayValue.mailEncryption = this.envArray.MAIL_ENCRYPTION;
        }
    },
    methods: {
        saveEnv() {
            axios.post(route('admin.env.save', this.envArrayValue))
                .then((response) => {
                if (response.data.success)
                    ElNotification({
                        title: 'Система',
                        message: 'Файл .env обновлен',
                        type: 'success',
                        position: 'bottom-right',
                    })
                else
                    ElNotification({
                        title: 'Система',
                        message: 'Не удалось обновить файл .env',
                        type: 'error',
                        position: 'bottom-right',
                    })
            }).catch((error) => {
                this.handleErrors(error)
            }).finally(() => {
                this.loading = false
            })
        }
    }
}
</script>

<template>
    <el-card header="Debug" class="mb-3">
        <form-item label="Активно" :errors="errors['active']">
            <el-switch v-model="envArrayValue.debug"/>
        </form-item>
    </el-card>
    <el-card header="Почта" class="mb-3">
        <el-form label-position="top">
            <form-item label="Хост" :errors="errors['mailHost']">
                <el-input v-model="envArrayValue.mailHost"/>
            </form-item>
            <form-item label="Порт" :errors="errors['mailPort']">
                <el-input v-model="envArrayValue.mailPort"/>
            </form-item>
            <form-item label="Логин" :errors="errors['mailUserName']">
                <el-input v-model="envArrayValue.mailUserName"/>
            </form-item>
            <form-item label="Пароль" :errors="errors['mailPassword']">
                <el-input v-model="envArrayValue.mailPassword"/>
            </form-item>
            <form-item label="Протокол шифрования" :errors="errors['mailEncryption']">
                <el-input v-model="envArrayValue.mailEncryption"/>
            </form-item>
        </el-form>
    </el-card>
    <el-button
        type="primary" @click="saveEnv()">Сохранить
    </el-button>
</template>
