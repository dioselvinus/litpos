<template>
    <div class="min-h-screen grid grid-cols-3 bg-gray-100">
        <div class="min-h-screen col-span-2"></div>
        <div class="w-full bg-white shadow-md overflow-hidden sm:rounded-lg relative">
            <div class="h-screen px-6 py-4">
                <div class="py-10">
                    <slot name="logo" />
                </div>
                <slot />
            </div>
        </div>
    </div>
</template>
