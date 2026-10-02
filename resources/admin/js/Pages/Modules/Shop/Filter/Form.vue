<template>
    <el-row :gutter="20">
        <el-col :xs="24" :lg="8" class="mb-2">
            <el-card header="Основное" class="mb-2">
                <el-form label-position="top">
                    <form-item label="Название" :errors="errors['name']">
                        <el-input v-model="filterValue.name"/>
                    </form-item>
                </el-form>
            </el-card>
            <el-button @click="save" :loading="loading" type="primary">Сохранить</el-button>
        </el-col>
        <el-col :xs="24" :lg="16" class="mb-2">
            <el-card header="Атрибуты">
                <AttributesComponent v-model="filterValue.attributes" :attributes="attributes"
                                     :errors="errors"/>
            </el-card>
        </el-col>
    </el-row>
</template>

<script>
import MainLayout from "../../../../Layouts/MainLayout.vue";
import AttributesComponent from "./AttributesComponent.vue";
import HandleErrorsMixin from "../../../../Shared/Mixins/HandleErrorsMixin";
import {router} from "@inertiajs/vue3";
import FormItem from "../../../../components/UI/Form/FormItem.vue";
import {ElNotification} from "element-plus";

export default {
    name: "Form",
    layout: MainLayout,
    components: {FormItem, AttributesComponent},
    mixins: [HandleErrorsMixin],
    props: {
        filterData: null,
        attributes: null,
    },
    data() {
        return {
            loading: false,
            errors: [],
            filterValue: {
                name: null,
                attributes: [],
            }
        }
    },
    mounted() {
        if (this.filterData) {
            this.filterValue = this.filterData.data
        }
    },
    methods: {
        async save() {
            this.loading = true
            this.errors = []
            if (this.filterData) {
                await this.update();
            } else {
                await this.store();
            }
            this.loading = false
        },
        async store() {
            await axios.post(route('admin.shop.filter.store'), this.filterValue).then((response) => {
                router.visit(route('admin.shop.filter.edit', response.data.data.id))
                ElNotification.success({message: 'Фильтр создан', position: 'bottom-right'})
            }).catch((errors) => {
                this.handleErrors(errors);
            })
        },
        async update() {
            await axios.patch(route('admin.shop.filter.update', this.filterData.data.id), this.filterValue).then((response) => {
                this.filterValue = response.data.data
                ElNotification.success({message: 'Данные обновлены', position: 'bottom-right'})
            }).catch((errors) => {
                this.handleErrors(errors)
            })
        }
    }
}
</script>

<style scoped>

</style>
