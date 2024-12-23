<script setup lang="ts">
import { Competitors } from "../../types/submission-type";
import CompetitorsList from "../Partials/CompetitorsList.vue";

const model = defineModel<{
    directCompetitors: Competitors[];
    indirectCompetitors: Competitors[];
}>({
    required: true,
});
</script>

<template>
    <div class="flex flex-col gap-[50px] overflow-y-auto">
        <CompetitorsList
            head="Direct Competitors"
            text="Identify your main competitors and highlight what makes them stand out."
            v-model="model.directCompetitors"
            type="DIRECT"
        />

        <CompetitorsList
            head="Indirect Competitors"
            text="List businesses that offer alternative solutions and explain how they differ from yours."
            v-model="model.indirectCompetitors"
            type="INDIRECT"
        />
    </div>
</template>
