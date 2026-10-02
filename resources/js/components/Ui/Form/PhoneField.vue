<template>
    <div class="form-mb" :class="{ shake: errors }">
        <label class="form-label">{{ label }}:</label>
        <input type="text" :class="{ 'is-invalid': errors }"
               v-maska data-maska="+7 (###) ###-##-##"
               :placeholder="placeholder"
               class="form-control" :name="name" :value="modelValue"
               @input="updateInput">
        <div v-for="error in errors" class="invalid-feedback">
            {{ error }}
        </div>
    </div>
</template>

<script>
import {vMaska} from "maska"

export default {
    name: "PhoneFiled",
    directives: {maska: vMaska},
    props: {
        placeholder: null,
        label: {
            type: String,
            default: 'text',
        },
        name: String,
        modelValue: [String, Number],
        errors: {
            type: Array,
            default: null,
        }
    },
    methods: {
        updateInput(event) {
            this.$emit('update:modelValue', event.target.value);
        }
    }
}
</script>

<style scoped>

</style>
