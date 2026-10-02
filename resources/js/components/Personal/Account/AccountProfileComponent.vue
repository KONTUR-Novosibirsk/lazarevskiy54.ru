<template>
    <span>{{ declinateOrders(orderCount) }}</span>
</template>

<script>


export default {
    name: "AccountProfileComponent",
    props: {
        orderCount: []
    },
    methods: {
        declinateOrders(count) {
            const rules = [
                { condition: (n) => n % 100 >= 11 && n % 100 <= 19, word: 'Заказов' },
                { condition: (n) => n % 10 === 1, word: 'Заказ' },
                { condition: (n) => n % 10 >= 2 && n % 10 <= 4, word: 'Заказа' },
            ];

            return rules.find(rule => rule.condition(count))?.word || 'Заказов';
        },
    }
}
</script>

<style scoped>

</style>
