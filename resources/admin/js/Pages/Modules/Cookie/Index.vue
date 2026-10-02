<script setup lang="ts">
import MainLayout from "../../../Layouts/MainLayout.vue";
import { defineProps } from "vue";

const props = defineProps<{
    accountCookie?: any[]
}>();
</script>

<template>
    <MainLayout>
        <el-table
            :data="props.accountCookie"
            style="width: 100%"
            v-if="props.accountCookie && props.accountCookie.length > 0"
        >
            <el-table-column prop="id" label="ID" width="80" />
            <el-table-column label="Аккаунт" width="220">
                <template #default="{ row }">
                    <div v-if="row.account">
                        <div>{{ row.account.email }}</div>
                        <div class="text-xs text-gray-500">{{ row.account.full_name }}</div>
                    </div>
                    <div v-else class="text-gray-400">Гость</div>
                </template>
            </el-table-column>
            <el-table-column prop="ip_address" label="IP адрес" width="140" />
            <el-table-column label="Статус" width="120">
                <template #default="{ row }">
                    <el-tag :type="row.accepted_all ? 'success' : 'warning'">
                        {{ row.accepted_all ? 'Приняты все' : '' }}
                    </el-tag>
                </template>
            </el-table-column>
            <el-table-column label="Сессия" width="180">
                <template #default="{ row }">
                    <div class="text-xs font-mono truncate max-w-[180px]">
                        {{ row.session_id }}
                    </div>
                </template>
            </el-table-column>
            <el-table-column label="Дата принятия" width="180">
                <template #default="{ row }">
                    {{ new Date(row.accepted_at).toLocaleString() }}
                </template>
            </el-table-column>
            <el-table-column label="Дата создания" width="180">
                <template #default="{ row }">
                    {{ row.created_at ? new Date(row.created_at).toLocaleString() : '—' }}
                </template>
            </el-table-column>
        </el-table>

        <el-empty description="Нет данных" v-else />
    </MainLayout>
</template>

<style scoped>
.text-xs {
    font-size: 0.75rem;
    line-height: 1rem;
}
.max-w-\[180px\] {
    max-width: 180px;
}
</style>
