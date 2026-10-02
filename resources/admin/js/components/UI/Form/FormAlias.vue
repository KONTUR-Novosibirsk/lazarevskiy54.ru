<template>
    <el-input :model-value="modelValue" @input="updateInput" clearable>
        <template #append>
            <el-button @click="updateAlias">
                <Icon icon="material-symbols:refresh-rounded" size="25"/>
            </el-button>
        </template>
    </el-input>
</template>

<script>
import Translit from "../../../helpers/Translit";

export default {
    name: "FormAlias",
    props: {
        modelValue: [String, Number],
        title: null,
        inRealTime: false,
        errors: {
            type: Array,
            default: null,
        }
    },
    watch: {
        title(newTitle, oldTitle) {
            if (this.inRealTime && newTitle) {
                this.$emit('update:modelValue', Translit.translit(newTitle));
            }
        }
    },
    methods: {
        updateInput(value) {
            this.$emit('update:modelValue', value);
        },
        updateAlias() {
            this.$emit('update:modelValue', Translit.translit(this.title));
        }
    }
}
</script>

<style scoped>

</style>
