<template>
    <jet-button
        class="w-12 !bg-white shadow !border-solid hover:bg-white active:bg-white rounded ml-2"
        @click="confirmFilter"
    >
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="w-12 text-gray-500 dark:text-gray-400"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"
            />
        </svg>
    </jet-button>

    <!-- <jet-action-message :on="form.recentlySuccessful" class="ml-3">
            Done.
        </jet-action-message> -->

    <jet-dialog-modal :show="popupFilter" @close="closeModal" :max-width="'md'">
        <template #title> Category Filter </template>

        <template #content>
            <div class="mt-4">
                <jet-label>
                    <jet-input
                        type="checkbox"
                        value="food"
                        ref="food"
                        :checked="foodSelected"
                        v-on:change="foodSelected = !foodSelected"
                    />
                    <span class="font-semibold"> Makanan </span>
                </jet-label>
                <jet-label>
                    <jet-input
                        type="checkbox"
                        ref="drink"
                        value="drink"
                        :checked="drinkSelected"
                        v-on:change="drinkSelected = !drinkSelected"
                    />
                    <span class="font-semibold"> Minuman </span>
                </jet-label>

                <jet-input-error class="mt-2" />
            </div>
        </template>

        <template #footer>
            <jet-secondary-button @click="closeModal">
                Cancel
            </jet-secondary-button>

            <jet-button class="ml-3" @click="confirmingFilter">
                Submit
            </jet-button>
        </template>
    </jet-dialog-modal>
</template>
<script>
import { defineComponent } from "vue";
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";

export default defineComponent({
    props: ["sessions"],

    components: {
        JetActionMessage,
        JetButton,
        JetDialogModal,
        JetSecondaryButton,
        JetInput,
        JetInputError,
        JetLabel,
    },

    data() {
        return {
            popupFilter: false,
            drinkSelected: true,
            foodSelected: true,
        };
    },
    emits: {
        clickFilter: {
            filterFood: true,
            filterDrink: true,
        },
    },
    methods: {
        confirmFilter() {
            this.popupFilter = true;
        },

        confirmingFilter() {
            this.$emit("clickFilter", {
                filterFood: this.foodSelected,
                filterDrink: this.drinkSelected,
            });
            this.closeModal();
        },

        closeModal() {
            this.popupFilter = false;
        },
    },
});
</script>
