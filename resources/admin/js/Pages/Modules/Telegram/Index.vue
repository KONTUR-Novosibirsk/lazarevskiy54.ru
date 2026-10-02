<template>


    <el-row :gutter="20">
        <el-col :xs="24" :lg="12" :xl="16">
            <v-grid :data="accountsData" class="mb-4">
                <template #filter>
                    <div class="flex justify-between">
                        <AccountForm/>
                        <Link :href="route('admin.settings', 'telegram')" class="el-button el-button--primary">Настройки</Link>
                    </div>
                </template>
                <el-table-column prop="id" label="#" width="60"/>
                <el-table-column prop="name" label="Имя"/>
                <el-table-column prop="chat_id" label="ID чата"/>
                <el-table-column prop="is_active" label="Активность">
                    <template #default="scope">
                        <el-tag v-if="scope.row.is_active" type="success">Активна</el-tag>
                        <el-tag v-else type="danger">Не активна</el-tag>
                    </template>
                </el-table-column>
                <el-table-column width="350">
                    <template #default="scope">
                        <el-space>
                            <AccountForm size="small" :account="scope.row" @update="update" :index="scope.$index"/>
                            <v-modal-delete :url="route('admin.tg.account.delete', scope.row.id)" :refresh="true"/>
                            <el-button type="primary" size="small" @click="sendTestMessage(scope.row)">
                                Тестовое сообщение
                            </el-button>
                        </el-space>
                    </template>
                </el-table-column>
            </v-grid>
        </el-col>
        <el-col :xs="24" :lg="12" :xl="8">
            <el-card header="Инструкция">
                <el-steps direction="vertical" :active="activeStep">
                    <el-step @click="activeStep = 1">
                        <template #title>
                            Создайте своего бота через <a target="_blank" href="https://t.me/BotFather">@BotFather</a>
                        </template>
                    </el-step>
                    <el-step @click="activeStep = 2">
                        <template #title>
                            Полученный токен укажите в настройках данного модуля
                        </template>
                    </el-step>
                    <el-step @click="activeStep = 3">
                        <template #title>
                            Узнайте свой id через бот <a href="https://t.me/userinfobot">@userinfobot</a>
                        </template>
                    </el-step>
                    <el-step @click="activeStep = 4">
                        <template #title>
                            Создайте новую запись с полученным id
                        </template>
                    </el-step>
                    <el-step @click="activeStep = 5">
                        <template #title>
                            Напишите первыми своему боту, так как политика телеграм не разрешает отправлять
                            сообщения через
                            api в пустой чат
                        </template>
                    </el-step>
                </el-steps>
            </el-card>
        </el-col>
    </el-row>
</template>

<script>
import MainLayout from "../../../Layouts/MainLayout.vue";
import AccountForm from "./AccountForm.vue";
import VGrid from "../../../components/UI/Data/VGrid.vue";
import {ElNotification} from "element-plus";
import VModalDelete from "../../../components/UI/Feedback/VModalDelete.vue";

export default {
    name: "Index",
    layout: MainLayout,
    props: {
        accounts: null,
    },
    data() {
        return {
            activeStep: 1,
            accountsData: this.accounts
        }
    },
    components: {VModalDelete, VGrid, AccountForm, MainLayout},
    methods: {
        sendTestMessage(account) {
            axios.post(route('admin.tg.account.test.message', account.id)).then((response) => {
                if (response.data) {
                    ElNotification.success({position: 'bottom-right', message: 'Тестовое сообщение успешно отправлено'})
                } else {
                    ElNotification.error({position: 'bottom-right', message: 'Не удалось отправить тестовое сообщение'})
                }
            }).catch((errors) => {
                ElNotification.error({position: 'bottom-right', message: 'Ошибка сервера'})
            })
        },
        update(index, account) {
            this.accountsData.data[index] = account
        }
    }
}
</script>

<style scoped>

</style>
