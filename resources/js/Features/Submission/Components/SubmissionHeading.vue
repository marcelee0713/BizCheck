<script setup lang="ts">
withDefaults(
    defineProps<{
        pageName?: string;
        description?: string;
    }>(),
    {
        description:
            "Provide the necessary inputs to evaluate and give feedback on your business.",
    }
);
</script>

<template>
    <div class="flex gap-[10px] w-full items-center text-primary">
        <div class="text-3xl font-bold">Evaluation Form</div>
        <div class="h-1 w-1 bg-primary rounded-full" v-if="pageName" />
        <div class="text-xl" v-if="pageName">{{ pageName }}</div>
    </div>
    <div class="text-sm text-textColor">{{ description }}</div>
    <div class="border-b border-primary" />
</template>
