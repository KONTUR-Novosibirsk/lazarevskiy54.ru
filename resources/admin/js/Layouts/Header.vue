<template>
    <el-header class="flex" height="55px">
        <div class="flex">
            <el-button :dark="false" class="my-auto hidden lg:block" @click="minimizeSidebar">
                <Icon icon="line-md:menu-unfold-right" v-if="sidebarIsSmall"/>
                <Icon icon="line-md:menu-fold-left" v-else/>
            </el-button>
            <el-button :dark="false" class="my-auto block lg:hidden !ms-0" @click="changeCollapse">
                <Icon icon="line-md:menu-unfold-right" v-if="sidebarIsCollapsed"/>
                <Icon icon="line-md:menu-fold-left" v-else/>
            </el-button>
<!--            <el-input class="my-auto ms-4 w-80 hidden lg:flex" placeholder="Начните поиск" @click.prevent.stop="search = true">
                <template #suffix>
                    <el-icon class="el-input__icon"><Icon icon="icon-park-outline:search"/></el-icon>
                </template>
            </el-input>
            <el-drawer v-model="search" title="Поиск" size="40%">
                <el-input size="large" placeholder="Начните поиск">
                    <template #suffix>
                        <el-icon class="el-input__icon"><Icon icon="icon-park-outline:search"/></el-icon>
                    </template>
                </el-input>
            </el-drawer>-->
        </div>


        <div class="flex ms-auto my-auto">
            <component class="ms-2" v-for="component in headerItems" :is="component.name" :data="component.data"/>
            <ThemeSwitcher class="el-header-item ms-2"></ThemeSwitcher>
            <el-dropdown class="ms-2">
                <div class="el-header-item h-8 !w-auto">
                    <div class="m-auto flex px-4">
                        <el-avatar :size="20" src="https://cube.elemecdn.com/3/7c/3ea6beec64369c2642b92c6726f1epng.png"
                                   class="my-auto"/>
                        <div class="my-auto mx-2">
                            {{ $page.props.auth.user.username }}
                        </div>
                        <el-icon class="my-auto">
                            <Icon icon="lsicon:down-outline"/>
                        </el-icon>
                    </div>
                </div>
                <template #dropdown>
                    <el-dropdown-menu>
                        <el-dropdown-item @click="logout">Выход</el-dropdown-item>
                    </el-dropdown-menu>
                </template>
            </el-dropdown>
        </div>
    </el-header>
</template>

<script>
import {router} from '@inertiajs/vue3'
import Notification from "../Widgets/Header/Notification.vue";
import ShopOrders from "../Widgets/Header/ShopOrders.vue";
import {useUserStore} from "../stores/UserStore";
import ThemeSwitcher from "../components/ThemeSwitcher.vue";

export default {
    name: "Header",
    components: {ThemeSwitcher, Notification, ShopOrders},
    methods: {
        logout() {
            router.post(route('admin.logout'))
        },
        minimizeSidebar() {
            this.userStore.sidebarIsSmall = !this.userStore.sidebarIsSmall;
        },
        changeCollapse() {
            this.userStore.sidebarCollapse = !this.userStore.sidebarCollapse
        }
    },
    data() {
        return {
            headerItems: [],
            userStore: useUserStore(),
            search: false,
        }
    },
    computed: {
        sidebarIsSmall() {
            return this.userStore.sidebarIsSmall;
        },
        sidebarIsCollapsed() {
            return this.userStore.sidebarCollapse;
        }
    },
    mounted() {
        if (this.$page.props.header_items?.data) {
            this.headerItems = this.$page.props.header_items.data
        }
    }
}
</script>

<style scoped>
</style>
