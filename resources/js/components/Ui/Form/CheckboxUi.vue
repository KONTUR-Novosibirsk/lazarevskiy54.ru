<template>
    <div class="">
        <div class="form-check">
            <div class="form-check-content">
                <input
                    type="checkbox"
                    :id="forName"
                    class="hidden-checkbox"
                    :checked="modelValue"
                    @change="updateInput"
                />
                <label :for="forName" class="custom-checkbox">
                  <span class="checkbox-box">
                    <span v-if="modelValue" class="checkbox-checkmark">
                        <svg width="11" height="8" viewBox="0 0 11 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.39364 1.0603L3.83808 6.89364L1.0603 3.97697M9.39351 1.0603L3.83796 6.89364" stroke="#3C464B" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="round"/>
                        </svg>
                    </span>
                  </span>
                    <span class="checkbox-label" v-html="label"></span>
                </label>
            </div>

            <div v-if="errors?.length" class="invalid-feedback">
                <div v-for="(error, i) in errors" :key="i">{{ error }}</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CheckboxUi",
    props: {
        label: String,
        name: String,
        modelValue: Boolean,
        errors: {
            type: Array,
            default: null,
        },
    },
    computed: {
        forName() {
            return 'checkbox_' + this.name;
        }
    },
    methods: {
        updateInput(event) {
            this.$emit('update:modelValue', event.target.checked);
        }
    }
};
</script>

<style>
.hidden-checkbox {
    position: absolute;
    opacity: 0;
    width: 20px;
    height: 20px;
    cursor: pointer;
}

.form-check-content {
    position: relative;
}

.custom-checkbox {
    display: flex !important;
    align-items: center;
    cursor: pointer;
    user-select: none;
}

.checkbox-box {
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    flex-shrink: 0;
    justify-content: center;
    margin-right: 12px;
    border-radius: 5px;
    background-color: white;
    border: 1px solid #FFD900;
    transition: background 0.2s, border-color 0.2s;
}

.checkbox-checkmark {
    font-size: 14px;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    background: #FFD900;
    height: 100%;
}

.checkbox-label {
    font-size: 14px;
    color: #202020;
    line-height: 140%;

    a {
        color: #202020 !important;
        text-decoration: underline !important;
    }
}

.invalid-feedback {
    color: red;
    font-size: 0.875em;
    margin-top: 4px;
}
</style>
