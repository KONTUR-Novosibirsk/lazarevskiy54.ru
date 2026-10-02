import {ElMessage} from "element-plus";

let unsecuredCopyToClipboard = (text) => {
    const textArea = document.createElement("textarea");
    textArea.value = text;
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
        document.execCommand('copy');
        ElMessage.success('Скопировано в буфер обмена')
    } catch (err) {
        ElMessage.error('Ошибка при копировании в буфер обмена')
    }
    document.body.removeChild(textArea);
}
export default {
    mounted(el, binding) {
        el.title = "Click to copy"
        el.addEventListener('click', () => {
            unsecuredCopyToClipboard(binding.value)
        })
    }
}
