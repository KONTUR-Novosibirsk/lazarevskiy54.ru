<template>
    <el-button type="primary" :size="size" @click="modal = true">{{ buttonName }}</el-button>
    <el-dialog v-model="modal" :title="buttonName" :append-to-body="true" width="80%">
        <el-form label-position="top">
            <el-row :gutter="20">
                <el-col :xs="24" :lg="12" :xl="14">
                    <form-item label="Название" :errors="errors['name']">
                        <el-input v-model="sliderData.name" :clearable="true"/>
                    </form-item>
                    <form-item label="Код" :errors="errors['code']">
                        <el-input v-model="sliderData.code" :clearable="true"/>
                    </form-item>
                    <form-item label="Описание" :errors="errors['description']">
                        <v-editor v-model="sliderData.description"/>
                    </form-item>
                </el-col>
                <el-col :xs="24" :lg="12" :xl="10">
                    <div class="flex justify-between mb-6">
                        <h6 class="text-base m-1 my-auto">Пропсы</h6>
                        <el-button @click="createProp" type="primary" size="small" class="my-auto">Добавить</el-button>
                    </div>
                    <el-scrollbar height="500px" :always="true">
                        <el-row gutter="5" class="w-full" v-for="(item, index) in sliderData.props" :key="index">
                            <el-col :span="7">
                                <form-item :errors="errors['props.' + index + '.key']" :show-message="false">
                                    <el-input v-model="sliderData.props[index].key" placeholder="Ключ"/>
                                </form-item>
                            </el-col>
                            <el-col :span="7">
                                <form-item :errors="errors['props.' + index + '.name']" :show-message="false">
                                    <el-input v-model="sliderData.props[index].name" placeholder="Название"/>
                                </form-item>
                            </el-col>
                            <el-col :span="7">
                                <form-item :errors="errors['props.' + index + '.type']" :show-message="false">
                                    <el-select v-model="sliderData.props[index].type" placeholder="Тип">
                                        <el-option label="Строка" value="input" selected/>
                                        <el-option label="Многострочное поле" value="textarea"/>
                                        <el-option label="Boolean" value="checkbox"/>
                                    </el-select>
                                </form-item>
                            </el-col>
                            <el-col :span="3">
                                <el-button class="w-10/12" @click="deleteProp(index)" type="danger"><i
                                    class="bi bi-trash-fill"></i>
                                </el-button>
                            </el-col>
                        </el-row>
                    </el-scrollbar>
                </el-col>
            </el-row>
            <el-button @click="save" type="primary" :loading="loading">Сохранить</el-button>
        </el-form>
    </el-dialog>
</template>

<script>
import {router} from "@inertiajs/vue3";
import HandleErrorsMixin from "../../../../Shared/Mixins/HandleErrorsMixin";
import FormItem from "../../../../components/UI/Form/FormItem.vue";
import VEditor from "../../../../components/UI/Form/VEditor.vue";
import {ElNotification} from "element-plus";

export default {
    name: "SliderFormComponent",
    mixins: [HandleErrorsMixin],
    components: {VEditor, FormItem},
    props: {
        slider: null,
        index: null,
        size: {
            type: String,
            default: 'default',
        }
    },
    data() {
        return {
            modal: false,
            loading: false,
            sliderData: {
                name: '',
                code: '',
                description: '',
                props: null,
            }
        }
    },
    mounted() {
        if (this.slider) {
            this.sliderData = {...this.slider}
        }
        if (!this.sliderData.props) this.sliderData.props = []
    },
    computed: {
        buttonName() {
            return this.slider ? 'Изменить' : 'Добавить'
        }
    },
    methods: {
        createProp() {
            this.sliderData.props.push({
                key: '',
                name: '',
                type: 'input',
            })
        },
        deleteProp(index) {
            this.sliderData.props.splice(index, 1)
        },
        save() {
            this.loading = true
            this.errors = []
            if (this.slider) {
                this.update()
            } else {
                this.store()
            }
        },
        store() {
            axios.post(route('admin.slider.store'), this.sliderData).then((response) => {
                ElNotification({
                    title: 'Система',
                    message: 'Слайдер создан',
                    type: 'success',
                    position: 'bottom-right',
                })
                this.modal = false
                router.get(route('admin.slider.index'))
            }).catch((errors) => {
                this.handleErrors(errors)
            }).finally(() => {
                this.loading = false
            })
        },
        update() {
            axios.patch(route('admin.slider.update', this.slider.id), this.sliderData).then((response) => {
                ElNotification({
                    title: 'Система',
                    message: 'Данные обновлены',
                    type: 'success',
                    position: 'bottom-right',
                })
                this.$emit('update', this.index, {...response.data.data})
            }).catch((errors) => {
                this.handleErrors(errors)
            }).finally(() => {
                this.loading = false
            })
        }
    }
}
</script>
