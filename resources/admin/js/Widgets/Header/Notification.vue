<template>
    <el-dropdown>
        <el-badge :value="data.count" :hidden="data.count == 0" :offset="[-4, 2]" class="rounded-full">
            <div class="el-header-item">
                <Icon class="m-auto" icon="line-md:bell-filled"/>
            </div>
        </el-badge>

        <template #dropdown>
            <el-dropdown-menu class="min-w-64">
                <el-dropdown-item v-for="notice in data.data" @click="$inertia.get(notice.route)" class="flex">
                    {{ notice.name }}
                    <el-tag class="ms-3 ms-auto" :type="notice.count == 0 ? 'success':'danger'" size="small">
                        {{ notice.count }}
                    </el-tag>
                </el-dropdown-item>
            </el-dropdown-menu>
        </template>
    </el-dropdown>

</template>

<script>
export default {
    name: "Notification",
    props: {
        data: {},
    },
}
</script>

