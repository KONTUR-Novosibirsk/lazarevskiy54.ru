<template>
    <el-button type="primary" :size="size" @click="modal = true" class="ms-1">{{ buttonName }}</el-button>
    <el-dialog v-model="modal" :append-to-body="true" width="80%">
        <el-form label-position="top">
            <el-row :gutter="20" class="m-2">
                <el-col :xs="24" :lg="12">
                    <el-card>
                        <form-item label="Название" :errors="errors['title']">
                            <el-input v-model="infoBlock.title"/>
                        </form-item>
                        <form-item label="Категория" :errors="errors['category_id']">
                            <el-select v-model="infoBlock.category_id" clearable filterable>
                                <el-option v-for="cat in categories" :value="cat.id" :label="cat.name"/>
                            </el-select>
                        </form-item>
                        <form-item label="Описание" :errors="errors['description']">
                            <v-editor v-model="infoBlock.description"/>
                        </form-item>
                    </el-card>

                </el-col>
                <el-col :xs="24" :lg="12">
                    <el-card>
                        <template #header>
                            <div class="flex justify-between">
                                <h6 class="text-base m-1 my-auto">Пропсы</h6>
                                <el-button @click="createProp" type="primary" size="small" class="my-auto">Добавить
                                </el-button>
                            </div>
                        </template>
                        <el-scrollbar height="500px" :always="true">
                            <el-row :gutter="5" class="w-full" v-for="(item, index) in infoBlock.props" :key="index">
                                <el-col :span="7">
                                    <form-item :errors="errors['props.' + index + '.key']" :show-message="false">
                                        <el-input v-model="infoBlock.props[index].key" placeholder="Ключ"/>
                                    </form-item>
                                </el-col>
                                <el-col :span="7">
                                    <form-item :errors="errors['props.' + index + '.name']" :show-message="false">
                                        <el-input v-model="infoBlock.props[index].name" placeholder="Название"/>
                                    </form-item>
                                </el-col>
                                <el-col :span="7">
                                    <form-item :errors="errors['props.' + index + '.type']" :show-message="false">
                                        <el-select v-model="infoBlock.props[index].type" placeholder="Тип">
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
                    </el-card>

                </el-col>
            </el-row>
            <el-button type="primary" @click="save" :loading="loading">Сохранить</el-button>
        </el-form>
    </el-dialog>
</template>

<script>
import {useIBlockStore} from "../../../stores/iblock";
import HandleErrorsMixin from "../../../Shared/Mixins/HandleErrorsMixin";
import FormItem from "../../../components/UI/Form/FormItem.vue";
import VEditor from "../../../components/UI/Form/VEditor.vue";
import {ElNotification} from "element-plus";

export default {
    name: "Edit",
    mixins: [HandleErrorsMixin],
    components: {VEditor, FormItem},
    props: {
        index: null,
        iBlock: null,
        size: {
            type: String,
            default: 'default',
        },
        buttonName: {
            type: String,
            required: true,
        },
        category: null,
        categories: null,
    },
    data() {
        return {
            iBlocksStore: useIBlockStore(),
            infoBlock: {
                title: '',
                description: '',
                category_id: null,
                props: [],
            },
            simpleProp: {
                key: '',
                name: '',
                type: 'input',
            },
            loading: false,
            saved: false,
            modal: false,
        }
    },
    mounted() {
        if (this.iBlock) {
            this.infoBlock.id = this.iBlock.id
            this.infoBlock.title = this.iBlock.title
            this.infoBlock.description = this.iBlock.description
            this.infoBlock.category_id = this.iBlock.category_id
            this.infoBlock.props = this.iBlock.props ?? []
        }
        if (this.category) {
            this.infoBlock.category_id = this.category.id
        }
    },
    methods: {
        createProp() {
            let clone = Object.assign({}, this.simpleProp);
            this.infoBlock.props[this.infoBlock.props.length] = clone
        },
        deleteProp(index) {
            this.infoBlock.props.splice(index, 1)
        },
        save() {
            this.loading = true
            this.errors = []
            if (this.iBlock) {
                this.update().finally(() => {
                    this.loading = false
                })
            } else {
                this.store().finally(() => {
                    this.loading = false
                })
            }
        },
        async update() {
            await axios.patch('/admin/iblock/update/' + this.infoBlock.id, {
                title: this.infoBlock.title,
                description: this.infoBlock.description,
                category_id: this.infoBlock.category_id,
                props: this.infoBlock.props,
            }).then((response) => {
                this.iBlocksStore.update(this.index, response.data.data)
                ElNotification.success({message: 'Данные сохранены', position: 'bottom-right'})
            }).catch((errors) => {
                this.handleErrors(errors)
            })

        },
        async store() {
            await axios.post('/admin/iblock/store', {
                title: this.infoBlock.title,
                description: this.infoBlock.description,
                category_id: this.infoBlock.category_id,
                props: this.infoBlock.props,
            }).then((response) => {
                if (response.status == 201 && response.data['data']) {
                    this.infoBlock.title = ''
                    this.infoBlock.description = ''
                    this.infoBlock.props = []
                    this.modal = false
                    this.iBlocksStore.add(response.data.data)
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
