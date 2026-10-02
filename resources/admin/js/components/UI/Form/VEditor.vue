<template>
        <ckeditor :editor="editor" :model-value="modelValue ?? ''" class="el-input__wrapper"
                  @ready="onReady" @input="updateInput" @focus="setActiveEditor"></ckeditor>
</template>

<script>
import ClassicEditor from '../../../ckeditor/ckeditor';
import CKEditor from '@ckeditor/ckeditor5-vue';
import {useEditorStore} from "../../../stores/editor";

export default {
    name: "VEditor",
    components: {ckeditor: CKEditor.component},
    props: {
        label: {
            type: String,
            default: 'text',
        },
        name: String,
        modelValue: [String, Number],
        errors: {
            type: Array,
            default: null,
        }
    },
    data() {
        return {
            editor: ClassicEditor,
            readyEditor: null,
        }
    },
    methods: {
        onReady(useEditor) {
            this.$emit('onReady', useEditor);
            this.readyEditor = useEditor
            useEditorStore().setActiveEditor(useEditor)
        },
        setActiveEditor() {
            useEditorStore().setActiveEditor(this.readyEditor)
        },
        updateInput(text) {
            this.$emit('update:modelValue', text);
        }
    }
}
</script>

<style>
.ck-editor__editable {

    h1 {
        font-size: 42px;
        line-height: 120%;
    }

    h2 {
        font-size: 32px;
        line-height: 100%;
    }

    h3 {
        font-size: 24px;
        line-height: 100%;
    }

    h4 {
        font-size: 20px;
        line-height: 100%;
    }

    a {
        color: var(--el-color-primary);
        text-decoration: underline;
    }
}
</style>
