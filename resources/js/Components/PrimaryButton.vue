<script setup lang="ts">
defineProps<{
    text: string;
    class?: string;
    type?: "button" | "submit";
    onClick?: () => void;
    disabled?: boolean;
}>();
</script>

<template>
    <button
        class="h-[40px] bg-primary rounded-lg text-secondary font-bold tracking-wide px-3 py-2 transition-all duration-300 ease-out disabled:bg-accent hover:-translate-y-1"
        :class="class"
        :type="type ?? 'button'"
        :disabled="disabled"
    >
        {{ text }}
    </button>
</template>
