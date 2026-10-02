<script>
export default {
    name: "Drawer",
    props: {
        title: null,
        button: 'Open',
    },
    data() {
        return {
            drawer: false,
        }
    }
}
</script>

<template>
    <el-button type="primary" style="margin-left: 5px" @click="drawer = true">
        {{ button }}
    </el-button>

    <el-drawer v-model="drawer" :title="title" size="30%">
        <div>
            <slot name="body"/>
        </div>
    </el-drawer>
</template>

