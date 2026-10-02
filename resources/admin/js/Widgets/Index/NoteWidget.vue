<template>
    <h5 class="mx-3 mb-4 p-1">Заметки</h5>
    <div class="mb-1">
        <el-form>
            <form-item :errors="errors['text']">
                <el-input v-model="text" type="textarea" class="mb-1"/>
            </form-item>
            <div class="flex justify-between -mt-4">
                <el-button size="small" @click="store" :loading="loading">Добавить</el-button>
                <Link :href="route('admin.widget.note.index')"
                      class="el-button el-button--primary el-button--small">Все заметки
                </Link>
            </div>
        </el-form>
    </div>
    <el-alert v-if="notes.length === 0" type="error" :closable="false">Заметки отсутствуют</el-alert>
    <el-scrollbar v-else height="220">
        <div v-for="note in notes"
             class="rounded p-2 relative border border-solid border-neutral-200 dark:border-neutral-700 mb-1">
            <div class="absolute top-1 right-2 z-10">
                <el-button @click="deleteNote(note)" size="small" type="danger" circle plain>
                    <Icon icon="material-symbols:delete-rounded" />
                </el-button>
            </div>
            <div class="text-xs opacity-70">
                {{ note.created_at }}
            </div>
            {{ note.text }}
        </div>
    </el-scrollbar>
</template>

<script>
import FormItem from "../../components/UI/Form/FormItem.vue";
import {ElMessage} from "element-plus";
import HandleErrorsMixin from "../../Shared/Mixins/HandleErrorsMixin";

export default {
    name: "NoteWidget",
    components: {FormItem},
    mixins: [HandleErrorsMixin],
    props: {
        data: null,
    },
    data() {
        return {
            errors: [],
            loading: false,
            text: '',
            notes: this.data.notes
        }
    },
    methods: {
        store() {
            if (!this.loading) {
                this.loading = true
                this.errors = []
                axios.post(route('admin.widget.note.store'), {
                    text: this.text,
                }).then((response) => {
                    this.text = ''
                    this.notes = response.data.data
                }).catch((errors) => {
                    this.handleErrors(errors)
                }).finally(() => {
                    this.loading = false
                })
            }
        },
        deleteNote(note) {
            axios.delete(route('admin.widget.note.delete', note.id)).then((response) => {
                this.notes = response.data.data
            }).catch((errors) => {
                this.handleErrors(errors)
            })
        }
    }
}
</script>

<style scoped>

</style>
