import {ElMessage} from "element-plus";

const errorHandler = (response) => {
    if (response.response['status'] === 422) {
        this.errors = response.response.data.errors
        ElMessage.error('Ошибка валидации, пожалйста исправьте неверные данные')
    } else if (response.response['status'] === 500) {
        ElMessage.error('Произошла внутренняя ошибка сервера')
    } else {
        ElMessage.error('Во время запроса произошла неизвестная ошибка')
    }
}

export {errorHandler};
