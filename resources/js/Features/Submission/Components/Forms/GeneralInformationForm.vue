<script setup lang="ts">
import TextInput from "@/Components/TextInput.vue";
import PrimaryTextArea from "@/Components/PrimaryTextArea.vue";
import { EvaluationForm } from "../../types/submission-type";

const model = defineModel<{
    form: EvaluationForm;
}>({ required: true });
</script>

<template>
    <div class="flex flex-col gap-5">
        <TextInput
            autofocus
            label="Title"
            v-model="model.form.title"
            type="text"
            id="title"
        />
        <PrimaryTextArea
            autofocus
            label="Description"
            v-model="model.form.description"
            type="text"
            id="description"
        />
    </div>
</template>
