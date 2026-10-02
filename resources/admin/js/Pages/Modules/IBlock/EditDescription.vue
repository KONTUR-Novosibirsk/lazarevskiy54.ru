<template>
    <el-button @click="modal = true" type="primary">
        Редактировать описание инфо-блока
    </el-button>

    <el-dialog v-model="modal" title="Изменить описание инфо-блока" :append-to-body="true">
        <el-form label-position="top">
            <form-item label="Название">
                <el-input v-model="title" :errors="errors['title']"/>
            </form-item>
            <form-item label="Описание">
                <v-editor v-model="description" :errors="errors['description']"/>
            </form-item>
            <el-button @click="update" type="primary" :loading="loading">Сохранить</el-button>
        </el-form>
    </el-dialog>
</template>

<script>
import HandleErrorsMixin from "../../../Shared/Mixins/HandleErrorsMixin";
import FormItem from "../../../components/UI/Form/FormItem.vue";
import {ElNotification} from "element-plus";
import VEditor from "../../../components/UI/Form/VEditor.vue";

export default {
    name: "EditDescription",
    mixins: [HandleErrorsMixin],
    components: {VEditor, FormItem},
    props: {
        iblock: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {
            loading: false,
            modal: false,
            title: null,
            description: null,
        }
    },
    mounted() {
        this.title = this.iblock.title
        this.description = this.iblock.description
    },
    methods: {
        update() {
            this.loading = true
            this.errors = {}
            axios.patch('/admin/iblock/updateForUser/' + this.iblock.id, {
                description: this.description,
                title: this.title,
            }).then((response) => {
                this.$page.props.seo.title = this.title
                ElNotification.success({message: 'Данные сохранены', position: 'bottom-right'})
            }).catch((error) => {
                this.handleErrors(error)
            }).finally(() => {
                this.loading = false
            })
        },
    },
}
</script>

<style scoped>

</style>
