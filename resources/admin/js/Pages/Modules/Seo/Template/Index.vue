<template>
    <el-row :gutter="20">
        <el-col :xs="24" :lg="12">
            <v-list-group>
                <v-list-group-item v-for="template in templatesData" @click="setActive(template)"
                                   :current="activeTemplate && template.name == activeTemplate.name">
                    {{ template.name }}
                </v-list-group-item>
            </v-list-group>
        </el-col>
        <el-col :xs="24" :lg="12">
            <el-card v-if="activeTemplate" :header="activeTemplate.name" v-loading="loading">
                <el-form label-position="top" class="mb-3">
                    <form-item :errors="errors['seo.title']" label="Заголовок">
                        <el-input v-model="activeTemplate.seo.title"/>
                    </form-item>
                    <form-item :errors="errors['seo.h1']" label="H1">
                        <el-input v-model="activeTemplate.seo.h1"/>
                    </form-item>
                    <form-item :errors="errors['seo.keywords']" label="Keywords">
                        <el-input v-model="activeTemplate.seo.keywords" type="textarea"/>
                    </form-item>
                    <form-item :errors="errors['seo.description']" label="Description">
                        <el-input v-model="activeTemplate.seo.description" type="textarea"/>
                    </form-item>
                    <el-button type="primary" @click="save" :loading="loading">Сохранить</el-button>
                    <el-button type="danger" v-if="activeTemplate.seo['id']"
                               @click="deleteSeo">Удалить шаблонные seo
                    </el-button>
                </el-form>
                <el-alert type="warning" :closable="false">
                    Доступны атрибуты модели в фигурных скобках.
                    <el-divider class="my-3"/>
                    Например: Купить {name} в Новосибирске.
                </el-alert>
            </el-card>
        </el-col>
    </el-row>
</template>
<script>
import MainLayout from "../../../../Layouts/MainLayout.vue";
import VListGroup from "../../../../components/UI/Data/VListGroup.vue";
import VListGroupItem from "../../../../components/UI/Data/VListGroupItem.vue";
import FormItem from "../../../../components/UI/Form/FormItem.vue";
import HandleErrorsMixin from "../../../../Shared/Mixins/HandleErrorsMixin";
import {ElMessage, ElNotification} from "element-plus";

export default {
    name: "Index",
    layout: MainLayout,
    components: {FormItem, VListGroupItem, VListGroup},
    mixins: [HandleErrorsMixin],
    props: {
        templates: {
            type: Object,
            default: {},
        }
    },
    data() {
        return {
            loading: false,
            errors: [],
            templatesData: {
                type: Object,
                default: {},
            },
            default: {
                title: '',
                h1: '',
                keywords: '',
                description: '',
            },
            activeTemplate: null,
        }
    },
    mounted() {
        this.templatesData = this.templates.data
        console.log(this.templates);
    },
    methods: {
        setActive(template) {
            if (!this.loading) {
                if (!template.seo) {
                    template.seo = {...this.default}
                }
                this.activeTemplate = template
                this.errors = []
            } else
                ElMessage.error('Подождите идет загрузка');
        },
        save() {
            this.loading = true
            axios.post(route('admin.seo.template.updateOrCreate'), this.activeTemplate).then((response) => {
                this.errors = []
                this.activeTemplate.seo = response.data.data
                ElNotification({
                    title: 'Система',
                    message: 'Данные сохранены',
                    type: 'success',
                    position: 'bottom-right',
                })
            }).catch((errors) => {
                this.handleErrors(errors)
            }).finally(() => {
                this.loading = false
            })
        },
        deleteSeo() {
            this.loading = true
            axios.delete(route('admin.seo.template.delete', this.activeTemplate.seo.id)).then(() => {
                this.activeTemplate.seo = {...this.default}
                ElMessage.success('Шаблонные SEO удалены из базы')
            }).catch(() => {
                ElMessage.error('Ошибка при удалении')
            }).finally(() => {
                this.loading = false
            })
        }
    }
}
</script>

<style scoped>

</style>
