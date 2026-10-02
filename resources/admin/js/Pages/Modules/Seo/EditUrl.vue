<template>
    <el-button type="primary" @click="modal = true" :size="size" class="me-1">{{ name }}</el-button>
    <el-dialog v-model="modal" :title="name" :append-to-body="true" align-center>
        <el-form label-position="top">
            <form-item :errors="errors['url']" label="URL">
                <el-input v-model="urlSeoData.url"/>
            </form-item>
            <SeoComponent :errors="errors" v-model="urlSeoData.seo"/>
            <el-button :loading="loading" @click="save" type="primary">Сохранить</el-button>
        </el-form>
    </el-dialog>
</template>

<script>
import {router} from "@inertiajs/vue3";
import SeoComponent from "../../../components/seo/SeoComponent.vue";
import FormItem from "../../../components/UI/Form/FormItem.vue";
import {ElNotification} from "element-plus";
import HandleErrorsMixin from "../../../Shared/Mixins/HandleErrorsMixin";

export default {
    name: "EditUrl",
    components: {FormItem, SeoComponent},
    mixins: [HandleErrorsMixin],
    props: {
        name: {
            type: String,
            required: true,
        },
        urlSeo: {
            type: Object,
            default: {},
        },
        size: {
            type: String,
            default: 'default',
        }
    },
    data() {
        return {
            modal: false,
            loading: false,
            urlSeoData: {
                'url': '',
                'seo': null,
            },
            errors: {
                type: Object,
                default: {},
            }
        }
    },
    mounted() {
        if (this.urlSeo) {
            this.urlSeoData = this.urlSeo
        }
    },
    methods: {
        save() {
            this.loading = true
            if (this.urlSeoData['id']) {
                this.update()
            } else {
                this.store()
            }
        },
        store() {
            axios.post(route('admin.url_seo.store'), this.urlSeoData).then((response) => {
                this.urlSeoData = {
                    'url': '',
                    'seo': {
                        'title': '',
                        'h1': '',
                        'keywords': '',
                        'description': '',
                        'site_map': false,
                        'changefreq': '',
                        'priority': '',
                    },
                }
                ElNotification({
                    title: 'Система',
                    message: 'URL адрес с seo данными добавлен',
                    type: 'success',
                    position: 'bottom-right',
                })
                this.modal = false
                router.reload();
            }).catch((errors) => {
                this.handleErrors(errors)
            }).finally(() => {
                this.loading = false
            })
        },
        update() {
            axios.patch(route('admin.url_seo.update', this.urlSeoData.id), this.urlSeoData).then((response) => {
                this.errors = []
                ElNotification({
                    title: 'Система',
                    message: 'Данные обновлены',
                    type: 'success',
                    position: 'bottom-right',
                })
                this.modal = false
                router.reload();
            }).catch((errors) => {
                this.handleErrors(errors)
            }).finally(() => {
                this.loading = false
            })
        }
    }
}
</script>
