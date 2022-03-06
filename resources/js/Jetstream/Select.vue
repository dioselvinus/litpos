<template>
    <Listbox as="div" v-model="selected">
        <ListboxLabel
            class="block text-sm font-medium text-gray-700"
            v-if="$slots.label"
        >
            <slot name="label"></slot>
        </ListboxLabel>

        <div class="mt-1 relative">
            <ListboxButton
                class="relative w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-md"
            >
                <span class="block truncate">{{ selected.name }}</span>
                <span
                    class="ml-3 absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none"
                >
                    <SelectorIcon
                        class="h-5 w-5 text-gray-400"
                        aria-hidden="true"
                    />
                </span>
            </ListboxButton>

            <transition
                leave-active-class="transition ease-in duration-100"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <ListboxOptions
                    class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-56 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
                    id="options"
                >
                    <ListboxOption
                        as="template"
                        v-for="data in options"
                        :key="data.id"
                        :value="data"
                        v-slot="{ active, selected }"
                    >
                        <li
                            :class="[
                                active
                                    ? 'text-white bg-indigo-600'
                                    : 'text-gray-900',
                                'cursor-default select-none relative py-2 pl-3 pr-9',
                            ]"
                        >
                            <span
                                :class="[
                                    selected ? 'font-bold' : 'font-normal',
                                    'ml-3 block truncate',
                                ]"
                            >
                                {{ data.name }}
                            </span>
                        </li>
                    </ListboxOption>
                </ListboxOptions>
            </transition>
        </div>
    </Listbox>
</template>

<script>
import { ref, defineComponent } from "vue";
import {
    Listbox,
    ListboxButton,
    ListboxLabel,
    ListboxOption,
    ListboxOptions,
} from "@headlessui/vue";
import { SelectorIcon } from "@heroicons/vue/solid";

export default defineComponent({
    props: ["options"],
    components: {
        Listbox,
        ListboxButton,
        ListboxLabel,
        ListboxOption,
        ListboxOptions,
        SelectorIcon,
    },
    setup(props) {
        const selected = ref(props.options[0]);

        return {
            selected,
        };
    },
});
</script>
