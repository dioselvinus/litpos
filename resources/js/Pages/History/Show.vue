<template>
    <template v-if="$page.props.user.roles[0].name === 'employee'">
        <app-layout-employee>
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

                <jet-table></jet-table>
            </div>
        </app-layout-employee>
    </template>
    <template v-else>
        <app-layout title="Table History">
            <template #breadcrumbs>
                <li class="inline-flex items-center">
                    <a
                        href="/"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
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
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg
                            class="w-6 h-6 text-gray-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                        <span
                            class="ml-1 text-sm font-medium text-gray-400 md:ml-2 dark:text-gray-500"
                            >Transactions History</span
                        >
                    </div>
                </li>
            </template>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-12">
                <div
                    class="mb-2 flex justify-end"
                    v-if="
                        $page.props.user.roles &&
                        $page.props.user.roles[0].name !== 'employee'
                    "
                >
                    <div class="inline-flex" role="group">
                        <jet-nav-link
                            :href="route('history.pdf')"
                            class="hover:!border-transparent focus:!border-transparent !p-0"
                        >
                            <jet-secondary-button
                                type="button"
                                class="focus:!ring-0 rounded-r-none"
                            >
                                Download
                            </jet-secondary-button>
                        </jet-nav-link>
                        <jet-dropdown align="right" width="48">
                            <template #trigger>
                                <button
                                    class="bg-white text-sm border p-2 focus:outline-none transition rounded-r-md active:bg-gray-50 shadow-sm border-gray-300 border-l-0"
                                >
                                    <svg
                                        class="h-4 w-4"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </template>

                            <template #content>
                                <!-- Account Management -->
                                <div
                                    class="block px-4 py-2 text-xs text-gray-400"
                                >
                                    Download As
                                </div>

                                <jet-dropdown-link
                                    :href="route('history.pdf')"
                                    as="a"
                                >
                                    PDF
                                </jet-dropdown-link>
                                <jet-dropdown-link
                                    :href="route('history.excel')"
                                    as="a"
                                >
                                    EXCEL
                                </jet-dropdown-link>
                            </template>
                        </jet-dropdown>
                    </div>
                </div>
                <jet-table></jet-table>
            </div>
        </app-layout>
    </template>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import AppLayoutEmployee from "@/Layouts/AppLayoutEmployee.vue";
import JetTable from "@/Jetstream/TransactionsTable.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetNavLink from "@/Jetstream/NavLink.vue";
import JetDropdown from "@/Jetstream/Dropdown.vue";
import JetDropdownLink from "@/Jetstream/DropdownLink.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
export default defineComponent({
    components: {
        AppLayout,
        AppLayoutEmployee,
        JetTable,
        JetSecondaryButton,
        JetNavLink,
        JetDropdown,
        JetDropdownLink,
        Link,
        Head,
    },
});
</script>
