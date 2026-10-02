<template>
    <h5 class="mx-3 mb-4">Последние опубликованные новости</h5>
    <el-alert v-if="data?.news.length === 0" type="error">Новости отсутствую</el-alert>
    <el-card v-for="news in newsData || []" body-class="p-2"
             class="mb-2 border !border-neutral-200 dark:!border-neutral-700" shadow="hover">
        {{ news.preview_text }}
        <div class="flex justify-between mt-1">
            <el-tag class="ms-2" type="primary">{{ news.publication_date }}</el-tag>
            <div class="">
                <a :href="route('news.show', news.alias)" class="el-button el-button--small">Подробнее...</a>
                <Link :href="route('admin.news.edit', news.id)" class="el-button el-button--primary el-button--small">
                    Изменить
                </Link>
            </div>
        </div>
    </el-card>
</template>
<script>
export default {
    name: "LastNews",
    props: {
        data: null,
        size: null,
    },
    mounted() {
        console.log(this.size);
    },
    computed: {
        newsData() {
            if (!this.data.news)
                return null;
            if (this.size > 1)
                return this.data.news.slice(0, 4);
            else
                return this.data.news.slice(0, 3);
        }
    },
}
</script>

<style scoped>

</style>
