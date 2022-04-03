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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-12">
            <div>
                <div class="flex justify-between items-center py-3">
                    <span
                        class="font-bold text-xl flex items-center gap-3 ml-1"
                    >
                        <svg viewBox="0 0 24 24" class="h-6 w-6 inline-block">
                            <path
                                fill="currentColor"
                                d="M6,16.5L3,19.44V11H6M11,14.66L9.43,13.32L8,14.64V7H11M16,13L13,16V3H16M18.81,12.81L17,11H22V16L20.21,14.21L13,21.36L9.53,18.34L5.75,22H3L9.47,15.66L13,18.64"
                            ></path>
                        </svg>
                        Overview
                    </span>
                    <!-- <jet-select
                        v-bind:options="selectOption"
                        @change="handleSelectChange"
                        class="w-36"
                    ></jet-select> -->
                </div>
                <div class="flex justify-between gap-4">
                    <div class="min-w-min w-96 bg-white shadow rounded">
                        <apex-line
                            :series="getFilter(sales, 'sales')"
                            :title="getFilter(sales, 'sum')"
                            subtitle="Sales in last month"
                        ></apex-line>
                    </div>
                </div>
            </div>
            <div class="pt-36">
                <div class="flex gap-5">
                    <div class="w-full">
                        <div class="flex justify-between items-center py-3">
                            <span
                                class="font-bold text-xl flex items-center gap-3 ml-1"
                            >
                                <svg
                                    viewBox="0 0 24 24"
                                    class="h-6 w-6 inline-block"
                                >
                                    <path
                                        fill="currentColor"
                                        d="M3,14L3.5,14.07L8.07,9.5C7.89,8.85 8.06,8.11 8.59,7.59C9.37,6.8 10.63,6.8 11.41,7.59C11.94,8.11 12.11,8.85 11.93,9.5L14.5,12.07L15,12C15.18,12 15.35,12 15.5,12.07L19.07,8.5C19,8.35 19,8.18 19,8A2,2 0 0,1 21,6A2,2 0 0,1 23,8A2,2 0 0,1 21,10C20.82,10 20.65,10 20.5,9.93L16.93,13.5C17,13.65 17,13.82 17,14A2,2 0 0,1 15,16A2,2 0 0,1 13,14L13.07,13.5L10.5,10.93C10.18,11 9.82,11 9.5,10.93L4.93,15.5L5,16A2,2 0 0,1 3,18A2,2 0 0,1 1,16A2,2 0 0,1 3,14Z"
                                    ></path>
                                </svg>
                                Finance
                            </span>
                        </div>
                        <finance />
                    </div>
                    <div class="w-[50rem]">
                        <div class="flex justify-between items-center p-3">
                            <span
                                class="font-bold text-xl flex items-center gap-3 ml-1"
                            >
                                <svg
                                    viewBox="0 0 24 24"
                                    class="h-6 w-6 inline-block"
                                >
                                    <path
                                        fill="currentColor"
                                        d="M6,16.5L3,19.44V11H6M11,14.66L9.43,13.32L8,14.64V7H11M16,13L13,16V3H16M18.81,12.81L17,11H22V16L20.21,14.21L13,21.36L9.53,18.34L5.75,22H3L9.47,15.66L13,18.64"
                                    ></path>
                                </svg>
                                overview
                            </span>
                        </div>
                        <div
                            class="flex justify-between items-center p-3 md:rounded dark:bg-gray-900/70 hover:shadow-lg transition-shadow duration-500 bg-white border border-gray-100 dark:border-gray-900 mb-6 last:mb-0"
                        >
                            <div class="space-y-3">
                                <h4 class="text-gray-500 dark:text-gray-400">
                                    Invoice balance pending
                                </h4>
                                <h3 class="text-xl">
                                    {{
                                        setFinancialBalance(this.sum, "pending")
                                    }}
                                </h3>
                            </div>
                            <span
                                class="inline-flex justify-center items-center w-12 h-12 rounded-full bg-blue-600 text-white"
                            >
                                <svg
                                    viewBox="0 0 24 24"
                                    width="24"
                                    height="24"
                                    class="inline-block"
                                >
                                    <path
                                        fill="currentColor"
                                        d="M10 16V15H3L3 19C3 20.11 3.89 21 5 21H19C20.11 21 21 20.11 21 19V15H14V16H10M20 7H16V5L14 3H10L8 5V7H4C2.9 7 2 7.9 2 9V12C2 13.11 2.89 14 4 14H10V12H14V14H20C21.1 14 22 13.1 22 12V9C22 7.9 21.1 7 20 7M14 7H10V5H14V7Z"
                                    ></path>
                                </svg>
                                <!---->
                            </span>
                        </div>
                        <div
                            class="flex justify-between items-center p-3 md:rounded dark:bg-gray-900/70 hover:shadow-lg transition-shadow duration-500 bg-white border border-gray-100 dark:border-gray-900 mb-6 last:mb-0"
                        >
                            <div class="space-y-3">
                                <h4 class="text-gray-500 dark:text-gray-400">
                                    Invoice balance success
                                </h4>
                                <h3 class="text-xl">
                                    {{
                                        setFinancialBalance(this.sum, "success")
                                    }}
                                </h3>
                            </div>
                            <span
                                class="inline-flex justify-center items-center w-12 h-12 rounded-full bg-green-600 text-white"
                            >
                                <svg
                                    viewBox="0 0 24 24"
                                    width="24"
                                    height="24"
                                    class="inline-block"
                                >
                                    <path
                                        fill="currentColor"
                                        d="M10 16V15H3L3 19C3 20.11 3.89 21 5 21H19C20.11 21 21 20.11 21 19V15H14V16H10M20 7H16V5L14 3H10L8 5V7H4C2.9 7 2 7.9 2 9V12C2 13.11 2.89 14 4 14H10V12H14V14H20C21.1 14 22 13.1 22 12V9C22 7.9 21.1 7 20 7M14 7H10V5H14V7Z"
                                    ></path>
                                </svg>
                                <!---->
                            </span>
                        </div>
                        <div
                            class="flex justify-between items-center p-3 md:rounded dark:bg-gray-900/70 hover:shadow-lg transition-shadow duration-500 bg-white border border-gray-100 dark:border-gray-900 mb-6 last:mb-0"
                        >
                            <div class="space-y-3">
                                <h4 class="text-gray-500 dark:text-gray-400">
                                    Invoice balance failed
                                </h4>
                                <h3 class="text-xl">
                                    {{
                                        setFinancialBalance(this.sum, "failed")
                                    }}
                                </h3>
                            </div>
                            <span
                                class="inline-flex justify-center items-center w-12 h-12 rounded-full bg-red-600 text-white"
                            >
                                <svg
                                    viewBox="0 0 24 24"
                                    width="24"
                                    height="24"
                                    class="inline-block"
                                >
                                    <path
                                        fill="currentColor"
                                        d="M10 16V15H3L3 19C3 20.11 3.89 21 5 21H19C20.11 21 21 20.11 21 19V15H14V16H10M20 7H16V5L14 3H10L8 5V7H4C2.9 7 2 7.9 2 9V12C2 13.11 2.89 14 4 14H10V12H14V14H20C21.1 14 22 13.1 22 12V9C22 7.9 21.1 7 20 7M14 7H10V5H14V7Z"
                                    ></path>
                                </svg>
                                <!---->
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-20">
                <div class="flex justify-between items-center py-3">
                    <span
                        class="font-bold text-xl flex items-center gap-3 ml-1"
                    >
                        <svg viewBox="0 0 24 24" class="h-6 w-6 inline-block">
                            <path
                                fill="currentColor"
                                d="M11,2V22C5.9,21.5 2,17.2 2,12C2,6.8 5.9,2.5 11,2M13,2V11H22C21.5,6.2 17.8,2.5 13,2M13,13V22C17.7,21.5 21.5,17.8 22,13H13Z"
                            ></path>
                        </svg>
                        Employee Performance
                    </span>
                </div>
                <div class="flex flex-col">
                    <div class="overflow-x-auto shadow-md sm:rounded-lg">
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden">
                                <table
                                    class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700"
                                >
                                    <thead class="bg-gray-100 dark:bg-gray-700">
                                        <tr>
                                            <th
                                                scope="col"
                                                class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400"
                                            >
                                                Cashier Name
                                            </th>
                                            <th
                                                scope="col"
                                                class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400"
                                            >
                                                Graph Income
                                            </th>
                                            <th
                                                scope="col"
                                                class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400"
                                            >
                                                balance income
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700"
                                    >
                                        <tr
                                            class="hover:bg-gray-100 dark:hover:bg-gray-700"
                                        >
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                            >
                                                Apple Imac 27"
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white"
                                            >
                                                Desktop PC
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                            >
                                                $1999
                                            </td>
                                        </tr>
                                        <tr
                                            class="hover:bg-gray-100 dark:hover:bg-gray-700"
                                        >
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                            >
                                                Apple MacBook Pro 17"
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white"
                                            >
                                                Laptop
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                            >
                                                $2999
                                            </td>
                                        </tr>
                                        <tr
                                            class="hover:bg-gray-100 dark:hover:bg-gray-700"
                                        >
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                            >
                                                iPhone 13 Pro
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white"
                                            >
                                                Phone
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                            >
                                                $999
                                            </td>
                                        </tr>
                                        <tr
                                            class="hover:bg-gray-100 dark:hover:bg-gray-700"
                                        >
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                            >
                                                Apple Magic Mouse 2
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white"
                                            >
                                                Accessories
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                            >
                                                $99
                                            </td>
                                        </tr>
                                        <tr
                                            class="hover:bg-gray-100 dark:hover:bg-gray-700"
                                        >
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                            >
                                                Apple Watch Series 7
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white"
                                            >
                                                Accessories
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                            >
                                                $599
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
import Finance from "@/Pages/Dashboard/Partials/Finance.vue";
import ApexLine from "@/Pages/Dashboard/Partials/ApexLine.vue";

export default defineComponent({
    components: {
        AppLayout,
        VueApexCharts,
        JetSelect,
        Finance,
        ApexLine,
    },
    mounted() {
        window.axios
            .get("/api/transactions/sum")
            .then((res) => (this.sum = res.data));
        window.axios.get("/api/sales").then((res) => {
            this.sales = res.data;
        });
    },
    methods: {
        handleSelectChange(value) {
            this.selected = value;
        },
        setPrice: (price) =>
            new Intl.NumberFormat(["ban", "id"], {
                style: "currency",
                currency: "IDR",
            }).format(price),
        getFilter: (obj, val) =>
            window._.filter(obj, (item, key) => {
                if (key === val) {
                    return item;
                }
            })[0],
        setFinancialBalance: (obj, val) =>
            new Intl.NumberFormat(["ban", "id"], {
                style: "currency",
                currency: "IDR",
            }).format(
                window._.filter(obj, (item, key) => {
                    if (key === val) {
                        return item;
                    }
                })[0]
            ) === "RpNaN"
                ? "Rp 0,00"
                : new Intl.NumberFormat(["ban", "id"], {
                      style: "currency",
                      currency: "IDR",
                  }).format(
                      window._.filter(obj, (item, key) => {
                          if (key === val) {
                              return item;
                          }
                      })[0]
                  ),
    },
    data: () => {
        return {
            sum: null,
            sales: {},
            // selectOption: ["Dialy", "Monthly", "Yearly"],
            // selected: "Yearly",
        };
    },
});
</script>
