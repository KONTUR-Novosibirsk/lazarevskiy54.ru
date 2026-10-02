<template>
    <div class="form-mb" :class="{ shake: errors }">
        <label class="form-label">{{ label }}:</label>
        <input :type="type" :class="{ 'is-invalid': errors }" class="form-control" :name="name"
               :placeholder="placeholder" :value="modelValue" @input="updateInput">
        <div v-for="error in errors" class="invalid-feedback">
            {{ error }}
        </div>
    </div>
</template>

<script>
export default {
    name: "InputField",
    props: {
        placeholder: null,
        type: {
            type: String,
            default: 'text',
        },
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
