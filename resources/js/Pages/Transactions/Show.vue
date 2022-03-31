<template>
    <app-layout title="Dashboard" class="max-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-12">
            <div class="my-5">
                <Link :href="route('dashboard')">
                    <jet-secondary-button class="!px-4 gap-2">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd"
                            />
                        </svg>
                        Back
                    </jet-secondary-button>
                </Link>
            </div>
            <div class="text-center">
                <div
                    class="bg-white rounded-lg shadow inline-flex p-5 w-[240px] h-[240px]"
                >
                    <qrcode-vue
                        :value="qrstring"
                        :size="200"
                        v-if="qrstring !== ''"
                    />
                </div>
                <span>
                    <p class="text-gray-600 text-sm pt-1">
                        Scan QR code ini untuk melanjutkan transaksi
                    </p>
                    <span
                        class="w-[300px] grid grid-cols-2 mx-auto text-left mt-5"
                    >
                        <p>Sub Total:</p>
                        <p>{{ setPrice(priceAll) }}</p>
                        <p>Ppn 10%:</p>
                        <p>{{ setPrice(Math.ceil(priceAll * 0.1)) }}</p>
                        <p>Total:</p>
                        <p>
                            {{ setPrice(priceAll + Math.ceil(priceAll * 0.1)) }}
                        </p>
                    </span>
                </span>
                <jet-danger-button
                    class="gap-2 mt-10"
                    v-on:click="canceled(qrid)"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                        />
                    </svg>
                    Cancel
                </jet-danger-button>
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
import QrcodeVue from "qrcode.vue";
import AppLayout from "@/Layouts/AppLayoutEmployee.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetSelect from "@/Jetstream/Select.vue";
import { Head, Link, usePage } from "@inertiajs/inertia-vue3";
export default defineComponent({
    components: {
        AppLayout,
        JetInput,
        JetSecondaryButton,
        JetSelect,
        JetDangerButton,
        Head,
        Link,
        QrcodeVue,
    },
    data: () => {
        return {
            priceAll: 0,
            qrstring: "",
            qrid: "",
        };
    },
    mounted() {
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

        window.axios
            .post("/api/transactions/new", {
                basket: basket,
                amount: this.priceAll + Math.ceil(this.priceAll * 0.1),
            })
            .then((response) => {
                this.qrstring = `${process.env.MIX_APP_URL}api/transactions/${response.data.external_id}/pay`;
                this.qrid = response.data.external_id;
                let check = () =>
                    window.axios
                        .post(
                            `/api/transactions/${response.data.external_id}/check`
                        )
                        .then((res) => {
                            if (res.data === "success") {
                                clearInterval(interval);
                                window.sessionStorage.removeItem("basket");
                                window.location.href = "/";
                            }
                        });
                let interval = setInterval(check, 500);
            });
    },
    methods: {
        canceled: (id) => {
            window.axios.post(`/api/transactions/${id}/cancel`).then((res) => {
                window.sessionStorage.removeItem("basket");
                window.location.href = "/";
            });
        },

        setPrice: (price) =>
            new Intl.NumberFormat(["ban", "id"], {
                style: "currency",
                currency: "IDR",
            }).format(price),
    },
});
</script>
