<script setup lang="ts">
import { Metrics } from "../../types/submission-type";

defineProps<{
    head: string;
    lists: Metrics[];
}>();
</script>

<template>
    <div class="flex flex-col gap-[5px] pr-3">
        <div class="text-lg font-bold">{{ head }}</div>
        <ul class="flex flex-col gap-2 list-disc list-outside ms-8">
            <li v-for="(e, i) in lists" :key="i">
                <strong>{{ e.name }}</strong>
                <br />
                Value: <strong>{{ e.value }}</strong>
                <br />
                <span>
                    {{ e.description }}
                </span>
            </li>
        </ul>
    </div>
</template>
