<template>
    <app-layout title="Dashboard" class="max-h-screen md:overflow-hidden">
        <div class="md:flex md:flex-row">
            <div>
                <div
                    class="mx-auto pt-6 pb-2 px-6 lg:px-8 flex justify-between items-center"
                >
                    <div class="flex">
                        <div class="relative">
                            <div
                                class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                    />
                                </svg>
                            </div>
                            <jet-input
                                @input="setSearch($event)"
                                type="text"
                                placeholder="search..."
                                class="w-20 sm:w-56 lg:w-96 pl-10 p-2.5"
                            />
                        </div>
                        <employee-filter-menu @clickFilter="onClickFilter" />
                        <employee-filter-menu @clickFilter="onClickFilter" />
                    </div>
                    <span id="time" class="font-bold"></span>
                </div>
                <div class="md:overflow-auto h-screen pb-40 overflow_menu">
                    <div
                        class="min-w-fit px-6 lg:px-8 flex flex-wrap gap-4 md:gap-1 lg:gap-4"
                    >
                        <employee-menu
                            v-bind:filter="filterMenu"
                            v-bind:search="search"
                        />
                    </div>
                </div>
            </div>

            <div class="min-h-screen min-w-max bg-white hidden md:block">
                <div
                    class="py-6 sm:px-2 lg:px-4 min-w-max h-[calc(100vh-4rem)] flex flex-col justify-between"
                >
                    <jet-select v-bind:options="options"></jet-select>
                    <div
                        class="mt-3 mb-2 overflow-auto overflow_menu w-[20rem] h-screen"
                    >
                        <employee-menu-selected />
                    </div>
                    <jet-button class="w-full !p-4">
                        Charge {{ setPrice(priceAll) }}
                    </jet-button>
                </div>
            </div>
        </div>
    </app-layout>
</template>
<style scoped>
.overflow_menu::-webkit-scrollbar {
    display: none;
}
</style>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayoutEmployee.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetSelect from "@/Jetstream/Select.vue";
import EmployeeMenu from "@/Pages/Dashboard/Employee/Partials/Menus.vue";
import EmployeeFilterMenu from "@/Pages/Dashboard/Employee/Partials/Filter.vue";
import EmployeeMenuSelected from "@/Pages/Dashboard/Employee/Partials/MenuSelected.vue";

export default defineComponent({
    components: {
        AppLayout,
        JetInput,
        JetButton,
        JetSelect,
        EmployeeMenu,
        EmployeeFilterMenu,
        EmployeeMenuSelected,
    },
    data: () => {
        return {
            options: ["Dine In", "Take Away"],
            filterMenu: "all",
            search: null,
            priceAll: 0,
        };
    },
    mounted: function () {
        this.updateTime();
        setInterval(this.updateTime, 1000);
        this.getChargePrice();
        setInterval(this.getChargePrice, 500);
    },
    methods: {
        getChargePrice: function () {
            let basket = window.sessionStorage.getItem("basket")
                ? JSON.parse(window.sessionStorage.getItem("basket"))
                : [];
            if (basket) {
                this.priceAll = 0;
                window._.forEach(basket, (item) => {
                    this.priceAll +=
                        window._.toInteger(item.product.price) *
                        window._.toInteger(item.quantity);
                });
            }
        },

        setSearch: function (e) {
            this.search = e.target.value;
        },

        setPrice: (price) =>
            new Intl.NumberFormat(["ban", "id"], {
                style: "currency",
                currency: "IDR",
            }).format(price),

        onClickFilter: function (e) {
            if (e.filterFood) {
                this.filterMenu = "food";
            } else if (e.filterDrink) {
                this.filterMenu = "drink";
            } else {
                this.filterMenu = null;
            }
            if (e.filterFood && e.filterDrink) {
                this.filterMenu = "all";
            }
        },

        updateTime: function () {
            const now = new Date();
            const time = now.toLocaleTimeString(undefined, {
                hour: "2-digit",
                minute: "2-digit",
            });
            const date = now.toLocaleDateString(undefined, {
                weekday: "long",
                month: "long",
                day: "numeric",
            });
            this.$el.querySelector("#time").innerText = `${time} ${date}`;
        },
    },
});
</script>
