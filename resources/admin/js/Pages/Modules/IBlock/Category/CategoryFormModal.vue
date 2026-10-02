<template>
    <el-button type="primary" :size="size" @click="modal = true" class="me-1">{{ buttonName }}</el-button>
    <el-dialog v-model="modal" :title="buttonName">
        <el-form label-position="top">
            <form-item label="Название" :errors="errors['name']">
                <el-input v-model="categoryData.name"/>
            </form-item>
        </el-form>
        <el-button type="primary" :loading="loading" @click="save">Сохранить</el-button>
    </el-dialog>
</template>

<script>
import HandleErrorsMixin from "../../../../Shared/Mixins/HandleErrorsMixin";
import FormItem from "../../../../components/UI/Form/FormItem.vue";
import {ElNotification} from "element-plus";

export default {
    name: "CategoryFormModal",
    mixins: [HandleErrorsMixin],
    emits: ['updateCategory', 'addCategory'],
    components: {FormItem},
    props: {
        index: null,
        size: {
            type: String,
            default: 'default',
        },
        category: {
            type: Object,
            default: null,
        }
    },
    data() {
        return {
            modal: false,
            loading: false,
            categoryData: {
                name: '',
            },
        }
    },
    mounted() {
        if (this.category)
            this.categoryData = {...this.category}
    },
    computed: {
        buttonName() {
            return this.category ? 'Изменить' : 'Добавить категорию';
        }
    },
    methods: {
        save() {
            this.loading = true
            this.errors = []
            if (this.category) {
                this.update()
            } else {
                this.store()
            }
        },
        store() {
            axios.post(route('admin.iblock.category.store'), this.categoryData).then((response) => {
                ElNotification.success({message: 'Категория добавлена', position: 'bottom-right'})
                this.$emit('addCategory', response.data.data)
                this.categoryData.name = null;
                this.modal = false
            }).catch((errors) => {
                this.handleErrors(errors)
            }).finally(() => {
                this.loading = false
            })
        },
        update() {
            axios.patch(route('admin.iblock.category.update', this.categoryData.id), this.categoryData).then((response) => {
                ElNotification.success({message: 'Данные изменены', position: 'bottom-right'})
                this.$emit('updateCategory', this.index, response.data.data)
            }).catch((errors) => {
                this.handleErrors(errors)
            }).finally(() => {
                this.loading = false
            })
        }
    }
}
</script>

<style scoped>

</style>
