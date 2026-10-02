<template>
    <div class="history-container">
        <div v-for="order in history" :key="order.id" class="order-item">
            <div class="order-products">
                <div v-for="product in order.products" :key="product.id" class="product-item">
                    <div class="product-image">
                        <img :src="product.first_preview" :alt="product.title" >
                    </div>
<!--                    {{product}}-->
                    <div class="product-info">
                        <h4 class="product-title">{{ product.title }}</h4>
                        <span>Артикул: {{ product.article }}</span>
                        <div class="product-price">
                            {{ product.price.toLocaleString() }} ₽
                        </div>
                    </div>

                    <div class="product-quantity">
                        <span>Количество</span>
                        {{ product.count }} {{ declinateProduct(product.count) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>


export default {
    name: "AccountHistoryComponent",
    props: {
        history: {
            type: Array,
            default: () => []
        }
    },
    methods: {
        declinateProduct(count) {
            const lastDigit = count % 10;
            const lastTwoDigits = count % 100;

            if (lastTwoDigits >= 11 && lastTwoDigits <= 19) {
                return 'товаров';
            }

            if (lastDigit === 1) {
                return 'товар';
            }

            if (lastDigit >= 2 && lastDigit <= 4) {
                return 'товара';
            }

            return 'товаров';
        }
    }

}
</script>

<style scoped>

</style>
