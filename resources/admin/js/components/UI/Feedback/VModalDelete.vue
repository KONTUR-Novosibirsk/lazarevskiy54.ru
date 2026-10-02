<template>
    <el-button type="danger" @click="modal = true" :size="size">
        <slot v-if="!!$slots.default"></slot>
        <template v-else>{{ buttonText }}</template>
    </el-button>

    <el-dialog
        v-model="modal"
        title="Удалить запись"
        width="500"
        :append-to-body="true"
        align-center
    >
        <span>{{ text }}</span>
        <template #footer>
            <div class="dialog-footer">
                <el-button @click="modal = false">Отмена</el-button>
                <el-button type="danger" @click="deleteRecord" :loading="loading">
                    Удалить
                </el-button>
            </div>
        </template>
    </el-dialog>
</template>

<script>
import HandleErrorsMixin from "../../../Shared/Mixins/HandleErrorsMixin";
import {ElNotification} from "element-plus";
import {router} from "@inertiajs/vue3";

export default {
    name: "VModalDelete",
    mixins: [HandleErrorsMixin],
    emits: ['onDelete'],
    props: {
        url: null,
        index: null,
        refresh: {
            default: false,
            type: Boolean,
        },
        size: {
            type: String,
            default: 'small',
        },
        buttonText: {
            type: String,
            default: 'Удалить',
        },
        text: {
            type: String,
            default: 'Вы подтверждаете удаление записи?',
        },
    },
    data() {
        return {
            loading: false,
            modal: false,
        }
    },
    methods: {
        deleteRecord() {
            this.loading = true
            if (this.refresh)
                this.inertiaVisit()
            else
                this.axiosRequest()
        },
        axiosRequest() {
            axios.delete(this.url).then((response) => {
                this.$emit('onDelete', this.index)
                ElNotification.success({message: 'Запись удалена', position: 'bottom-right'})
                this.modal = false
            }).catch((error) => {
                this.handleErrors(error)
            }).finally(() => {
                this.loading = false
            })
        },
        inertiaVisit() {
            router.delete(this.url, {
                preserveScroll: true,
                preserveState: false,
                onSuccess: () => {
                    ElNotification.success({message: "Запись успешно удалена удалена", position: 'bottom-right'})
                    this.loading = false
                    this.modal = false
                },
                onError: () => {
                    ElNotification.error({message: "Ошибка при удалении", position: 'bottom-right'})
                }
            })
        },
    }
}
</script>

<style scoped>

</style>
