<script setup lang="ts">
import AppendingList from "../Partials/AppendingList.vue";

const model = defineModel<{
    objectives: string[];
    challenges: string[];
}>({
    required: true,
});
</script>

<template>
    <div class="flex flex-col gap-[50px] overflow-y-auto">
        <AppendingList
            v-model="model.objectives"
            head="Objectives"
            text="What are your business objectives? Keep it short and simple."
        />

        <AppendingList
            v-model="model.challenges"
            head="Challenges"
            text="What challenges is your business facing? Keep it brief."
        />
    </div>
</template>
