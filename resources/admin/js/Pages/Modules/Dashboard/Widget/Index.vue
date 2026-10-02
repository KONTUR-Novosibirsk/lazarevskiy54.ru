<template>
    <el-row :gutter="20">
        <el-col :xs="24" :lg="12">
            <template v-for="widget in widgetsData">
                <el-card body-class="p-2" class="mb-2">
                    <div class="flex justify-between">
                        <div class="my-auto ms-4">{{ widget.name }}</div>
                        <div class="me-2 my-auto">
                            <el-switch size="small" v-model="widget.active" inline-prompt/>
                        </div>
                    </div>
                </el-card>
            </template>
        </el-col>
        <el-col :xs="24" :lg="12">
            <el-alert type="warning" :closable="false" class="mb-3 py-4">Список виджетов доступных для главной страницы.
            </el-alert>
            <el-button :loading="loading" type="primary" @click="save">Сохранить</el-button>
        </el-col>
    </el-row>
</template>

<script>
import MainLayout from "../../../../Layouts/MainLayout.vue";
import HandleErrorsMixin from "../../../../Shared/Mixins/HandleErrorsMixin";
import {ElNotification} from "element-plus";

export default {
    name: "Index",
    layout: MainLayout,
    mixins: [HandleErrorsMixin],
    props: {
        widgets: {
            type: Object,
            default: {},
        },
    },
    data() {
        return {
            loading: false,
            widgetsData: this.widgets.data
        }
    },
    methods: {
        save() {
            this.loading = true
            axios.post(route('admin.widget.update'), {
                widgets: this.widgetsData,
            }).then((response) => {
                ElNotification.success({message: 'Сохранено', position: 'bottom-right'})
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
