<template>
    <app-layout title="Edit Product">
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
            <li class="inline-flex items-center">
                <a
                    :href="route('product')"
                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                >
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
                    Product
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
                        >Edit</span
                    >
                </div>
            </li>
        </template>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-12">
            <jet-form-section @submitted="updateProfileInformation">
                <template #title> Product Information </template>

                <template #description> Update product information. </template>

                <template #form>
                    <!-- Profile Photo -->
                    <div class="col-span-6 sm:col-span-4">
                        <!-- Profile Photo File Input -->
                        <input
                            type="file"
                            class="hidden"
                            ref="photo"
                            @change="updatePhotoPreview"
                        />

                        <jet-label for="photo" value="Photo" />

                        <!-- Current Profile Photo -->
                        <div class="mt-2" v-show="!photoPreview">
                            <img
                                :src="getImage(product.image)"
                                :alt="product.name"
                                class="h-20 w-20 object-cover"
                            />
                        </div>

                        <!-- New Profile Photo Preview -->
                        <div class="mt-2" v-show="photoPreview">
                            <span
                                class="block w-20 h-20 bg-cover bg-no-repeat bg-center"
                                :style="
                                    'background-image: url(\'' +
                                    photoPreview +
                                    '\');'
                                "
                            >
                            </span>
                        </div>

                        <jet-secondary-button
                            class="mt-2 mr-2"
                            type="button"
                            @click.prevent="selectNewPhoto"
                        >
                            Select A New Photo
                        </jet-secondary-button>

                        <jet-input
                            id="photo"
                            type="text"
                            class="mt-1 block w-full"
                            @input="updatePhotoPreview"
                            autocomplete="photoPreview"
                            ref="photo_url"
                        />

                        <jet-input-error
                            :message="form.errors.photo"
                            class="mt-2"
                        />
                    </div>

                    <!-- Name -->
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="name" value="Name" />
                        <jet-input
                            id="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.name"
                            autocomplete="name"
                        />
                        <jet-input-error
                            :message="form.errors.name"
                            class="mt-2"
                        />
                    </div>

                    <!-- Price -->
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="price" value="Price" />
                        <jet-input
                            id="price"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="form.price"
                            autocomplete="price"
                        />
                        <jet-input-error
                            :message="form.errors.price"
                            class="mt-2"
                        />
                    </div>

                    <!-- Category -->
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="category" value="Category" />
                        <jet-select
                            :options="optionsSelect"
                            :select="product.category"
                            @change="updateCategory"
                        />
                        <jet-input-error
                            :message="form.errors.category"
                            class="mt-2"
                        />
                    </div>

                    <!-- Status -->
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="status" value="Status" />
                        <jet-select
                            :options="optionsStatus"
                            :select="product.status"
                            @change="updateStatus"
                        />
                        <jet-input-error
                            :message="form.errors.status"
                            class="mt-2"
                        />
                    </div>
                </template>

                <template #actions>
                    <jet-action-message
                        :on="form.recentlySuccessful"
                        class="mr-3"
                    >
                        Saved.
                    </jet-action-message>

                    <jet-button
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Save
                    </jet-button>
                </template>
            </jet-form-section>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetTable from "@/Jetstream/ProductTable.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetNavLink from "@/Jetstream/NavLink.vue";
import JetDropdown from "@/Jetstream/Dropdown.vue";
import JetDropdownLink from "@/Jetstream/DropdownLink.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetSelect from "@/Jetstream/Select.vue";

export default defineComponent({
    components: {
        AppLayout,
        JetTable,
        JetSecondaryButton,
        JetNavLink,
        JetDropdown,
        JetDropdownLink,
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetSelect,
    },
    props: ["product"],
    data() {
        return {
            form: this.$inertia.form({
                _method: "PUT",
                name: this.product.name,
                price: this.product.price,
                category: this.product.category,
                status: this.product.status,
                photo: null,
            }),

            photoPreview: null,
            optionsSelect: ["Drink", "Food"],
            optionsStatus: ["Available", "Unavailable"],
        };
    },

    methods: {
        updateCategory(category) {
            this.form.category = category;
        },
        updateStatus(status) {
            this.form.status = status;
        },

        getImage: (url) =>
            window._.replace(url, /(^public\/images)/gm, "/storage/images"),
        setPrice: (price) =>
            new Intl.NumberFormat(["ban", "id"], {
                style: "currency",
                currency: "IDR",
            }).format(price),

        updateProfileInformation() {
            const exp =
                /https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&\/\/=]*)/gm;
            const regex = new RegExp(exp);

            if (this.$refs.photo) {
                if (
                    this.$refs.photo_url.$el.value ===
                    this.$refs.photo.files[0]?.name
                ) {
                    this.form.photo = this.$refs.photo.files[0];
                }
            }
            if (this.$refs.photo_url.$el.value.match(regex)) {
                this.form.photo = this.$refs.photo_url.$el.value;
            }
            this.form.post(
                route("products.update", { product: this.product.id }),
                {
                    errorBag: "updateProfileInformation",
                    preserveScroll: true,
                    onSuccess: () => this.clearPhotoFileInput(),
                }
            );
        },

        selectNewPhoto() {
            this.$refs.photo.click();
        },

        updatePhotoPreview({ type }) {
            if (type === "change") {
                const photo = this.$refs.photo.files[0];
                if (!photo) return;
                this.$refs.photo_url.$el.value = photo.name;
                const reader = new FileReader();

                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };

                reader.readAsDataURL(photo);
            } else if (type === "input") {
                this.clearPhotoFileInput();
                this.checkPhotoUrlInput();
            }
        },

        checkPhotoUrlInput() {
            const exp =
                /https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&\/\/=]*)/gm;
            const regex = new RegExp(exp);

            if (this.$refs.photo_url.$el.value.match(regex)) {
                this.photoPreview = this.$refs.photo_url.$el.value;
            } else {
                this.photoPreview = null;
            }
        },
        clearPhotoFileInput() {
            if (this.$refs.photo?.value) {
                this.$refs.photo.value = null;
            }
        },
    },
});
</script>
