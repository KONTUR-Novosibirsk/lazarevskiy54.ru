<script>
import HandleErrorsMixin from "../../../Shared/Mixins/HandleErrorsMixin";
import {ElNotification} from "element-plus";

export default {
    name: "CommandComponent",
    mixins: [HandleErrorsMixin],
    data() {
        return {
            loading: false,
            command: null,
        }
    },
    methods: {
        call(command) {
            if (this.loading) return
            this.loading = true
            this.errors = false
            this.command = command
            axios.post(route('admin.command.call'), {
                command: command,
            }).then((response) => {
                if (response.data === 0)
                    ElNotification({
                        title: 'Система',
                        message: 'Команда выполнена успешно',
                        type: 'success',
                        position: 'bottom-right',
                    })
                else
                    ElNotification({
                        title: 'Система',
                        message: 'Не удалось выполнить команду',
                        type: 'error',
                        position: 'bottom-right',
                    })
            }).catch((error) => {
                this.handleErrors(error)
            }).finally(() => {
                this.loading = false
            })
        }
    }
}
</script>

<template>
    <el-card header="Сброс кэша" class="mb-3">
        Маршруты, представления, конфиги и другие данные.
        <template #footer>
            <el-button :loading="loading && command === 'cache:clear'" size="small"
                       type="danger" @click="call('cache:clear')">Все
            </el-button>
            <el-button :loading="loading && command === 'route:clear'" size="small"
                       type="primary" @click="call('route:clear')">Маршруты
            </el-button>
            <el-button :loading="loading && command === 'config:clear'" size="small"
                       type="primary" @click="call('config:clear')">Конфиги
            </el-button>
            <el-button :loading="loading && command === 'view:clear'" size="small"
                       type="primary" @click="call('view:clear')">Представления
            </el-button>
        </template>
    </el-card>
    <el-card header="Оптимизация" class="mb-3">
        Маршруты, представления, конфиги. Не оптимизируйте во время разработки, только на продовом сервере.
        <template #footer>
            <el-button :loading="loading && command === 'optimize'" size="small"
                       type="primary" @click="call('optimize')">Оптимизировать
            </el-button>
            <el-button :loading="loading && command === 'optimize:clear'" size="small"
                       type="danger" @click="call('optimize:clear')">Сбросить
            </el-button>
        </template>
    </el-card>
    <el-card header="Ссылка на файловое хранилище" class="mb-3">
        Создает ссылку на файловое хранилище в публичной части
        <template #footer>
            <el-button :loading="loading && command === 'storage:link'" size="small"
                       type="primary" @click="call('storage:link')">Создать
            </el-button>
        </template>
    </el-card>
</template>
