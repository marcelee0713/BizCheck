<script setup lang="ts">
import { Link } from "@inertiajs/vue3";

defineProps<{
    text: string;
}>();
</script>

<template>
    <main
        class="flex flex-col gap-5 items-center justify-center w-full h-full mx-auto"
    >
        <Link :href="route('welcome')" class="font-extrabold text-5xl">
            BIZ<span class="text-textColor">CHECK</span>
        </Link>
        <div
            class="flex flex-col gap-5 w-[500px] min-w-[300px] h-auto bg-secondary rounded-lg shadow-lg py-3 px-5"
        >
            <div class="font-bold text-xl text-white text-center">
                {{ text }}
            </div>

            <slot />
        </div>
    </main>
</template>
