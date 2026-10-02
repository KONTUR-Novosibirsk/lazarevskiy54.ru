<template>
    <Head :title="$page.props.seo.title"/>
    <el-container class="layout-container" direction="vertical">
        <el-container class="main-container">
            <Sidebar/>
            <el-container direction="vertical">
                <Header class="z-50 sticky top-0"/>
                <el-main v-loading="loading">
                    <el-scrollbar class="scrollbar" scroll-region>
                        <div class="mb-0 mt-5 mx-5">
                            <div class="flex justify-between flex-col lg:flex-row mb-2 lg:mb-0">
                                <h1 class="my-2 font-bold text-xl">{{ $page.props.seo.title }}</h1>
                                <Breadcrumbs class="my-auto"/>
                            </div>
                            <hr class="h-px mе-1 mb-1 bg-gray-200 dark:bg-neutral-700 border-0"/>
                        </div>
                        <div class="m-5 mb-6">
                            <slot/>
                        </div>
                        <el-backtop target=".scrollbar .el-scrollbar__wrap" :right="75" :bottom="15"/>
                    </el-scrollbar>
                </el-main>
            </el-container>
        </el-container>
    </el-container>
</template>
<script>
import {Head, router} from '@inertiajs/vue3';
import Header from "./Header.vue";
import Sidebar from "./Sidebar.vue";
import {ElNotification} from "element-plus";
import Breadcrumbs from "../components/UI/Navigation/Breadcrumbs.vue";

export default {
    components: {Breadcrumbs, Header, Sidebar, Head},
    data() {
        return {
            loading: false,
        }
    },
    mounted() {
        router.on('start', (e) => {
            if (!e.detail?.visit?.headers?.filter)
                this.loading = true
        })
        router.on('finish', () => {
            this.loading = false
        })
    },
    updated() {
        if (this.$page.props.session_messages.success)
            ElNotification({
                title: 'Система',
                message: this.$page.props.session_messages.success,
                type: 'success',
                position: 'bottom-right',
            })
        if (this.$page.props.session_messages.error)
            ElNotification({
                title: 'Система',
                message: this.$page.props.session_messages.error,
                type: 'error',
                position: 'bottom-right',
            })
    }
}
</script>

