<template>
    <el-button type="primary" :size="size" @click="modal = true">{{ buttonName }}</el-button>
    <el-dialog v-model="modal" :append-to-body="true" :title="buttonName">
        <el-form label-position="top">
            <form-item label="Имя" :errors="errors['name']">
                <el-input v-model="accountData.name"/>
            </form-item>
            <form-item label="Chat id" :errors="errors['chat_id']">
                <el-input v-model="accountData.chat_id"/>
            </form-item>
            <form-item label="Активен" :errors="errors['is_active']">
                <el-switch v-model="accountData.is_active"/>
            </form-item>
        </el-form>
        <el-button type="primary" @click="save" :loading="loading">Сохранить</el-button>
    </el-dialog>
</template>

<script>
import {router} from "@inertiajs/vue3";
import HandleErrorsMixin from "../../../Shared/Mixins/HandleErrorsMixin";
import FormItem from "../../../components/UI/Form/FormItem.vue";
import {ElNotification} from "element-plus";

export default {
    name: "AccountForm",
    mixins: [HandleErrorsMixin],
    components: {FormItem},
    props: {
        size: {
            type: String,
            default: 'default',
        },
        account: null,
        index: null,
    },
    data() {
        return {
            modal: null,
            loading: false,
            accountData: {
                name: '',
                chat_id: '',
                is_active: true,
            }
        }
    },
    mounted() {
        if (this.account) {
            this.accountData = {...this.account}
        }
    },
    computed: {
        buttonName() {
            return this.account ? 'Изменить' : 'Добавить'
        }
    },
    methods: {
        save() {
            this.loading = true
            this.errors = []
            if (this.account) {
                this.update()
            } else {
                this.store()
            }
        },
        update() {
            axios.patch(route('admin.tg.account.update', this.accountData.id), this.accountData).then((response) => {
                ElNotification.success({position: 'bottom-right', message: 'Данные обновлены'})
                this.modal = false
                this.accountData = response.data.data
                this.$emit('update', this.index, {...this.accountData})
            }).catch((error) => {
                this.handleErrors(error)
            }).finally(() => {
                this.loading = false

            })
        },
        store() {
            axios.post(route('admin.tg.account.store'), this.accountData).then((response) => {
                ElNotification.success({position: 'bottom-right', message: 'Аккаунт добавлен'})
                this.modal = false
                router.get(route('admin.tg.index'))
            }).catch((error) => {
                this.handleErrors(error)
            }).finally(() => {
                this.loading = false
            })
        }
    }
}
</script>
