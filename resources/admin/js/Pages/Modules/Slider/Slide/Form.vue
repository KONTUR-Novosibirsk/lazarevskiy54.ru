<template>
    <el-form label-position="top">
        <el-row :gutter="20">
            <el-col :xs="24" :lg="16">
                <el-card header="Основное" class="mb-2">
                    <form-item label="Заголовок" :errors="errors['title']">
                        <el-input v-model="slideData.title"/>
                    </form-item>
                    <form-item label="Ссылка" :errors="errors['link']">
                        <el-input v-model="slideData.link"/>
                    </form-item>
                    <form-item label="Описание" :errors="errors['description']">
                        <v-editor v-model="slideData.description"/>
                    </form-item>
                    <template #footer>
                        <el-button @click="save" :loading="loading" type="primary">Сохранить</el-button>
                    </template>
                </el-card>
            </el-col>
            <el-col :xs="24" :lg="8">
                <el-card class="mb-3" body-class="p-2" header="Изображение">
                    <v-upload-image
                        :model_id="slideData.id"
                        :model_type="model"
                        group="preview"
                        v-model="slideData.image"
                    />
                </el-card>
                <el-card class="mb-3" header="Сортировка">
                    <form-item label="Порядок сортировки" :errors="errors['sort']">
                        <el-input-number v-model="slideData.sort">
                        </el-input-number>
                    </form-item>
                </el-card>
                <el-card v-if="this.slider.data.props" class="mb-3" header="Пропсы">
                    <template v-for="(prop,index) in slideData.props">
                        <form-item v-if="prop.type === 'input'" :label="prop.name" :errors="errors[prop.key]">
                            <el-input v-model="slideData.props[index].value" :clearable="true"/>
                        </form-item>
                        <form-item v-else-if="prop.type === 'textarea'" :label="prop.name" :errors="errors[prop.key]">
                            <el-input v-model="slideData.props[index].value" :clearable="true" type="textarea"/>
                        </form-item>
                    </template>
                </el-card>
            </el-col>
        </el-row>
    </el-form>
</template>

<script>
import MainLayout from "../../../../Layouts/MainLayout.vue";
import {router} from "@inertiajs/vue3";
import HandleErrorsMixin from "../../../../Shared/Mixins/HandleErrorsMixin";
import FormItem from "../../../../components/UI/Form/FormItem.vue";
import VEditor from "../../../../components/UI/Form/VEditor.vue";
import VUploadImage from "../../../../components/UI/Form/VUploadImage.vue";
import {ElNotification} from "element-plus";

export default {
    name: "Form",
    layout: MainLayout,
    mixins: [HandleErrorsMixin],
    components: {VUploadImage, VEditor, FormItem},
    props: {
        slider: null,
        slide: null,
        model: null,
        preview: null,
    },
    data() {
        return {
            loading: false,
            slideData: {
                title: '',
                link: '',
                description: '',
                image: null,
                props: [],
                sort: 0
            }
        }
    },
    mounted() {
        if (this.slide) {
            this.slideData.id = this.slide.data.id
            this.slideData.title = this.slide.data.title
            this.slideData.link = this.slide.data.link
            this.slideData.image = this.slide.data.image
            this.slideData.description = this.slide.data.description
            if (this.slide.data.sort) this.slideData.sort = this.slide.data.sort
        }
        if(this.preview)
            this.slideData.image = this.preview.data;
        this.getProps()
    },
    methods: {
        getProps() {
            if (this.slider.data.props) {
                this.slider.data.props.forEach((element) => {
                    element.value = this.slide?.data.props ? this.slide.data.props[element.key] : ''
                    this.slideData.props.push(element)
                })
            }
        },
        async getPropsForSave() {
            let props = {};
            this.slideData.props.forEach((element) => {
                props[element['key']] = element['value'];
            })
            return props;
        },
        save() {
            this.loading = true
            this.errors = []
            this.getPropsForSave().then((props) => {
                if (this.slide) {
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
        async store(props) {
            await axios.post(route('admin.slide.store', this.slider.data.id), {
                title: this.slideData.title,
                description: this.slideData.description,
                link: this.slideData.link,
                props: props,
                sort: this.slideData.sort
            }).then((response) => {
                ElNotification({
                    title: 'Система',
                    message: 'Слайд добавлен',
                    type: 'success',
                    position: 'bottom-right',
                })
                router.get(route('admin.slide.edit', response.data.data.id))
            }).catch((errors) => {
                this.handleErrors(errors)
            })
        },
        async update(props) {
            await axios.patch(route('admin.slide.update', this.slideData.id), {
                title: this.slideData.title,
                description: this.slideData.description,
                link: this.slideData.link,
                props: props,
                sort: this.slideData.sort
            }).then((response) => {
                ElNotification({
                    title: 'Система',
                    message: 'Данные обновлены',
                    type: 'success',
                    position: 'bottom-right',
                })
            }).catch((errors) => {
                this.handleErrors(errors)
            })
        }
    },
}
</script>
