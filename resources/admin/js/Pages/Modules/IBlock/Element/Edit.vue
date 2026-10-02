<template>
    <el-form label-position="top">
        <el-row :gutter="20">
            <el-col :xs="24" :lg="14" :xl="16">
                <el-card header="Основное">
                    <form-item label="Название" :errors="errors['title']">
                        <el-input v-model="element.title"/>
                    </form-item>
                    <form-item label="Описание" :errors="errors['description']">
                        <v-editor v-model="element.description"/>
                    </form-item>
                </el-card>
            </el-col>
            <el-col :xs="24" :lg="10" :xl="8">
                <el-card header="Изображение" class="mb-3" body-class="p-1">
                    <v-upload-image group="preview"
                                    :model_id="element.id"
                                    :model_type="model"
                                    v-model="element.image"/>
                </el-card>
                <el-card header="Пропсы" v-if="infoBlock.data.props">
                    <template v-for="(prop,index) in element.props">
                        <form-item :label="prop.name" :errors="errors[prop.key]">
                            <el-input v-if="prop.type === 'input'" v-model="element.props[index].value"/>
                            <el-input v-if="prop.type === 'textarea'" type="textarea"
                                      v-model="element.props[index].value"/>
                            <el-input v-if="prop.type === 'checkbox'" type="textarea"
                                      v-model="element.props[index].value"/>
                        </form-item>
                    </template>
                </el-card>
            </el-col>
        </el-row>
        <el-button @click="save" type="primary" :loading="loading">Сохранить</el-button>
    </el-form>
</template>

<script>
import MainLayout from "../../../../Layouts/MainLayout.vue";
import {router} from '@inertiajs/vue3'
import HandleErrorsMixin from "../../../../Shared/Mixins/HandleErrorsMixin";
import FormItem from "../../../../components/UI/Form/FormItem.vue";
import VUploadImage from "../../../../components/UI/Form/VUploadImage.vue";
import {ElNotification} from "element-plus";
import VEditor from "../../../../components/UI/Form/VEditor.vue";

export default {
    name: "Edit",
    layout: MainLayout,
    mixins: [HandleErrorsMixin],
    components: {
        VEditor,
        VUploadImage,
        FormItem,
    },
    props: {
        infoBlockElement: null,
        infoBlock: {
            type: Object,
            required: true,
        },
        model: null,
    },
    data() {
        return {
            element: {
                title: null,
                description: null,
                image: null,
                props: [],
            },
            loading: false,
        }
    },
    mounted() {
        if (this.infoBlockElement) {
            this.element.id = this.infoBlockElement.data.id
            this.element.title = this.infoBlockElement.data.title
            this.element.description = this.infoBlockElement.data.description
            this.element.image = this.infoBlockElement.data.image
        }
        this.getProps()
    },
    methods: {
        getProps() {
            if (this.infoBlock.data.props) {
                this.infoBlock.data.props.forEach((element) => {
                    element.value = this.infoBlockElement?.data.props ? this.infoBlockElement.data.props[element.key] : ''
                    this.element.props.push(element)
                })
            }
        },
        async getPropsForSave() {
            let props = {};
            this.element.props.forEach((element) => {
                props[element['key']] = element['value'];
            })
            return props;
        },
        save() {
            this.loading = true
            this.errors = []
            this.getPropsForSave().then((props) => {
                if (this.infoBlockElement) {
                    this.update(props).finally(() => {
                        this.loading = false
                    })
                } else {
                    this.store(props).finally(() => {
                        this.loading = false
                    })
                }
            })
        },
        async update(props) {
            await axios.patch(route('admin.iblock.element.update', this.infoBlockElement.data.id), {
                title: this.element.title,
                description: this.element.description,
                props: props,
            }).then((response) => {
                ElNotification.success({message: 'Данные сохранены', position: 'bottom-right'})
            }).catch((errors) => {
                this.handleErrors(errors)
            })

        },
        async store(props) {
            await axios.post(route('admin.iblock.element.store', this.infoBlock.data.id), {
                title: this.element.title,
                description: this.element.description,
                props: props,
            }).then((response) => {
                if (response.data.data?.id) {
                    router.visit(route('admin.iblock.element.edit', response.data.data.id))
                }
            }).catch((errors) => {
                this.handleErrors(errors)
            })
        },
    }
}
</script>

<style scoped>

</style>
