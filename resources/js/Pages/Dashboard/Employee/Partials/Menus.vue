<template>
    <template v-if="errored">unfortune</template>
    <template v-else>
        <template v-if="loading">product is loading...</template>
        <template v-for="product in filteredProducts" :key="product.id">
            <div
                class="bg-white shadow-xl cursor-pointer rounded-lg w-48 h-48 relative overflow-hidden group"
                v-if="
                    (product.status == 'available' &&
                        filter != null &&
                        filter == 'all') ||
                    filter == product.category
                "
                v-on:click="selectMenu(product.id)"
            >
                <img
                    :src="getImage(product.image)"
                    :alt="product.name"
                    class="object-cover h-full w-full"
                />
                <div
                    class="absolute w-full py-2.5 bottom-0 inset-x-0 bg-blue-400 text-white text-center leading-4 group-hover:hidden transition-all duration-300 ease-in-out"
                >
                    <h1 class="text-small">
                        {{ product.name }}
                    </h1>
                    <h3 class="text-xs">
                        {{ setPrice(product.price) }}
                    </h3>
                </div>
            </div>
        </template>
    </template>
</template>
<script>
import { defineComponent } from "vue";
export default defineComponent({
    props: {
        filter: String,
        search: String,
    },
    data: () => {
        return {
            products: null,
            errored: false,
            loading: true,
        };
    },
    methods: {
        getImage: (url) =>
            window._.replace(url, /(^images)/gm, "/storage/images"),
        setPrice: (price) =>
            new Intl.NumberFormat(["ban", "id"], {
                style: "currency",
                currency: "IDR",
            }).format(price),

        selectMenu: function (id) {
            // get basket from session storage if basket is empty, create new basket else, add product to basket
            let basket = window.sessionStorage.getItem("basket");
            if (basket == null) {
                basket = {};
            } else {
                basket = JSON.parse(basket);
            }

            if (basket[id] == null) {
                basket[id] = {
                    product: this.products.find((product) => product.id == id),
                    quantity: 1,
                };
            } else {
                basket[id] = {
                    product: this.products.find((product) => product.id == id),
                    quantity: basket[id].quantity + 1,
                };
            }
            window.sessionStorage.setItem("basket", JSON.stringify(basket));
        },
    },
    computed: {
        filteredProducts: function () {
            if (this.search == null || this.search == "") {
                return this.products;
            }

            return this.products.filter(
                (product) =>
                    product.name
                        .toLowerCase()
                        .indexOf(this.search.toLowerCase()) > -1
            );
        },
    },
    mounted() {
        window.axios
            .get(`api/products`)
            .then((response) => {
                this.products = response.data;
            })
            .catch((error) => console.log(error))
            .finally(() => (this.loading = false));
    },
});
</script>
