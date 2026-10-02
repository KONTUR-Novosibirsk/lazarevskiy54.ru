<template>
    <el-button type="primary" size="small" @click="modal = true" :class="$attrs.class">
        <Icon icon="material-symbols:edit-square"/>
    </el-button>
    <el-dialog title="Изменить" v-model="modal">
        <el-form label-position="top">
            <form-item label="Название" :errors="errors['name']">
                <el-input v-model="imageData.name" />
            </form-item>
            <form-item label="Описание" :errors="errors['text']">
                <el-input v-model="imageData.text"/>
            </form-item>
        </el-form>
        <template #footer>
            <el-button type="primary" :loading="loading" @click="update">Сохранить</el-button>
        </template>
    </el-dialog>
</template>

<script>
import HandleErrorsMixin from "../../../Shared/Mixins/HandleErrorsMixin";
import FormItem from "../../../components/UI/Form/FormItem.vue";
import {ElNotification} from "element-plus";

export default {
    name: "EditImage",
    mixins: [HandleErrorsMixin],
    components: {FormItem},
    props: {
        index: null,
        image: {
            type: Object,
            default: {},
        }
    },
    data() {
        return {
            loading: false,
            modal: false,
            imageData: {
                type: Object,
                default: {},
            },
        }
    },
    mounted() {
        this.imageData = {...this.image}
    },
    methods: {
        update() {
            this.loading = true
            axios.patch(route('admin.gallery.image.update', this.imageData.id), this.imageData).then((response) => {
                this.imageData = response.data.data
                this.$emit('updateImage', this.index, this.imageData)
                ElNotification.success({message: 'Данные обновлены', position: 'bottom-right'})
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
