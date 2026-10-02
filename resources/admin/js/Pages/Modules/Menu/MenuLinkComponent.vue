<template>
    <el-button type="primary" size="small" @click="modal = true" class="me-1">{{ buttonName }}</el-button>
    <el-dialog :title="buttonName" v-model="modal">
        <el-form label-position="top">
            <form-item label="Название" :errors="errors['name']">
                <el-input v-model="menuItem.name"/>
            </form-item>
            <form-item label="Ссылка" :errors="errors['url']">
                <el-input v-model="menuItem.url"/>
            </form-item>
            <el-button type="primary" :loading="loading" @click="save">Сохранить</el-button>
        </el-form>
    </el-dialog>
</template>

<script>
import FormItem from "../../../components/UI/Form/FormItem.vue";
import HandleErrorsMixin from "../../../Shared/Mixins/HandleErrorsMixin";
import {ElNotification} from "element-plus";

export default {
    name: "MenuLinkComponent",
    components: {FormItem},
    mixins: [HandleErrorsMixin],
    props: {
        index: null,
        category: null,
        modelValue: null,
        buttonName: {
            type: String,
        },
        buttonSize: {
            type: String,
            default: null,
        }
    },
    data() {
        return {
            modal: false,
            menuItem: {
                name: null,
                url: null,
            },
            loading: false,
        }
    },
    mounted() {
        if (this.modelValue)
            this.menuItem = {...this.modelValue}
    },
    methods: {
        save() {
            if (this.modelValue) {
                this.update()
            } else {
                this.store()
            }
        },
        store() {
            this.loading = true
            this.errors = []
            axios.post('/admin/menu/store', {
                name: this.menuItem.name,
                url: this.menuItem.url,
                category_id: this.category.id,
            }).then((response) => {
                this.$emit('add', response.data.data);
                this.modal = false
                this.menuItem.name = null
                this.menuItem.url = null
            }).catch((error) => {
                this.handleErrors(error)
            }).finally(() => {
                this.loading = false
            })
        },
        update() {
            this.loading = true
            this.errors = []
            axios.patch('/admin/menu/update/' + this.menuItem.id, {
                name: this.menuItem.name,
                url: this.menuItem.url,
            }).then((response) => {
                this.modal.hide()
                this.$emit('update', response.data.data, this.index)
                ElNotification.success({message: 'Данные изменены', position: 'bottom-right'})
            }).catch((error) => {
                this.handleErrors(error)
            }).finally(() => {
                this.loading = false
            })
        },
    }
}
</script>

<style scoped>

</style>
