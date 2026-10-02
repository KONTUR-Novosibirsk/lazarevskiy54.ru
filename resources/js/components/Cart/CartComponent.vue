<template>
    <section class="cart">
        <div class="cart-container container">
            <h1>Корзина</h1>
            <div class="cart-content">
                <div class="cart-content__left">
                    <div class="" v-if="productsData.length === 0">
                        Ваша корзина пуста
                    </div>
                    <div class="cart-item" v-for="(product, index) in productsData">
                        <a :href="product.url" class="cart-item__img">
                            <img v-if="product.first_preview" :src="product.first_preview" alt="">
                            <img v-else src="/images/product-img.jpg" alt="">
                        </a>
                        <div class="cart-item__info">
                            <a :href="product.url" class="cart-item__link">{{ product.title }}</a>
                            <div class="cart-item__offer">
<!--                                                              <p>Цвет: Белый</p>
                                                                <p>Размер: 8</p>-->
                            </div>
                            <a @click.stop.prevent="deleteProduct(index)" class="cart-item__delete">Удалить</a>
                        </div>
                        <div class="cart-item__count">
                            <button class="cart-minus" @click="decreaseCount(index)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none">
                                    <path
                                        d="M15 12H9M21 12C21 13.1819 20.7672 14.3522 20.3149 15.4442C19.8626 16.5361 19.1997 17.5282 18.364 18.364C17.5282 19.1997 16.5361 19.8626 15.4442 20.3149C14.3522 20.7672 13.1819 21 12 21C10.8181 21 9.64778 20.7672 8.55585 20.3149C7.46392 19.8626 6.47177 19.1997 5.63604 18.364C4.80031 17.5282 4.13738 16.5361 3.68508 15.4442C3.23279 14.3522 3 13.1819 3 12C3 9.61305 3.94821 7.32387 5.63604 5.63604C7.32387 3.94821 9.61305 3 12 3C14.3869 3 16.6761 3.94821 18.364 5.63604C20.0518 7.32387 21 9.61305 21 12Z"
                                        stroke="#D1D5DB" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"/>
                                </svg>
                            </button>
                            <input type="number" :value="productsData[index].count" class="cart-value"
                                   @input="updateCount(index, $event)">
                            <button class="cart-plus" @click="increaseCount(index)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none">
                                    <path
                                        d="M12 9V12M12 12V15M12 12H15M12 12H9M21 12C21 13.1819 20.7672 14.3522 20.3149 15.4442C19.8626 16.5361 19.1997 17.5282 18.364 18.364C17.5282 19.1997 16.5361 19.8626 15.4442 20.3149C14.3522 20.7672 13.1819 21 12 21C10.8181 21 9.64778 20.7672 8.55585 20.3149C7.46392 19.8626 6.47177 19.1997 5.63604 18.364C4.80031 17.5282 4.13738 16.5361 3.68508 15.4442C3.23279 14.3522 3 13.1819 3 12C3 9.61305 3.94821 7.32387 5.63604 5.63604C7.32387 3.94821 9.61305 3 12 3C14.3869 3 16.6761 3.94821 18.364 5.63604C20.0518 7.32387 21 9.61305 21 12Z"
                                        stroke="#D1D5DB" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                        <div class="cart-item__price">
                            <div class="cart-item__price_new">
                                {{ product.price }} ₽
                            </div>
                            <div class="cart-item__price_old" v-if="product.old_price > product.price">
                                {{ product.old_price }} ₽
                            </div>
                        </div>
                    </div>

                </div>
                <div class="cart-content__right" v-if="productsData.length > 0">
                    <div class="cart-total__content">
                        <div class="cart-total__content_left">
                            Товары <span>({{ totalCount }})</span>
                        </div>
                        <div class="cart-total__content_right">
                            {{ totalOldPrice }} ₽
                        </div>
                    </div>
                    <div class="cart-total__content">
                        <div class="cart-total__content_left">
                            Скидка
                        </div>
                        <div class="cart-total__content_right discount">
                            - {{ sale }} ₽
                        </div>
                    </div>
                    <div class="cart-line"></div>
                    <div class="cart-total__content cart-total__price">
                        <div class="cart-total__content_left">
                            Общая стоимость
                        </div>
                        <div class="cart-total__content_right">
                            {{ totalPrice }} ₽
                        </div>
                    </div>
                    <FlushModalComponent @flush="flushCart"></FlushModalComponent>
                    <a href="#" class="cart-buy" data-src="#order-popup"
                       data-auto-focus="false" data-fancybox>Перейти к оформлению</a>
                    <div class="cart-buy__description">
                        Нажимая на кнопку я согласен с условиями и правилами пользования торговой площадкой и правилами
                        возврата
                    </div>
                </div>
            </div>
        </div>
    </section>
    <DeleteModalComponent @onReady="readyModal" @deleteProduct="confirmDelete">

    </DeleteModalComponent>

    <div id="order-popup" style="display: none;">
       <OrderComponent :privacy-policy-link="privacyPolicyLink" @success="productsData = []"></OrderComponent>
    </div>
</template>

<script>
import DeleteModalComponent from "./DeleteModalComponent.vue";
import FlushModalComponent from "./FlushModalComponent.vue";
import Cart from "../../cart/Cart";
import OrderComponent from "./OrderComponent.vue";

export default {
    name: "CartComponent",
    components: {OrderComponent, FlushModalComponent, DeleteModalComponent},
    props: {
        privacyPolicyLink: null,
        products: [],
    },
    data() {
        return {
            delete_index: null,
            modal: null,
            totalPrice: 0,
            totalOldPrice: 0,
            sale: 0,
            totalCount: 0,
            productsData: this.products,
        }
    },
    watch: {
        productsData: {
            handler(newValue, oldValue) {
                this.computedPrice();
            },
            deep: true,
        }
    },
    mounted() {
        this.computedPrice()
    },
    methods: {
        computedPrice() {
            let totalPrice = 0;
            let totalOldPrice = 0;
            let totalCount = 0;
            for (let index in this.productsData) {
                totalPrice += +this.productsData[index].price * +this.productsData[index].count
                totalOldPrice += Math.max(this.productsData[index].price, this.productsData[index].old_price) * +this.productsData[index].count
                totalCount += +this.productsData[index].count
            }
            this.totalPrice = totalPrice
            this.totalOldPrice = totalOldPrice
            this.sale = totalOldPrice - totalPrice
            this.totalCount = totalCount
            Cart.changeTotalCount(totalCount)
        },
        updateCount(index, event) {
            if (event.target.value > 0) {
                if (this.productsData[index].count > event.target.value) {
                    this.decreaseCount(index, +this.productsData[index].count - +event.target.value)
                } else {
                    this.increaseCount(index, +event.target.value - +this.productsData[index].count)
                }
            }
        },
        increaseCount(index, count = 1) {
            axios.post('/cart/add', {
                id: this.productsData[index].id,
                count: count,
            }).then((response) => {
                this.productsData[index].count = +this.productsData[index].count + count
            })
        },
        decreaseCount(index, count = 1, checkCount = true) {
            if (this.productsData[index].count - count <= 0 && checkCount) {
                this.deleteProduct(index)
                return
            }
            axios.post('/cart/remove', {
                hash: this.productsData[index].hash,
                count: count,
            }).then((response) => {
                this.productsData[index].count = +this.productsData[index].count - count
                if (this.productsData[index].count == 0) {
                    this.products.splice(index, 1);
                }
            })

        },
        readyModal(modal) {
            this.modal = modal
        },
        deleteProduct(index) {
            this.delete_index = index
            this.modal.show()
        },
        confirmDelete() {
            this.decreaseCount(this.delete_index, this.productsData[this.delete_index].count, false)
            this.delete_index = null
            this.modal.hide()
        },
        flushCart() {
            this.productsData = []
            Cart.changeTotalCount(0)
        }
    }
}
</script>

<style scoped>

</style>
