<script setup lang="ts">
import { Metrics } from "../../types/submission-type";
import AppendingList from "../Partials/AppendingList.vue";
import MetricsList from "../Partials/MetricsList.vue";

const model = defineModel<{
    metrics: Metrics[];
    additionalInsights: string[];
}>({
    required: true,
});
</script>

<template>
    <div class="flex flex-col gap-[50px] overflow-y-auto">
        <MetricsList
            head="Metrics"
            text="Share key performance indicators like revenue, growth rate, ROI, or break-even point to help evaluate your business's health and goals"
            v-model="model.metrics"
        />

        <AppendingList
            head="Additional Insights"
            text="Share any extra information that could help with the evaluation"
            v-model="model.additionalInsights"
        />
    </div>
</template>
