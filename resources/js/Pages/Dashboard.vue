<script setup lang="ts"></script>

<template>
    <Head title="Dashboard" />

    <div class="">{{ $page.props.auth.user }}</div>

    <Link :href="route('logout')" method="post" as="button" type="button"
        >Log out</Link
    >
</template>
