<template>
    <template v-for="(value, key) in transactions" :key="key">
        <div
            class="md:rounded dark:bg-gray-900/70 block hover:shadow-lg transition-shadow duration-500 bg-white border border-gray-100 dark:border-gray-900 mb-6 last:mb-0"
        >
            <!---->
            <div class="p-6">
                <div class="justify-between items-center block md:flex">
                    <div
                        class="flex shrink-1 grow-9 items-center justify-center mb-6 md:mb-0"
                    >
                        <div class="justify-start items-center block md:flex">
                            <div
                                class="flex shrink-1 grow-9 items-center justify-center mb-6 md:mb-0"
                            >
                                <span
                                    :class="[
                                        'inline-flex justify-center items-center w-12 h-12 rounded-full dark:bg-gray-800 md:mr-6 bg-gray-50',
                                        value.status === 'failed'
                                            ? 'text-red-600'
                                            : value.status === 'pending'
                                            ? 'text-blue-600'
                                            : value.status === 'success'
                                            ? 'text-yellow-600'
                                            : '',
                                    ]"
                                    ><svg
                                        viewBox="0 0 24 24"
                                        width="24"
                                        height="24"
                                        class="inline-block"
                                    >
                                        <path
                                            fill="currentColor"
                                            d="M3,22L4.5,20.5L6,22L7.5,20.5L9,22L10.5,20.5L12,22L13.5,20.5L15,22L16.5,20.5L18,22L19.5,20.5L21,22V2L19.5,3.5L18,2L16.5,3.5L15,2L13.5,3.5L12,2L10.5,3.5L9,2L7.5,3.5L6,2L4.5,3.5L3,2M18,9H6V7H18M18,13H6V11H18M18,17H6V15H18V17Z"
                                        ></path></svg
                                    ><!----></span
                                >
                            </div>
                            <div
                                class="flex shrink-1 grow-9 items-center justify-center"
                            >
                                <div
                                    class="text-center space-y-1 md:text-left md:mr-6"
                                >
                                    <h4 class="text-xl">
                                        {{ setPrice(value.total) }}
                                    </h4>
                                    <p class="text-gray-500 dark:text-gray-400">
                                        <b>5 days ago</b> via
                                        {{ value.payment ?? "QRIS" }} -
                                        {{ value.user.name }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex shrink-1 grow-9 items-center justify-center"
                    >
                        <div class="text-center md:text-right space-y-1">
                            <div>
                                <div
                                    class="inline-flex items-center capitalize border py-0.5 px-2 text-xs rounded-lg bg-blue-600 text-white border-blue-700 mr-1.5 last:mr-0"
                                >
                                    <!----><span>{{
                                        getFiveId(value.id)
                                    }}</span>
                                </div>
                                <div
                                    :class="[
                                        'inline-flex items-center capitalize border py-0.5 px-2 text-xs rounded-lg text-white mr-1.5 last:mr-0',
                                        value.status === 'failed'
                                            ? 'bg-red-600 border-red-600'
                                            : value.status === 'pending'
                                            ? 'bg-blue-600 border-blue  -600'
                                            : value.status === 'success'
                                            ? 'bg-yellow-600 border-yellow-600'
                                            : '',
                                    ]"
                                >
                                    <!----><span>{{
                                        value.status === "success"
                                            ? "invoice"
                                            : value.status
                                    }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!---->
        </div>
    </template>
</template>
<script>
import { defineComponent } from "vue";
export default defineComponent({
    data() {
        return {
            transactions: null,
        };
    },
    mounted() {
        window.axios.get("/api/transactions/hot").then((response) => {
            this.transactions = response.data;
        });
    },
    methods: {
        setPrice: (price) =>
            new Intl.NumberFormat(["ban", "id"], {
                style: "currency",
                currency: "IDR",
            }).format(price),
        getFiveId: (id) => window._.split(id, "-", 1)[0],
    },
});
</script>
