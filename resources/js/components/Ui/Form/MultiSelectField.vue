<template>
    <div class="select" v-click-outside="hideOptions">
        <div class="filter-label">{{ label }}</div>
        <div class="select-item">
            <div class="select-head" @click="showOptions">
                <div v-if="selectedItems">
                     <span class="selected__item" v-for="selectItem in selectedItems">
                    {{ selectItem.value }}
                    </span>
                </div>
                <template v-else>
                    Ничего не выбрано
                </template>
            </div>
            <ul class="select-body" v-show="show">
                <li class="select-option"
                    v-for="item in filteredData"
                    :class="{selected: selected(item)}"
                    @click="select(item)">{{ item.value }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: "MultiSelectField",
    props: {
        label: null,
        required: {
            type: Boolean,
            default: false,
        },
        name: String,
        modelValue: [Array],
        data: Object,
        errors: {
            type: Array,
            default: null,
        }
    },
    watch: {
        modelValue() {
            if (typeof this.modelValue === 'string') {
                this.$emit('update:modelValue', null);
            }
        }
    },
    data() {
        return {
            defaultSelected: {
                key: 0, value: 'Не выбрано',
            },
            search: '',
            show: false,
        }
    },
    computed: {
        selectedItems() {
            let selected = []
            if (this.modelValue) {
                if (this.modelValue.length === 0) {
                    return null
                }
                for (let item in this.data) {
                    if (this.modelValue.includes(this.data[item].key)) {
                        selected.push(this.data[item])
                    }
                }
                return selected
            }
            return null

        },
        filteredData() {
            return this.data.filter((element) => {
                return element.value.toLowerCase().indexOf(this.search) > -1;
            });
        }
    },
    methods: {
        selected(item) {
            if (this.modelValue) {
                return this.modelValue.includes(item.key)
            }
            return false
        },
        showOptions() {
            this.show = !this.show;
        },
        hideOptions() {
            this.show = false
        },
        async select(item) {
            let modelValue
            if (this.modelValue) {
                modelValue = this.modelValue
            } else {
                modelValue = []
            }
            for (let itemValue in modelValue) {
                if (modelValue[itemValue] === item.key) {
                    modelValue.splice(itemValue, 1)
                    if (modelValue.length === 0) {
                        modelValue = null
                    }
                    this.$emit('update:modelValue', modelValue);
                    this.$emit('change');
                    return true
                }
            }
            modelValue.push(item.key)
            this.$emit('update:modelValue', modelValue);
            this.$emit('change');
        }
    }
}
</script>

<style scoped>

</style>
