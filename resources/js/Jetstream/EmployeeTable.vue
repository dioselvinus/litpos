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
            <table-head>Full Name</table-head>
            <table-head>Email</table-head>
            <table-head>Created At</table-head>
            <table-head>Updated At</table-head>
        </template>

        <template #tbody="{ row }">
            <table-body>
                <div class="flex items-center">
                    <img
                        :src="
                            row.profile_photo_path
                                ? getImage(row.profile_photo_path)
                                : row.profile_photo_url
                        "
                        class="w-8 h-8 rounded-full mr-2"
                        :alt="row.name"
                    />
                    {{ row.name }}
                </div>
            </table-body>

            <table-body v-text="row.email" />

            <table-body>
                {{ new Date(row.created_at).toISOString().substring(0, 10) }}
            </table-body>
            <table-body>
                {{ new Date(row.updated_at).toISOString().substring(0, 10) }}
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
export default defineComponent({
    components: {
        TableBody,
        TableHead,
        DataTable,
    },
    setup() {
        const tableData = ref([]);
        const isLoading = ref(false);
        const pagination = ref({});
        const loadData = async (query) => {
            isLoading.value = true;
            const {
                data: { data, totalEmployee },
            } = await axios.get("/api/employee", {
                params: {
                    page: query.page - 1 < 0 ? 0 : query.page - 1,
                    size: query.per_page,
                    search: query.search,
                },
            });
            tableData.value = data;
            pagination.value = {
                ...pagination.value,
                page: query.page,
                total: totalEmployee,
            };
            isLoading.value = false;
        };
        const getImage = (url) => window._.replace(url, /(^images)/gm, "/storage/images");

        return { tableData, pagination, loadData, getImage };
    },
});
</script>
