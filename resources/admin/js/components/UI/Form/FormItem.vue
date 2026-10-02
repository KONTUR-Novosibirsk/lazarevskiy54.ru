<script>
export default {
    name: "FormItem",
    props: {
        label: {
            type: String,
            default: null,
        },
        errors: [],
        showMessage: {
            type: Boolean,
            default: true,
        }
    },
    computed: {
        validateStatus() {
            return (this.errors || []).length > 0 ? 'error' : ''
        }
    }
}
</script>

<template>
    <el-form-item :label="label" :validate-status="validateStatus" :show-message="showMessage">
        <slot/>
        <template #error>
            <transition name="el-zoom-in-top">
                <div class="errors" v-show="errors">
                    <div v-for="error in errors" class="text-sm text-red-600 dark:text-red-500">{{ error }}</div>
                </div>
            </transition>
        </template>
    </el-form-item>
</template>

