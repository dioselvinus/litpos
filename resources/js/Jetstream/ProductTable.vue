<template>
    <data-table
        :rows="tableData"
        :pagination="pagination"
        :loading="isLoading"
        striped
        sn
        filter
        @loadData="loadData"
    >
        <template #thead>
            <table-head>Name</table-head>
            <table-head>Category</table-head>
            <table-head>Price</table-head>
            <table-head>Status</table-head>
            <table-head>Image</table-head>
            <table-head>Action</table-head>
        </template>

        <template #tbody="{ row }">
            <table-body v-text="row.name" />
            <table-body v-text="row.category" />
            <table-body v-text="setPrice(row.price)" />
            <table-body>
                <span class="bg-green-100 text-green-800 text-sm font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900" v-if="row.status === 'available'">{{ row.status }}</span>
                <span class="bg-red-100 text-red-800 text-sm font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900" v-else>{{row.status}}</span>
            </table-body>
            <table-body>
                <img
                    :src="getImage(row.image)"
                    class="w-16 h-16"
                    :alt="row.name"
                />
            </table-body>
            <table-body>
                <div class="space-x-2">
                    <jet-nav-link
                        :href="`/product/${row.id}/edit`"
                        as="a"
                        class="hover:!border-transparent focus:!border-transparent !p-0"
                    >
                        <jet-button> Edit </jet-button>
                    </jet-nav-link>

                    <jet-danger-button @click="deleteProduct(row.id)">
                        Delete
                    </jet-danger-button>
                </div>
            </table-body>
        </template>
    </data-table>
</template>
<style>
@import url("@jobinsjp/vue3-datatable/dist/style.css");
</style>
<script>
import { DataTable, TableBody, TableHead } from "@jobinsjp/vue3-datatable";
import { defineComponent, ref } from "vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetNavLink from "@/Jetstream/NavLink.vue";
import { notify } from "notiwind";

export default defineComponent({
    components: {
        TableBody,
        TableHead,
        DataTable,
        JetDangerButton,
        JetButton,
        JetNavLink,
        notify,
    },
    setup() {
        const tableData = ref([]);
        const isLoading = ref(false);
        const pagination = ref({});
        const loadData = async (query) => {
            isLoading.value = true;
            const {
                data: { data, totalProduct },
            } = await axios.get("/api/products", {
                params: {
                    page: query.page - 1 < 0 ? 0 : query.page - 1,
                    size: query.per_page ?? tableData.value.length,
                    search: query.search,
                },
            });
            tableData.value = data;
            pagination.value = {
                ...pagination.value,
                page: query.page,
                total: totalProduct,
            };
            isLoading.value = false;
        };
        const getImage = (url) => window._.replace(url, /(^public\/images)/gm, "/storage/images");
        const setPrice = (price) =>
            new Intl.NumberFormat(["ban", "id"], {
                style: "currency",
                currency: "IDR",
            }).format(price);

        const editProduct = (row) => {
            window.location.href = `/products/${row.id}/edit`;
        };

        const deleteProduct = (id) => {
            window.axios.delete(`/api/products/${id}`).then(() => {
                notify(
                    {
                        group: "warning",
                        title: "Deleted",
                        text: "Produk telah Dihapus!",
                        type: "delete",
                    },
                    4000
                );
                loadData(pagination.value);
            });
        };

        return {
            tableData,
            pagination,
            loadData,
            getImage,
            setPrice,
            editProduct,
            deleteProduct,
        };
    },
});
</script>
