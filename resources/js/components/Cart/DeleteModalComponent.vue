<template>
    <div class="cart-popup__container" v-show="isActive">
        <div class="cart-popup">
            <div class="cart-popup__heading">Удалить товар из корзины?</div>
            <div class="cart-popup__content">
                <a @click.stop.prevent="deleteProduct" class="cart-popup__submit">Удалить</a>
                <a @click.stop.prevent="hide" class="cart-popup__close">Отмена</a>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "DeleteModalComponent",
    data() {
        return {
            isActive: false,
        }
    },
    mounted() {
        this.$emit('onReady', {
            show: this.show,
            hide: this.hide,
        })
    },
    methods: {
        deleteProduct() {
            this.$emit('deleteProduct')
        },
        show() {
            this.isActive = true
        },
        hide() {
            if (this.isActive) {
                this.isActive = false
            }
        }
    }

}
</script>

<style scoped>

</style>
