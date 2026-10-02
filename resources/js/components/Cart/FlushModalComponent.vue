<template>
    <a class="cart-flush" @click.stop.prevent="show">Очистить корзину</a>
    <div class="cart-popup__container" v-show="isActive">
        <div class="cart-popup">
            <div class="cart-popup__heading">Удалить все товары из корзины?</div>
            <div class="cart-popup__content">
                <a @click.stop.prevent="flush" class="cart-popup__submit">Удалить</a>
                <a @click.stop.prevent="hide" class="cart-popup__close">Отмена</a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "FlushModalComponent",
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
        flush() {
            axios.post('/cart/flush').then(() => {
                this.$emit('flush')
                this.hide()
            })
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
