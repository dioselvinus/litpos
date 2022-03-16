<template>
    <show-cashier v-if="$page.props.user.roles[0].name === 'cashier'" />
    <show-manager-admin v-else />
</template>

<script>
import { defineComponent } from "vue";
import ShowManagerAdmin from "@/Pages/Dashboard/Show";
import ShowCashier from "@/Pages/Dashboard/Cashier/Show";

export default defineComponent({
    components: {
        ShowCashier,
        ShowManagerAdmin,
    },
});
</script>
