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
        subtitle: {
            type: String,
            default: "ApexCharts",
        },
        title: {
            type: String,
            default: "Rp 0,00",
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

                title: {
                    text: "Rp. 0,00",
                    align: "left",
                    offsetX: 20,
                    offsetY: 10,
                    style: {
                        fontSize: "24px",
                        fontWeight: "bold",
                    },
                },
                subtitle: {
                    text: "Apexcharts",
                    align: "left",
                    offsetX: 20,
                    offsetY: 40,
                    style: {
                        fontSize: "14px",
                        color: "#666",
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
    watch: {
        title(newTitle, oldTitle) {
            this.chartOptions = {
                ...this.chartOptions,
                ...{
                    title: {
                        text: newTitle,
                        align: "left",
                        offsetX: 20,
                        offsetY: 10,
                        style: {
                            fontSize: "24px",
                            fontWeight: "bold",
                        },
                    },

                    subtitle: {
                        text: this.subtitle,
                        align: "left",
                        offsetX: 20,
                        offsetY: 40,
                        style: {
                            fontSize: "14px",
                            color: "#666",
                        },
                    },
                },
            };
        },
    },
});
</script>
