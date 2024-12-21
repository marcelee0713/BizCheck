<script setup lang="ts">
import { User } from "@/types";

defineProps<{
    auth: {
        user: User;
    };
}>();
</script>

<template>
    <Head title="Welcome" />
    <main
        class="flex flex-col justify-center items-center w-full h-full gap-10"
    >
        <div class="font-extrabold text-6xl">
            BIZ<span class="text-textColor">CHECK</span>
        </div>

        <div v-if="!auth.user" class="flex gap-2">
            <Link :href="route('login')">Log in</Link>
            <Link :href="route('register')">Create an account</Link>
        </div>

        <Link v-else :href="route('dashboard')">Dashboard</Link>
    </main>
</template>
