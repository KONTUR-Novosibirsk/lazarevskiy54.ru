<template>
    <div class="mb-3">
        <SliderFormComponent/>
    </div>
    <v-grid :pagination="false" :data="slidersData">
        <el-table-column width="70" prop="id" label="#" sortable/>
        <el-table-column prop="name" label="Название" sortable/>
        <el-table-column prop="code" label="Код" sortable>
            <template #default="prop">
                <el-tag type="info" v-clipboard="prop.row.code">{{ prop.row.code }}</el-tag>
            </template>
        </el-table-column>
        <el-table-column label="Управление">
            <template #default="prop">
                <Link :href="route('admin.slider.show', prop.row.id)"
                      class="el-button el-button--primary el-button--small">
                    Слайды
                </Link>
                <SliderFormComponent :slider="prop.row" :index="prop.$index" size="small"
                                     @update="updateSlider"/>
                <v-modal-delete :url="route('admin.slider.delete', prop.row.id)" :refresh="true"/>
            </template>
        </el-table-column>
    </v-grid>
</template>

<script>
import MainLayout from "../../../Layouts/MainLayout.vue";
import SliderFormComponent from "./Components/SliderFormComponent.vue";
import VGrid from "../../../components/UI/Data/VGrid.vue";
import VModalDelete from "../../../components/UI/Feedback/VModalDelete.vue";

export default {
    name: "Index",
    layout: MainLayout,
    props: {
        sliders: null,
    },
    data() {
        return {
            slidersData: this.sliders
        }
    },
    components: {VModalDelete, VGrid, SliderFormComponent},
    methods: {
        updateSlider(index, slider) {
            this.slidersData.data[index] = slider
        }
    }
}
</script>
