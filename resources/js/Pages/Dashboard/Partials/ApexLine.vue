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
    props: ["data", "title", "subtitle"],
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
    created() {
        this.chartOptions["title"] = {
            text: this.title,
            align: "left",
            offsetX: 20,
            offsetY: 10,
            style: {
                fontSize: "24px",
                fontWeight: "bold",
            },
        };
        this.chartOptions["subtitle"] = {
            text: this.subtitle,
            align: "left",
            offsetX: 20,
            offsetY: 40,
            style: {
                fontSize: "14px",
                color: "#666",
            },
        };
    },
});
</script>
