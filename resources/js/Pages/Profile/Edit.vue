<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { User } from "@/types";
import { ProfileData, SocialLinks } from "@/types/types";

const props = defineProps<{
    auth: {
        user: User;
    };
    profile: ProfileData | null;
    socialLinks: SocialLinks[];
}>();
</script>

<template>
    <Head title="Edit Profile" />
    <AuthenticatedLayout> </AuthenticatedLayout>
</template>
