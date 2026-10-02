<template>
    <div>
        <h5 class="mb-5">Количество обращений по дням</h5>
        <div class="flex">
            <el-space>
                <el-segmented @change="saveLs" v-model="period" :options="periods" size="default"/>
                <el-color-picker @change="saveLs" v-model="color" color-format="hex"/>
            </el-space>
        </div>
        <apexchart
            height="270"
            type="area"
            :options="chartOptions"
            :series="series"
        ></apexchart>
    </div>
</template>

<script>
import VueApexCharts from "vue3-apexcharts";

export default {
    name: "FeedbackWidget",
    components: {
        apexchart: VueApexCharts,
    },
    props: {
        data: null,
    },
    data() {
        return {
            period: 'two_week',
            periods: [
                {label: 'Неделя', value: 'week'},
                {label: 'Две недели', value: 'two_week'},
                {label: 'Месяц', value: 'month'},
            ],
            color: '#c74220',
        }
    },
    mounted() {
        const lsData = JSON.parse(localStorage.getItem('FeedbackWidget'));
        if(lsData) {
            this.period = lsData['period'];
            this.color = lsData['color'];
        }
    },
    computed: {
        chartOptions() {
            return {
                chart: {
                    id: "vuechart-example",
                    toolbar: {
                        show: false,
                    },
                    animations: {
                        speed: 700,
                    },
                },
                xaxis: {
                    categories: this.data[this.period].category,
                    labels: {
                        style: {
                            fontSize: '9px',
                        },
                    },
                },
                dataLabels: {
                    enabled: false,
                },
            };
        },
        series() {
            return [
                {
                    name: "Количество обращений",
                    data: this.data[this.period].count,
                    color: this.color,
                },
            ];
        }
    },
    methods: {
        saveLs() {
            localStorage.setItem('FeedbackWidget', JSON.stringify({
                period: this.period,
                color: this.color,
            }))
        }
    }
}
</script>

<style scoped>

</style>
