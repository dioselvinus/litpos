<template>
    <vue-apex-charts :options="chartOptions" :series="series"></vue-apex-charts>
</template>
<script>
import { defineComponent } from "vue";
import VueApexCharts from "vue3-apexcharts";
export default defineComponent({
    components: {
        VueApexCharts,
    },
    props: {
        series: {
            type: Array,
            default: () => [
                {
                    name: "name",
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                },
            ],
        },
    },

    data() {
        return {
            chartOptions: {
                legend: {
                    show: false,
                },
                grid: {
                    show: false,
                    padding: {
                        right: 0,
                        left: 0,
                    },
                },
                dataLabels: {
                    enabled: false,
                },

                tooltip: {
                    enabled: false,
                },

                chart: {
                    type: "area",
                    zoom: {
                        enabled: false,
                    },
                    sparkline: {
                        enabled: true,
                    },
                },

                stroke: {
                    curve: "smooth",
                },

                fill: {
                    type: "gradient",
                    gradient: {
                        shadeIntensity: 0.9,
                        opacityFrom: 0.7,
                        opacityTo: 0.5,
                        stops: [0, 95, 100],
                    },
                },

                xaxis: {
                    categories: [
                        "Jan",
                        "Feb",
                        "Mar",
                        "Apr",
                        "May",
                        "Jun",
                        "Jul",
                        "Aug",
                        "Sep",
                        "Oct",
                        "Nov",
                        "Dec",
                    ],
                },
            },
        };
    },
});
</script>
