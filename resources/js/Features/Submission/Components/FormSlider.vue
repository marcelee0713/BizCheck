<script setup lang="ts">
import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/vue/24/solid";

defineProps<{
    arr: any[];
    onChangeIndex: (i: number) => void;
    onClickLeft: () => void;
    onClickRight: () => void;
    currentIndex: number;
}>();
</script>
<template>
    <div class="flex justify-between h-[40px] items-center">
        <button
            v-on:click="onClickLeft"
            class="bg-primary h-full w-[40px] rounded-lg flex items-center justify-center"
        >
            <ChevronLeftIcon class="h-6 w-6 text-background" />
        </button>

        <div class="flex items-center gap-3">
            <div
                v-for="(slide, i) in arr"
                :key="i"
                class="w-3 h-3 border border-primary rounded-full cursor-pointer"
                :class="{ 'bg-primary': currentIndex === i }"
                v-on:click="onChangeIndex(i)"
            />
        </div>
        <button
            v-on:click="onClickRight"
            class="bg-primary h-full w-[40px] rounded-lg flex items-center justify-center"
        >
            <ChevronRightIcon class="h-6 w-6 text-background" />
        </button>
    </div>
</template>
