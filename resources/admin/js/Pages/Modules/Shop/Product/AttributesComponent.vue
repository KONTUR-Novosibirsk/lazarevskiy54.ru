<template>
    <el-button type="primary" @click="addAttribute" class="mb-3">Добавить</el-button>
    <el-form>
        <el-row v-for="(attribute, index) in attributesData" :gutter="4">
            <el-col :span="10">
                <form-item>
                    <el-select v-model="attributesData[index].attribute_id" @change="resetValue(index)">
                        <el-option v-for="attribute in attributesFor"
                                   :value="attribute.key" :label="attribute.value" />
                    </el-select>
                </form-item>
            </el-col>
            <el-col :span="10">
                <form-item :show-message="false" :errors="errors['attributes_for_edit.' + index + '.value']">
                <template v-if="getAttribute(attributesData[index].attribute_id)?.type === 'input'">
                    <el-input v-model="attributesData[index].value" clearable/>
                </template>
                <template v-else-if="getAttribute(attributesData[index].attribute_id)?.type === 'select'">
                    <el-select v-model="attributesData[index].value" filterable clearable>
                        <el-option v-for="item in getDictionary(attributesData[index].attribute_id)"
                                   :value="item.key"
                                   :label="item.value"/>
                    </el-select>
                </template>
                <template v-else-if="getAttribute(attributesData[index].attribute_id)?.type === 'multi_select'">
                    <el-select v-model="attributesData[index].value" multiple filterable clearable>
                        <el-option v-for="item in getDictionary(attributesData[index].attribute_id)"
                                   :value="item.key"
                                   :label="item.value"/>
                    </el-select>
                </template>
                </form-item>
            </el-col>
            <el-col :span="4">
                <el-button type="danger" @click="deleteAttribute(index)">Удалить</el-button>
            </el-col>
        </el-row>
    </el-form>
</template>
<script>
import {reactive} from "vue";
import FormItem from "../../../../components/UI/Form/FormItem.vue";

export default {
    name: "AttributesComponent",
    components: {FormItem},
    props: {
        attributes: Object,
        modelValue: Array,
        errors: Array,
    },
    data() {
        return {
            attributesData: this.modelValue
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
