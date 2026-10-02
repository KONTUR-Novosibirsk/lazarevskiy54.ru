<template>
    <el-aside :class="{'show-aside-mobile': !userStore.sidebarCollapse}" class="h-full border-r border-gray-200 dark:border-neutral-800">
        <div class="my-auto hidden lg:flex h-[55px]">
            <a class="font-bold m-auto hidden lg:block my-auto no-underline text-current" :href="route('index')"
               target="_blank">
                <el-badge value="v2" :offset="[7, 0]" class="relative" type="primary">
                    <el-tooltip placement="bottom" content="Перейти на сайт">
                        {{ sidebarIsSmall ? 'K' : 'KonturCMS' }}
                    </el-tooltip>
                </el-badge>
            </a>
        </div>
        <div class="flex flex-col" style="height: calc(100% - 55px)">
            <el-scrollbar :height="sidebarHeight" ref="sidebar" :always="true">
                <el-menu :collapse="sidebarIsSmall"
                         :hide-timeout="450"
                         :show-timeout="500"
                         :collapse-transition="true"
                         :class="{sidebar: !sidebarIsSmall}">
                    <template v-for="(sidebarItem, index) in $page.props.sidebar_items.data">
                        <template v-if="sidebarItem.has_menu_items">
                            <el-sub-menu :index="sidebarItem.route_name">
                                <template #title>
                                    <el-icon v-html="sidebarItem.icon"></el-icon>
                                    <span>{{ sidebarItem.name }}</span>
                                </template>
                                <el-menu-item v-for="(subItem, subIndex) in sidebarItem.children"
                                              :index="subItem.route_name">
                                    <Link :href="route(subItem.route_name)" class="stretched-link">
                                        <span>{{ subItem.name }}</span>
                                    </Link>
                                </el-menu-item>
                            </el-sub-menu>
                        </template>
                        <template v-else>
                            <el-menu-item :index="sidebarItem.route_name">
                                <template #title>
                                    <span>{{ sidebarItem.name }}</span>
                                </template>
                                <Link :href="route(sidebarItem.route_name)" class="stretched-link">
                                    <el-icon v-html="sidebarItem.icon"></el-icon>
                                </Link>
                            </el-menu-item>
                        </template>
                    </template>
                    <hr class="h-px my-1 border-0 bg-gray-200 dark:bg-neutral-800"/>
                    <el-menu-item index="modules" v-if="route().has('admin.modules') && $page.props.auth.isDevAdmin">
                        <template #title>
                            <span>Модули</span>
                        </template>
                        <Link :href="route('admin.modules')" class="stretched-link">
                            <el-icon>
                                <Icon icon="material-symbols:account-tree-rounded"/>
                            </el-icon>
                        </Link>
                    </el-menu-item>
                    <el-menu-item index="settings" v-if="route().has('admin.settings')">
                        <template #title>
                            <span>Настройки</span>
                        </template>
                        <Link :href="route('admin.settings')" class="stretched-link">
                            <el-icon>
                                <Icon icon="material-symbols:settings-outline"/>
                            </el-icon>
                        </Link>
                    </el-menu-item>
                </el-menu>
            </el-scrollbar>
            <a href="https://kontur-lite.ru" v-if="!sidebarIsSmall"
               class="px-2 py-2 m-4 mt-auto hidden lg:flex justify-between bg-gray-400 hover:bg-gray-500 dark:bg-neutral-900 dark:hover:bg-neutral-950 rounded-lg no-underline duration-300 shadow-md outline outline-offset-2 outline-gray-400 hover:outline-gray-500 dark:outline-neutral-800 dark:hover:outline-neutral-700">
                <div class="my-auto xs:block lg:hidden xl:block ms-1 text-gray-600 dark:text-neutral-50">
                    <svg width="69" height="47" viewBox="0 0 69 47" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="">
                            <path id="Vector"
                                  d="M45.6202 46.9034H0V0H45.6202V16.0478H43.5054V2.17434H2.11264V44.7291H43.5054V30.7508H45.6202V46.9034Z"
                                  fill="white"></path>
                            <path id="Vector_2"
                                  d="M9.32031 18.6348H11.4396V22.7874L14.4723 18.6348H17.015L13.5323 23.0336L17.2921 28.1663H14.6053L11.4396 23.6307V28.1663H9.32031V18.6348Z"
                                  fill="white"></path>
                            <path id="Vector_3"
                                  d="M22.8187 26.2021C24.5279 26.2021 25.4146 24.9599 25.4146 23.4009C25.4146 21.7098 24.2707 20.5998 22.8187 20.5998C21.3289 20.5998 20.2249 21.7098 20.2249 23.4009C20.2249 24.985 21.3799 26.2021 22.8187 26.2021ZM22.8187 18.6191C25.5565 18.6191 27.6005 20.4539 27.6005 23.4009C27.6005 26.2021 25.5565 28.1827 22.8187 28.1827C20.083 28.1827 18.0391 26.3457 18.0391 23.4009C18.0391 20.7183 19.9544 18.6191 22.8187 18.6191Z"
                                  fill="white"></path>
                            <path id="Vector_4"
                                  d="M36.5096 28.1661L32.1135 22.4476V28.1661H30.125V18.6367H31.8209L36.2192 24.3803L36.2147 18.6367H38.201L38.2054 28.1661H36.5096Z"
                                  fill="white"></path>
                            <path id="Vector_5"
                                  d="M40.7578 18.6348H48.4392V20.6769H45.6571V28.1663H43.5378V20.6769H40.7578V18.6348Z"
                                  fill="white"></path>
                            <path id="Vector_6"
                                  d="M58.7161 24.0653C58.7161 26.9781 56.916 28.1633 54.9297 28.1633C52.5466 28.1633 50.8906 26.7616 50.8906 23.9696V18.6387H53.0099V23.507C53.0099 24.9907 53.4466 26.1211 54.9297 26.1211C56.2132 26.1211 56.5968 25.1548 56.5968 23.63V18.6387H58.7161V24.0653V24.0653Z"
                                  fill="white"></path>
                            <path id="Vector_7"
                                  d="M63.3849 20.7081V22.8186H64.152C64.9611 22.8186 65.5951 22.5178 65.5951 21.7155C65.5951 21.1845 65.3335 20.7059 64.3138 20.7059C63.9946 20.7059 63.8216 20.6945 63.3849 20.7081ZM61.2656 28.1633V18.6387C61.7821 18.6387 64.152 18.6387 64.418 18.6387C66.9474 18.6387 67.8474 19.931 67.8474 21.6882C67.8474 23.4568 66.7878 24.1793 66.2846 24.4391L68.9647 28.1633H66.3954L64.1653 24.8608H63.3849V28.1633H61.2656V28.1633Z"
                                  fill="white"></path>
                        </g>
                    </svg>
                </div>
                <div class="ms-3 text-gray-100 dark:text-neutral-50">
                    <div class="flex justify-end">
                        <div class="text-xs">
                            Все права защищены
                        </div>
                    </div>

                    <div class="text-xs">
                        <div class="based-text">
                            laravel v{{ $page.props.laravel_version }}<br/>
                            php v{{ $page.props.php_version }}
                        </div>
                    </div>
                </div>

            </a>
        </div>
    </el-aside>
</template>

<script>
import {useUserStore} from "../stores/UserStore";

export default {
    name: "Sidebar",
    data() {
        return {
            sidebarHeight: 900,
            sidebarItems: null,
            userStore: useUserStore()
        }
    },
    mounted() {
        this.sidebarHeight = this.$refs.sidebar.clientHeight
        this.sidebarItems = this.$page.props.sidebar_items.data
    },
    computed: {
        sidebarIsSmall() {
            return this.userStore.sidebarCollapse && this.userStore.sidebarIsSmall;
        }
    },
    methods: {
        minimizeSidebar() {
            this.userStore.sidebarIsSmall = !this.userStore.sidebarIsSmall;
        }
    }
}
</script>

<style scoped>

</style>
