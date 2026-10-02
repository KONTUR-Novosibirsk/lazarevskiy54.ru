import {defineStore} from 'pinia'

export const useEditorStore = defineStore('editor', {
    state: () => ({editor: null}),
    actions: {
        setActiveEditor(editor) {
            this.editor = editor
        },
        insertImage(url) {
            let content = '<img src="' + url + '">';
            this.insertContent(content)
        },
        insertLink(name, url) {
            let content = '<a href="' + url + '">' + name + '</a>';
            this.insertContent(content)
        },
        insertContent(content) {
            let viewFragment = this.editor.data.processor.toView(content);
            let modelFragment = this.editor.data.toModel(viewFragment);
            this.editor.model.insertContent(modelFragment);
        }
    },
})
