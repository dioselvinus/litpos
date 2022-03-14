<template>
    <div id="default-carousel" data-carousel="slide">
        <div class="overflow-hidden h-screen relative">
            <div
                class="duration-700 ease-in-out absolute inset-0 transition-all transform translate-x-0 object-cover"
                data-carousel-item="active"
            >
                <span
                    class="block absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2 h-full bg-[url('https://source.unsplash.com/random/900x700/?market')] bg-no-repeat bg-cover"
                ></span>
            </div>

            <div
                class="duration-700 ease-in-out absolute inset-0 transition-all transform translate-x-full object-cover"
                data-carousel-item=""
            >
                <span
                    class="block absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2 h-full bg-[url('https://source.unsplash.com/random/900x700/?market')] bg-no-repeat bg-cover"
                ></span>
            </div>

            <div
                class="hidden duration-700 ease-in-out absolute inset-0 transition-all transform object-cover"
                data-carousel-item=""
            >
                <span
                    class="block absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2 h-full bg-[url('https://source.unsplash.com/random/900x700/?market')] bg-no-repeat bg-cover"
                ></span>
            </div>

            <div
                class="hidden duration-700 ease-in-out absolute inset-0 transition-all transform object-cover"
                data-carousel-item=""
            >
                <span
                    class="block absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2 h-full bg-[url('https://source.unsplash.com/random/900x700/?market')] bg-no-repeat bg-cover"
                ></span>
            </div>

            <div
                class="duration-700 ease-in-out absolute inset-0 transition-all transform -translate-x-full object-cover"
                data-carousel-item=""
            >
                <span
                    class="block absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2 h-full bg-[url('https://source.unsplash.com/random/900x700/?market')] bg-no-repeat bg-cover"
                ></span>
            </div>
        </div>

        <div class="flex absolute bottom-5 left-1/2 space-x-3 -translate-x-1/2">
            <button
                type="button"
                class="w-3 h-3 rounded-full bg-white dark:bg-gray-800"
                aria-current="true"
                aria-label="Slide 1"
                data-carousel-slide-to="0"
            ></button>
            <button
                type="button"
                class="w-3 h-3 rounded-full bg-white/50 dark:bg-gray-800/50 hover:bg-white dark:hover:bg-gray-800"
                aria-current="false"
                aria-label="Slide 2"
                data-carousel-slide-to="1"
            ></button>
            <button
                type="button"
                class="w-3 h-3 rounded-full bg-white/50 dark:bg-gray-800/50 hover:bg-white dark:hover:bg-gray-800"
                aria-current="false"
                aria-label="Slide 3"
                data-carousel-slide-to="2"
            ></button>
            <button
                type="button"
                class="w-3 h-3 rounded-full bg-white/50 dark:bg-gray-800/50 hover:bg-white dark:hover:bg-gray-800"
                aria-current="false"
                aria-label="Slide 4"
                data-carousel-slide-to="3"
            ></button>
            <button
                type="button"
                class="w-3 h-3 rounded-full bg-white/50 dark:bg-gray-800/50 hover:bg-white dark:hover:bg-gray-800"
                aria-current="false"
                aria-label="Slide 5"
                data-carousel-slide-to="4"
            ></button>
        </div>
    </div>
</template>
