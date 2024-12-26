<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Submission } from "@/Features/Submission/types/submission-type";
// TODO: Do the define props here, it will return an array of user's submissions

// may search and dateOrder ito ah, meron rin itong pagination.
// Tignan mo na lang yung ginawa ko doon sa practice-2 sa Laravel Practice repo ko

// /submissions
// In order to create a new submission go to route('submission.create')

// In order to delete a submission is gumamit ka ng Link Component at may parameter itong kinakailangan na ID at delete method ito.
// yung route niya is /submission/
// Mag bigay ka rin ng warning dito dahil pag na delete ito may mga madedelete na evaluations or chat

// At sa bawat item ng submission may option din siyang gumawa ng bagong evaluations.
// /evaluation/{id} is a way to call this route, yung id niyan is yung id ng submission ah.
</script>

<template>
    <Head title="Submissions" />
    <AuthenticatedLayout>
        <main>Submissions Page</main>
    </AuthenticatedLayout>
</template>
