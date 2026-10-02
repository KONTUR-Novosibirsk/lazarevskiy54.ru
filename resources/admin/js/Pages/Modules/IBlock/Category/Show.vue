<template>
    <div class="mb-2">
        <Edit button-name="Добавить" :category="category.data"></Edit>
    </div>
    <IBlockList :info-blocks="infoBlocks" :categories="categories.data"/>
</template>

<script>
import MainLayout from "../../../../Layouts/MainLayout.vue";
import {useIBlockStore} from "../../../../stores/iblock";
import IBlockList from "../IBlockList.vue";
import Edit from "../Edit.vue";

export default {
    name: "Index",
    layout: MainLayout,
    components: {Edit, IBlockList},
    props: {
        categories: null,
        category: {
            type: Object,
            default: {},
        },
        infoBlocks: {
            type: Object,
            default: {},
        },
    },
    data() {
        return {
            IBlocksStore: useIBlockStore(),
        }
    },
}
</script>

<style scoped>

</style>
