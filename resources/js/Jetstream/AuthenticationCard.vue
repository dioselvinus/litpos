<template>
    <div class="min-h-screen lg:grid lg:grid-cols-3 bg-gray-100">
        <jet-banner class="relative hidden lg:block lg:col-span-2" />

        <div class="lg:hidden w-56 block py-10 mx-auto">
            <slot name="logo" />
        </div>
        <div
            class="mx-auto w-full sm:max-w-md lg:max-w-none bg-white shadow-md overflow-hidden sm:rounded-lg relative mb-8 lg:mb-0"
        >
            <div class="lg:h-screen px-6 py-4">
                <div class="hidden lg:block py-10">
                    <slot name="logo" />
                </div>
                <slot />
            </div>
        </div>
    </div>
</template>
<script>
import { defineComponent } from "vue";
import JetBanner from "@/Jetstream/AuthenticationCardBanner.vue";

export default defineComponent({
    components: {
        JetBanner,
    },
});
</script>
