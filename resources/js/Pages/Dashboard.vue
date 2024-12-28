<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <main class="flex flex-col flex-1">
            <div class="">{{ $page.props.auth.user }}</div>

            <Link
                :href="route('logout')"
                method="post"
                as="button"
                type="button"
                >Log out</Link
            >
        </main>
    </AuthenticatedLayout>
</template>
