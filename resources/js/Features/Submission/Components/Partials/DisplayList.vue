<script setup lang="ts">
defineProps<{
    head: string;
    lists: string[];
}>();
</script>

<template>
    <div class="flex flex-col gap-[5px] pr-3">
        <div class="text-lg font-bold">{{ head }}</div>
        <ul class="flex flex-col gap-2 list-disc list-outside ms-8">
            <li v-for="(e, i) in lists" :key="i">
                {{ e }}
            </li>
        </ul>
    </div>
</template>
