<template>
    <template v-if="$page.props.user.roles[0].name === 'user'">
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
            <div
                class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-12 h-96 flex items-center"
            >
                <h1 class="text-2xl font-bold text-center">
                    403 | Kamu harus menghubungi manager atau admin agar
                    diberikan wewenang.
                </h1>
            </div>
        </app-layout>
    </template>

    <show-employee v-else-if="$page.props.user.roles[0].name === 'employee'" />
    <show-manager-admin v-else />
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import ShowEmployee from "@/Pages/Dashboard/Employee/Show";
import ShowManagerAdmin from "@/Pages/Dashboard/Show";

export default defineComponent({
    components: {
        AppLayout,
        ShowEmployee,
        ShowManagerAdmin,
    },
});
</script>
