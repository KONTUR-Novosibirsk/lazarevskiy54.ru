<template>
    <el-dialog v-model="modal" title="Добавить">
        <el-form label-position="top">
            <form-item :errors="errors['name']" label="Название">
                <el-input v-model="newGallery.name"/>
            </form-item>
            <form-item :errors="errors['alias']" label="Алиас">
                <form-alias v-model="newGallery.alias" :title="newGallery.name" :in-real-time="true"/>
            </form-item>
            <form-item label="Описание" :errors="errors['text']">
                <el-input v-model="newGallery.text" type="textarea"/>
            </form-item>
            <el-button @click="store" type="primary" :loading="loading">Добавить</el-button>
        </el-form>
    </el-dialog>
    <v-grid :data="galleries">
        <template #filter>
            <el-button @click="modal = true" type="primary" :loading="loading">Добавить альбом</el-button>
        </template>
        <el-table-column prop="id" label="#" width="50"/>
        <el-table-column prop="name" label="Название">
            <template #default="prop">
                <div class="flex">
                    <div>
                        <img :src="prop.row.image?.preview ?? '/images/no_image.png'" alt=""
                             class="product-image me-2" style="width: 50px;">
                    </div>
                    <div class="">
                        {{ prop.row.name }}
                    </div>
                </div>
            </template>
        </el-table-column>
        <el-table-column prop="images_count" label="Количество изображений" width="200">
            <template #default="prop">
                {{ prop.row.images_count }}
            </template>
        </el-table-column>
        <el-table-column prop="active" label="Активность">
            <template #default="prop">
                <el-tag v-if="prop.row.active" type="success">Активно</el-tag>
                <el-tag v-else type="danger">Не активно</el-tag>
            </template>
        </el-table-column>
        <el-table-column label="Управление">
            <template #default="prop">
                <Link :href="route('admin.gallery.edit', prop.row.id)"
                      class="el-button el-button--primary el-button--small">Изменить
                </Link>
                <v-modal-delete :url="route('admin.gallery.delete', prop.row.id)" :refresh="true"/>
            </template>
        </el-table-column>
    </v-grid>
</template>

<script>
import MainLayout from "../../../Layouts/MainLayout.vue";
import {router} from "@inertiajs/vue3";
import VGrid from "../../../components/UI/Data/VGrid.vue";
import FormItem from "../../../components/UI/Form/FormItem.vue";
import FormAlias from "../../../components/UI/Form/FormAlias.vue";
import {ElNotification} from "element-plus";
import HandleErrorsMixin from "../../../Shared/Mixins/HandleErrorsMixin";
import VModalDelete from "../../../components/UI/Feedback/VModalDelete.vue";

export default {
    name: "Index",
    layout: MainLayout,
    mixins: [HandleErrorsMixin],
    components: {VModalDelete, FormAlias, FormItem, VGrid},
    props: {
        galleries: {
            type: Object,
            default: {},
        }
    },
    data() {
        return {
            modal: false,
            newGallery: {
                name: '',
                text: '',
                alias: '',
            },
            errors: [],
            loading: false,
        }
    },
    methods: {
        store() {
            this.loading = true
            this.errors = []
            axios.post(route('admin.gallery.store'), this.newGallery).then((response) => {
                this.modal = false
                ElNotification.success({message: 'Альбом создана', position: 'bottom-right'})
                router.visit(route('admin.gallery.edit', response.data.data.id))
            }).catch((errors) => {
                this.handleErrors(errors)
            }).finally(() => {
                this.loading = false
            })
        }
    }
}
</script>
