<script setup lang="ts">
defineProps<{
    title: string;
    text?: string;
}>();
</script>

<template>
    <div class="flex flex-col gap-1">
        <div class="font-bold">
            {{ title }}
        </div>
        <div class="text-sm" v-if="text">{{ text }}</div>
        <div class="text-sm italic text-gray-500" v-else="text">
            Not provided
        </div>
    </div>
</template>
