<template>
    <el-button type="primary" @click="upload.click()" :loading="loading" class="mb-3">Загрузить</el-button>
    <input class="hidden" type="file" ref="upload" @change="uploadFiles" multiple>
    <el-card v-for="file in modelValue || []" class="mb-2" body-class="py-1">
        <h5 class="my-2 opacity-90"><i :class="getIcon(file)"></i> {{ file.name }}.{{ file.extension }}</h5>
        <div class="flex justify-between">
            <div class="text-xs opacity-70 my-auto">Размер: {{ file.size_for_human }}</div>
            <el-button-group>
                <el-button size="small" v-clipboard="route('file.download', file.id)">
                    <i class="bi bi-clipboard"></i>
                </el-button>
                <el-button size="small" @click="insertLink(file)">В редактор</el-button>
                <a class="el-button el-button--small"
                   :href="route('file.download', file.id)" target="_blank">Скачать</a>
                <el-button type="danger" size="small" @click="deleteFile(file)" :disabled="deleteButtonDisabled" plain>
                    <i class="bi bi-trash-fill"></i>
                </el-button>
            </el-button-group>
        </div>
    </el-card>
    <el-alert v-if="(modelValue || []).length === 0" type="error" :closable="false" title="Файлы отсутствуют"/>
</template>

<script>
import {ElMessage} from "element-plus";
import HandleErrorsMixin from "../../../Shared/Mixins/HandleErrorsMixin";
import {useEditorStore} from "../../../stores/editor.js";

export default {
    name: "VUploadFiles",
    mixins: [HandleErrorsMixin],
    props: {
        group: {
            type: String,
            default: 'main',
        },
        model_type: null,
        model_id: null,
        modelValue: null,
    },
    data() {
        return {
            loading: false,
            deleting: false,
            upload: null,
        }
    },
    mounted() {
        this.upload = this.$refs.upload
    },
    computed: {
        deleteButtonDisabled() {
            return this.deleting || this.loading;
        },
    },
    methods: {
        deleteFile(file) {
            this.deleting = true;
            axios.delete(route('admin.storage.file.delete', file.id))
                .then((response) => {
                    const newData = this.modelValue;
                    const deleteIndex = newData.indexOf(file);
                    this.$emit('modelValue:update', newData.splice(deleteIndex, 1));
                    ElMessage.success({message: 'Файл удален', grouping: true})
                }).catch((error) => {
                ElMessage.success('Ошибка удаления')
            })
            this.deleting = false;
        },
        insertLink(file) {
            useEditorStore().insertLink(file.name, route('file.download', file.id))
        },
        async uploadFiles(event) {
            this.loading = true;
            for (let file in [...event.target.files]) {
                await axios.post(route('admin.storage.file.upload'), {
                    fileable_type: this.model_type,
                    fileable_id: this.model_id,
                    file: event.target.files[file],
                    group: this.group,
                }, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then((response) => {
                    const newData = this.modelValue;
                    this.$emit('modelValue:update', (newData || []).push(response.data.data));
                    ElMessage.success({message: 'Файл загружен', grouping: true})
                }).catch((error) => {
                    this.handleErrors(error)
                });
            }
            this.loading = false;
        },
        getIcon(file) {
            let iconFormat = [
                {formats: ['jpeg', 'jpg', 'gif', 'png'], icon: 'bi bi-file-earmark-image'},
                {formats: ['zip', 'rar'], icon: 'bi bi-file-earmark-zip-fill'},
                {formats: ['xlsx', 'xls', 'csv'], icon: 'bi bi-file-earmark-excel-fill'},
                {formats: ['doc', 'docx'], icon: 'bi bi-file-earmark-word-fill'},
                {formats: ['pdf'], icon: 'bi bi-file-earmark-pdf-fill'},
            ];
            return (iconFormat.find(f => f.formats.includes(file.extension)) || {icon: 'bi bi-file-earmark-fill'}).icon;
        },
    },
}
</script>

<style scoped>

</style>
