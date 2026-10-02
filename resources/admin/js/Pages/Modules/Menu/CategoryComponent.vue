<template>
    <el-button type="primary" @click="modal = true" :class="$attrs.class" :size="size">{{ buttonName }}</el-button>
    <el-dialog :title="buttonName" v-model="modal" :append-to-body="true">
        <el-form label-position="top">
            <form-item label="Название" :errors="errors['name']">
                <el-input v-model="category.name"/>
            </form-item>
            <form-item label="Код" :errors="errors['code']">
                <el-input v-model="category.code"/>
            </form-item>
            <form-item label="Описание" :errors="errors['description']">
                <el-input v-model="category.description" type="textarea"/>
            </form-item>
            <el-button type="primary" @click="save" :loading="loading">Сохранить</el-button>
        </el-form>
    </el-dialog>
</template>

<script>
import FormItem from "../../../components/UI/Form/FormItem.vue";
import HandleErrorsMixin from "../../../Shared/Mixins/HandleErrorsMixin";
import {ElNotification} from "element-plus";

export default {
    name: "CategoryComponent",
    mixins: [HandleErrorsMixin],
    components: {FormItem},
    props: {
        modelValue: null,
        buttonName: {
            type: String,
        },
        size: {
            type: String,
            default: 'small',
        }
    },
    data() {
        return {
            modal: false,
            category: {
                name: null,
                code: null,
                description: null,
            },
            loading: false,
        }
    },
    mounted() {
        if (this.modelValue) {
            this.category = {...this.modelValue}
        }
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
            axios.post('/admin/menu/category/store', {
                name: this.category.name,
                code: this.category.code,
                description: this.category.description,
            }).then((response) => {
                this.$emit('add', response.data.data);
                this.modal = false;
                this.category.name = null
                this.category.code = null
                this.category.description = null
                this.errors = []
            }).catch((error) => {
                this.handleErrors(error)
            }).finally(() => {
                this.loading = false
            })
        },
        update() {
            this.loading = true
            axios.patch('/admin/menu/category/update/' + this.category.id, {
                name: this.category.name,
                code: this.category.code,
                description: this.category.description,
            }).then((response) => {
                this.$emit('update:modelValue', {...this.category});
                this.modal = false
                this.errors = []
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
