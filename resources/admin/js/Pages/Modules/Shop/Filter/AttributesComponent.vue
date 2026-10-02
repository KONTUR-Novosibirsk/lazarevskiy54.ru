<template>
    <el-button type="primary" @click="addAttribute" class="mb-3">Добавить</el-button>
    <draggable class=""
               v-model="attributesData"
               group="people"
               handle=".handle"
               :options="{animation:1300}"
               item-key="id">
        <template #item="{attribute, index}">
            <el-form>
                <el-row :gutter="5">
                    <el-col :span="1">
                        <el-button class="handle cursor-pointer w-full">
                            <i class="bi bi-arrows-vertical"></i>
                        </el-button>
                    </el-col>
                    <el-col :span="6">
                        <form-item :errors="errors['attributes.' + index + '.name']" :show-message="false">
                            <el-input v-model="attributesData[index].name"/>
                        </form-item>
                    </el-col>
                    <el-col :span="6">
                        <form-item>
                            <el-select v-model="attributesData[index].attribute_id"
                                       @change="resetValue(index)" filterable>
                                <el-option v-for="attribute in attributesFor" :value="attribute.key"
                                           :label="attribute.value"/>
                            </el-select>
                        </form-item>
                    </el-col>
                    <el-col :span="6">
                        <form-item>
                            <el-select v-model="attributesData[index].type"
                                       @change="resetValue(index)" filterable>
                                <el-option value="select" label="Select"/>
                                <el-option value="multi_select" label="Multi select"/>
                                <el-option value="button" label="Buttons"/>
                                <el-option value="checkbox" label="Checkboxes"/>
                            </el-select>
                        </form-item>
                    </el-col>
                    <el-col :span="5">
                        <el-button type="danger" @click="deleteAttribute(index)">Удалить</el-button>
                    </el-col>
                </el-row>
            </el-form>
        </template>
    </draggable>
</template>
<script>
import {reactive} from "vue";
import draggable from "vuedraggable";
import FormItem from "../../../../components/UI/Form/FormItem.vue";

export default {
    name: "AttributesComponent",
    components: {FormItem, draggable},
    props: {
        attributes: Object,
        modelValue: Array,
        errors: {},
    },
    data() {
        return {
            attributesData: this.modelValue,
        }
    },
    updated() {
        this.attributesData = this.modelValue
    },
    watch: {
        attributesData: {
            deep: true,
            handler(newValue, oldValue) {
                this.$emit('update:modelValue', this.attributesData)
            },
        }
    },
    methods: {
        resetValue(index) {
            this.attributesData[index].value = null
        },
        deleteAttribute(index) {
            this.attributesData.splice(index, 1)
        },
        async addAttribute() {
            let checkNull = async () => {
                if (this.attributesData === null) {
                    this.attributesData = reactive([])
                }
            }
            checkNull().then(() => {
                this.attributesData.push({
                    attribute_id: null,
                    value: null,
                    type: null,
                })
            })

        },
        getAttribute(attribute_id) {
            for (let index in this.attributes.data) {
                if (this.attributes.data[index].id === attribute_id) {
                    return this.attributes.data[index]
                }
            }
        },
        getDictionary(attribute_id) {
            for (let index in this.attributes.data) {
                if (this.attributes.data[index].id === attribute_id) {
                    let data = []
                    for (let item in this.attributes.data[index].dictionary) {
                        data.push({
                            key: this.attributes.data[index].dictionary[item].value,
                            value: this.attributes.data[index].dictionary[item].value
                        })
                    }
                    return data
                }
            }
            return null
        },

    },
    computed: {
        attributesFor() {
            let attributes = []
            if (this.attributes) {
                for (let item in this.attributes.data) {
                    attributes.push({key: this.attributes.data[item].id, value: this.attributes.data[item].name})
                }
            }
            return attributes
        }
    }
}
</script>

<style scoped>

</style>
