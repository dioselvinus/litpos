<template>
    <app-layout title="Dashboard">
        <template #breadcrumbs>
            <li class="inline-flex items-center">
                <div
                    class="inline-flex items-center text-sm font-medium text-gray-700"
                >
                    <svg
                        class="mr-2 w-4 h-4"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"
                        ></path>
                    </svg>
                    Dashboard
                </div>
            </li>
        </template>
        <template #header>
            <jet-select v-bind:options="selectOption" class="w-36"></jet-select>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-12">
            <div class="flex justify-between gap-4">
                <div class="min-w-min w-96 bg-white shadow rounded">
                    <vue-apex-charts
                        :options="chartOptions"
                        :series="series"
                    ></vue-apex-charts>
                </div>
                <div class="min-w-min w-96 bg-white shadow rounded">
                    <vue-apex-charts
                        :options="chartOptions"
                        :series="series"
                    ></vue-apex-charts>
                </div>
                <div class="min-w-min w-96 bg-white shadow rounded">
                    <vue-apex-charts
                        :options="chartOptions"
                        :series="series"
                    ></vue-apex-charts>
                </div>
                <div class="min-w-min w-96 bg-white shadow rounded">
                    <vue-apex-charts
                        :options="chartOptions"
                        :series="series"
                    ></vue-apex-charts>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<style lang="postcss" scoped>
.vue-apexcharts {
    @apply font-sans max-h-max;
}
</style>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import VueApexCharts from "vue3-apexcharts";
import JetSelect from "@/Jetstream/Select.vue";

export default defineComponent({
    components: {
        AppLayout,
        VueApexCharts,
        JetSelect,
    },
    data: () => {
        const chartOptionsBase = {
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
        };

        return {
            selectOption: [
                {
                    id: 1,
                    name: "Dialy",
                },
                {
                    id: 2,
                    name: "Monthly",
                },
                {
                    id: 3,
                    name: "Yearly",
                },
            ],
            series: [
                {
                    name: "Desktops",
                    data: [10, 41, 35, 51, 49, 62, 69, 91, 148],
                },
            ],

            chartOptions: {
                ...chartOptionsBase,
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
                    text: "$1,000",
                    align: "left",
                    offsetX: 20,
                    offsetY: 10,
                    style: {
                        fontSize: "24px",
                        fontWeight: "bold",
                    },
                },
                subtitle: {
                    text: "Daily Sales",
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
});
</script>
