<template>
    <el-button type="primary" :size="size" @click="modal = true">{{ buttonName }}</el-button>
    <el-dialog :title="buttonName" :append-to-body="true" v-model="modal">
        <el-form label-position="top">
            <el-row :gutter="20">
                <el-col :span="largeSize ? 12:24">
                    <form-item label="Название" :errors="errors['name']">
                        <el-input v-model="attributeData.name"/>
                    </form-item>
                    <form-item label="Тип" :errors="errors['type']">
                        <el-select v-model="attributeData.type">
                            <el-option value="input" label="Строка"/>
                            <el-option value="select" label="Выпадающий список"/>
                            <el-option value="multi_select" label="Множественный выбор"/>
                        </el-select>
                    </form-item>
                </el-col>
                <el-col v-if="largeSize" :span="12">
                    <div class="flex justify-between mb-2">
                        <h6 class="text-base m-1 my-auto">Словарь:</h6>
                        <el-button @click="addWord" type="primary" size="small" class="my-auto">Добавить</el-button>
                    </div>
                    <el-row v-for="(word, index) in attributeData.dictionary" :gutter="5">
                        <el-col :span="19">
                            <form-item :errors="errors['dictionary.' + index + '.value']">
                                <el-input size="small" v-model="attributeData.dictionary[index].value" clearable/>
                            </form-item>
                        </el-col>
                        <el-col :span="5">
                            <el-button class="w-full" size="small" type="danger" @click="deleteWord(index)">Удалить</el-button>
                        </el-col>
                    </el-row>
                </el-col>
            </el-row>
            <el-button type="primary" @click="save" :loading="loading">Сохранить</el-button>
        </el-form>
    </el-dialog>
</template>

<script>
import {router} from "@inertiajs/vue3";
import HandleErrorsMixin from "../../../../Shared/Mixins/HandleErrorsMixin";
import FormItem from "../../../../components/UI/Form/FormItem.vue";
import {ElNotification} from "element-plus";

export default {
    name: "FormModal",
    components: {FormItem},
    mixins: [HandleErrorsMixin],
    props: {
        attribute: null,
        size: {
            type: String,
            default: 'default',
        }
    },
    data() {
        return {
            modal: false,
            loading: false,
            attributeData: {
                name: '',
                type: 'input',
                dictionary: [],
            },
            types: [
                {key: 'input', value: 'Строка'},
                {key: 'select', value: 'Выпадающий список'},
                {key: 'multi_select', value: 'Множественный выбор'},
            ]
        }
    },
    mounted() {
        if (this.attribute) {
            this.attributeData = {...this.attribute}
        }
    },
    computed: {
        buttonName() {
            return this.attribute ? 'Изменить' : 'Создать'
        },
        largeSize() {
            return this.attributeData.type === 'select' || this.attributeData.type === 'multi_select';
        }
    },
    methods: {
        addWord() {
            if (this.attributeData.dictionary === null) this.attributeData.dictionary = []
            this.attributeData.dictionary.push({
                value: ''
            })
        },
        deleteWord(index) {
            this.attributeData.dictionary.splice(index, 1)
        },
        save() {
            this.loading = true
            if (this.attribute) {
                this.update()
            } else {
                this.store()
            }
        },
        store() {
            axios.post(route('admin.shop.attribute.store'), this.attributeData).then(() => {
                ElNotification.success({message: 'Атрибут добавлен', position: 'bottom-right'})
                this.modal = false
                router.get(route('admin.shop.attribute.index'));
            }).catch((errors) => {
                this.handleErrors(errors)
            }).finally(() => {
                this.loading = false
            })
        },
        update() {
            axios.patch(route('admin.shop.attribute.update', this.attribute.id), this.attributeData).then(() => {
                ElNotification.success({message: 'Изменения сохранены', position: 'bottom-right'})
                this.modal = false
                router.get(this.$page.props.ziggy.location)
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
