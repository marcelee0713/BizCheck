<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Evaluation } from "@/Features/Evaluation/types/evaluation-type";
// TODO: Do the define props here, it will return an array of user's Evaluations

// may dateOrder ito ah, meron rin itong pagination.
// Tignan mo na lang yung ginawa ko doon sa practice-2 sa Laravel Practice repo ko

// Itong page na ito is like yung messenger or parang listahan ng mga evaluations or chats mo.

// /evaluations/{id} get method is para makapunta sa convo

// /evaluations/{id} delete method is para madelete mo yung convo
</script>

<template>
    <Head title="Evaluations" />
    <AuthenticatedLayout>
        <main>Evaluations Page</main>
    </AuthenticatedLayout>
</template>
