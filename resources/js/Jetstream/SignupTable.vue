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
            <table-head>Role</table-head>
            <table-head>Action</table-head>
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
                <jet-select
                    :options="optionsRoles"
                    :select="row.roles[0].name"
                    @change="updateChangeRole(row.id, $event)"
                />
            </table-body>

            <table-body>
                <div class="space-x-2">
                    <jet-button @click="addUser(row.id)"> Submit </jet-button>
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
import JetButton from "@/Jetstream/Button.vue";
import JetSelect from "@/Jetstream/Select.vue";
import { notify } from "notiwind";

export default defineComponent({
    components: {
        TableBody,
        TableHead,
        DataTable,
        JetButton,
        JetSelect,
        notify,
    },
    data() {
        return {
            optionsRoles: ["Employee", "Manager"],
        };
    },
    setup() {
        const tableData = ref([]);
        const roles = ref({});
        const isLoading = ref(false);
        const pagination = ref({});
        const loadData = async (query) => {
            isLoading.value = true;
            const {
                data: { data, totalUser },
            } = await axios.get("/api/user/new", {
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
                total: totalUser,
            };
            isLoading.value = false;
        };
        const getImage = (url) =>
            window._.replace(url, /(^images)/gm, "/storage/images");

        const updateChangeRole = (id, value) => {
            roles.value[id] = value;
        };

        const addUser = (id) => {
            const role = roles.value[id]?? "Employee";
            window.axios
                .put(route("user.update", { user: id }), {
                    roles: role,
                })
                .then(() => {
                    loadData(pagination.value);
                    notify(
                        {
                            group: "warning",
                            title: "Accepted",
                            text: "User telah Diterima!",
                            type: "success",
                        },
                        4000
                    );
                });
        };

        return {
            tableData,
            pagination,
            loadData,
            getImage,
            isLoading,
            updateChangeRole,
            addUser,
        };
    },
});
</script>
