<script setup>
defineProps({
    title: {
        type: String,
        required: true,
    },
    items: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <div class="bg-[#19191C] rounded-lg p-6 space-y-4">
        <h2 class="text-white text-2xl font-bold font-montserrat">
            {{ title }}
        </h2>
        <ul class="space-y-3">
            <li
                v-for="(item, index) in items"
                :key="index"
                class="flex items-center"
            >
                <img
                    :src="'/assets/check-mark.png'"
                    alt="Check Icon"
                    class="h-8 w-8 mr-3"
                    loading="lazy"
                />
                <span class="text-white text-lg font-montserrat">{{
                    item
                }}</span>
            </li>
        </ul>
    </div>
</template>
