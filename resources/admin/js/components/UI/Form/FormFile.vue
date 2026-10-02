<script>
export default {
    name: "FormFile",
    props: {
        label: null,
        modelValue: [String, Number, File],
        errors: [],
    },
    data() {
        return {
            imageData: null,
            file: null,
        }
    },
    mounted() {
        this.imageData = this.modelValue
        this.file = this.$refs.file
    },
    computed: {
        style() {
            return this.type === 'color' ? 'form-control-color' : '';
        }
    },
    methods: {
        updateFile(event) {
            this.imageData = URL.createObjectURL(event.target.files[0])
            this.$emit('update:modelValue', event.target.files[0]);
        }
    }
}
</script>

<template>
    <div class="flex">
        <div class="input-file rounded-s-lg bg-gray-50 dark:bg-neutral-600 px-5 flex">
            <el-image style="height: 30px; width: 30px; object-fit: cover;" class="my-auto" :src="imageData"
                      fit="cover"/>
        </div>

        <input @change="updateFile"
               class="input-file border-gray-300 rounded-e-lg bg-gray-50 dark:bg-neutral-500 p-3"
               placeholder="Please input"
               type="file">
    </div>
</template>
<style scoped>
.input-file {
    border: 1px solid var(--el-border-color);
    background-color: var(--el-fill-color-blank);
}
</style>
