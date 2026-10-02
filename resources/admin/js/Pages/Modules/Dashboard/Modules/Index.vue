<template>
    <el-row :gutter="20">
        <el-col :xs="24" :lg="12">
            <template v-for="module in modules.data">
                <el-card class="mb-1" body-class="!p-2">
                    <div class="flex justify-between">
                        <div class="my-auto ms-4">{{ module.name }}</div>
                        <div class="">
                            <Link v-if="module.hasSettings" class="el-button el-button--small ms-1"
                                  :href="route('admin.settings', module.id)">
                                <i class="bi bi-gear-fill"></i></Link>
                            <el-button size="small" class="me-2" @click="setAdditionalKey(module.id)">Дополнительно
                            </el-button>
                            <el-switch
                                v-model="module.config.active"
                                inline-prompt
                            />
                        </div>
                    </div>
                    <el-collapse-transition>
                        <div v-show="additionalKey == module.id">
                            <hr class="h-px my-2 mx-3 border-0 bg-neutral-300 dark:bg-neutral-500"/>
                            <div class="mx-5">
                                <div>
                                    <el-switch v-model="module.config.withSidebar" size="small"
                                               active-text="Доступ к боковой панели"/>
                                </div>
                                <div>
                                    <el-switch v-model="module.config.withHeader" size="small"
                                               active-text="Доступ к header"/>
                                </div>
                                <div>
                                    <el-switch v-model="module.config.withWidget" size="small"
                                               active-text="Доступ к главной странице"/>
                                </div>
                            </div>
                        </div>
                    </el-collapse-transition>
                </el-card>
            </template>
        </el-col>
        <el-col :xs="24" :lg="12">
            <el-alert type="warning" class="!mb-2" :closable="false">
                <p>Список модулей зарегистрированных в системе.</p>
                <p>Документацию можно найти по ссылке, которая будет когда-нибудь позже :)</p>
            </el-alert>
            <el-button type="primary" :loading="loading" @click="save">
                Сохранить
            </el-button>
        </el-col>
    </el-row>
</template>

<script>
import MainLayout from "../../../../Layouts/MainLayout.vue";
import HandleErrorsMixin from "../../../../Shared/Mixins/HandleErrorsMixin";
import {ElNotification} from "element-plus";

export default {
    name: "Index",
    layout: MainLayout,
    mixins: [HandleErrorsMixin],
    props: {
        modules: {
            type: Object,
            default: {},
        },
    },
    data() {
        return {
            loading: false,
            additionalKey: null,
        }
    },
    methods: {
        setAdditionalKey(value) {
            this.additionalKey = this.additionalKey === value ? null : value
        },
        save() {
            this.loading = true
            axios.post(route('admin.modules.update'), {
                modules: this.modules.data,
            }).then((response) => {
                ElNotification({
                    title: 'Система',
                    message: 'Сохранено',
                    type: 'success',
                    position: 'bottom-right',
                })
            }).catch((error) => {
                this.handleErrors(error)
            }).finally(() => {
                this.loading = false
            })
        },
    }
}
</script>

<style scoped>

</style>
