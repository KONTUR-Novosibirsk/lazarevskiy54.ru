<template>
    <form action="#">
        <div class="products-filter__item">
            <div class="products-filter__name">
                <div class="products-filter__text">Цена</div>
                <div class="products-filter__arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                         viewBox="0 0 20 20" fill="none">
                        <path d="M15.8346 7.4987L10.0013 13.332L4.16797 7.4987" stroke="#374151"
                              stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
            <div class="products-filter__content">
                <div class="filter-inpt">
                    <div id="slider-price"></div>
                    <div class="slider-price-inputs">
                        <div class="slider-price-inputs-item">
                            <input class="price-inputs-start" v-model="price.min" type="number" name="price-start">
                        </div>
                        <div class="slider-price-inputs-item">
                            <input class="price-inputs-end" v-model="price.max" type="number" name="price-end">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="products-filter__item" v-if="filterableAttributes" v-for="attribute in filterableAttributes">
            <div class="products-filter__content" v-if="attribute.data.length > 0">
                <MultiSelectField v-if="attribute.type == 'multi_select'" :data="attribute.data"
                                  v-model="filter[attribute.attribute_id]"
                                  :label="attribute.name"/>
                <ButtonsGroupField v-if="attribute.type == 'button'" :data="attribute.data"
                                   v-model="filter[attribute.attribute_id]"
                                   :label="attribute.name"/>
                <CheckboxGroupField v-if="attribute.type == 'checkbox'" :data="attribute.data"
                                   v-model="filter[attribute.attribute_id]"
                                   :label="attribute.name"/>
            </div>
        </div>
        <div class="products-filter__btns">
            <button type="reset" @click="resetFilter">Сбросить</button>
            <button type="button" @click="filterData">Применить</button>
        </div>
    </form>
</template>

<script>
import {useProductFilterStore} from "../../Stores/filter";
import {productFilterOnMount} from "../../Shop/ProductFilterOnMount";
import MultiSelectField from "../Ui/Form/MultiSelectField.vue";
import ButtonsGroupField from "../Ui/Form/ButtonsGroupField.vue";
import CheckboxGroupField from "../Ui/Form/CheckboxGroupField.vue";

export default {
    name: "ProductFilterComponent",
    components: {CheckboxGroupField, ButtonsGroupField, MultiSelectField},
    props: {
        data: null,
        url: null,
        filterableAttributes: {},
    },
    data() {
        return {
            price: {
                min: 0,
                max: 999999,
            },
            filter: [],
        }
    },
    mounted() {
        productFilterOnMount()
        if (this.data['price']) {
            this.price = this.data['price']
        }
        if (this.data['filterData']) {
            this.filter = this.data['filterData']
        }
    },
    methods: {
        filterData() {
            useProductFilterStore().setFilterData(this.filter, this.price)
        },
        changeFilterData(event, attributeId, value) {
            let isChecked = event.target.checked
            if (!!isChecked) {
                if (!this.filter[attributeId]) {
                    this.filter[attributeId] = []
                }
                this.filter[attributeId].push(value)
            } else if (this.filter[attributeId].includes(value)) {
                this.filter[attributeId].splice(this.filter[attributeId].indexOf(value), 1)
            }
        },
        resetFilter() {
            this.filter = []
            this.price = {
                min: 0,
                max: 999999,
            }
        }
    }
}
</script>

<style scoped>

</style>
