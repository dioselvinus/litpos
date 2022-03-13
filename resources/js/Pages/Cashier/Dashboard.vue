<template>
    <app-layout title="Dashboard" class="max-h-screen overflow-hidden">
        <div class="grid grid-cols-3 md:grid-cols-5">
            <div class="col-span-2 md:col-span-4">
                <div
                    class="pt-6 pb-2 sm:px-6 lg:px-8 flex justify-between items-center"
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
                                class="md:w-96 pl-10 p-2.5"
                            />
                        </div>
                        <cashier-filter-menu @clickFilter="onClickFilter" />
                    </div>
                    <span id="time" class="font-bold"></span>
                </div>
                <div class="overflow-auto h-screen pb-40" id="menu_overflow">
                    <div
                        class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-5 gap-5"
                    >
                        <cashier-menu
                            v-bind:filter="filterMenu"
                            v-bind:search="search"
                        />
                    </div>
                </div>
            </div>
            <div class="min-h-screen bg-white col-span-1">
                <div class="pt-6 pb-2 sm:px-2 lg:px-4">
                    <jet-select v-bind:options="options"></jet-select>
                    <div class="pt-6 h-[28rem] overflow-hidden">
                        <cashier-menu-selected />
                    </div>
                    <jet-button class="w-full !p-5"
                        >Charge Rp 10.000,00</jet-button
                    >
                </div>
            </div>
        </div>
    </app-layout>
</template>
<style scoped>
#menu_overflow::-webkit-scrollbar {
    display: none;
}
</style>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayoutCashier.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetSelect from "@/Jetstream/Select.vue";
import CashierMenu from "@/Pages/Cashier/Partials/Menus.vue";
import CashierFilterMenu from "@/Pages/Cashier/Partials/Filter.vue";
import CashierMenuSelected from "@/Pages/Cashier/Partials/MenuSelected.vue";

export default defineComponent({
    components: {
        AppLayout,
        JetInput,
        JetButton,
        JetSelect,
        CashierMenu,
        CashierFilterMenu,
        CashierMenuSelected,
    },
    data: () => {
        return {
            options: [
                {
                    id: 1,
                    name: "Dine In",
                },
                {
                    id: 2,
                    name: "Take Away",
                },
            ],
            filterMenu: "all",
            search: null,
        };
    },
    mounted: function () {
        this.updateTime();
        setInterval(this.updateTime, 1000);
    },
    methods: {
        setSearch: function (e) {
            this.search = e.target.value;
        },
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
