<template>
    <template v-for="(value, key) in session" :key="key">
        <div
            class="grid grid-flow-col-dense grid-cols-6 gap-2 mb-2 items-center overflow-hidden"
        >
            <span
                class="group relative h-10 w-10 bg-gray-100 shadow peer-hover:hidden rounded object-cover"
            >
                <img
                    :src="getImage(value.product.image)"
                    :alt="value.product.name"
                    class="absolute inset-0 h-10 w-10 group-hover:brightness-50 rounded shadow"
                />
                <button
                    class="absolute inset-0 w-full h-full flex rounded justify-center items-center text-transparent group-hover:text-white"
                    @click="removeSession(value.product.id)"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </button>
            </span>
            <div
                class="peer w-28 hover:w-auto hover:col-span-5 ml-2 group col-span-3"
            >
                <h1
                    class="font-semibold text-small truncate group-hover:text-clip"
                >
                    {{ value.product.name }}
                </h1>
                <p class="text-xs truncate group-hover:text-clip">
                    {{ setPrice(value.product.price) }}
                </p>
            </div>
            <jet-input
                @input="changeSession(value.product.id, $event)"
                type="number"
                class="!w-16 peer-hover:hidden col-span-2"
                :value="value.quantity"
                min="1"
            />
        </div>
    </template>
</template>
<script>
import { defineComponent } from "vue";
import JetInput from "@/Jetstream/Input.vue";
import JetButton from "@/Jetstream/Button.vue";

export default defineComponent({
    components: {
        JetInput,
        JetButton,
    },
    data: () => {
        return {
            session: [],
        };
    },
    mounted() {
        this.setSession();
        setInterval(this.setSession, 500);
    },
    methods: {
        setSession: function () {
            this.session = window.sessionStorage.getItem("basket")
                ? JSON.parse(window.sessionStorage.getItem("basket"))
                : [];
        },
        getImage: (url) =>
            window._.replace(url, /(^public\/images)/gm, "/storage/images"),
        setPrice: (price) =>
            new Intl.NumberFormat(["ban", "id"], {
                style: "currency",
                currency: "IDR",
            }).format(price),
        removeSession: function (id) {
            let basket = window.sessionStorage.getItem("basket");
            if (basket == null) {
                basket = {};
            } else {
                basket = JSON.parse(basket);
            }
            delete basket[id];
            window.sessionStorage.setItem("basket", JSON.stringify(basket));
        },
        changeSession: function (id, quantity) {
            let basket = window.sessionStorage.getItem("basket");
            if (basket == null) {
                basket = {};
            } else {
                basket = JSON.parse(basket);
            }
            basket[id]["quantity"] = window._.toInteger(quantity.target.value);
            window.sessionStorage.setItem("basket", JSON.stringify(basket));
        },
    },
});
</script>
