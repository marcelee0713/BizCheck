<script setup lang="ts">
import { ProfileData, SocialLinks } from "@/types/types";

// TODO: Do the define props here, it will return user's profile or business profile and also social media links
// It will return socialLinks and profile

// /profile
// In order to route here the name is route('profile')
// In order to update the profile data is call route('route.update')
// In order to delete the user is call route('route.destroy'); Mag pakita ka rin ng Password Prompt nito.
</script>

<template>
    <Head title="Edit Profile" />
    <AuthenticatedLayout>
        <main>Edit Profile Page</main>
    </AuthenticatedLayout>
</template>
