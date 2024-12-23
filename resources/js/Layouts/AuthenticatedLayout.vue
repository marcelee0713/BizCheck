<script setup lang="ts"></script>
<template>
    <div class="flex flex-col w-full h-full">
        <div class="h-[55px] bg-secondary">
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
