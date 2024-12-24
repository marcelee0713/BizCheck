<script setup lang="ts"></script>
<template>
    <div class="flex flex-col w-full h-full">
        <div class="w-full h-[55px] bg-secondary flex-shrink-0 z-10">
            <div
                class="flex justify-between items-center w-full h-full mx-auto container"
            >
                <Link
                    :href="route('dashboard')"
                    class="font-extrabold text-2xl font-montserrat"
                >
                    BIZ<span class="text-textColor">CHECK</span>
                </Link>
            </div>
        </div>

        <slot />
    </div>
</template>
