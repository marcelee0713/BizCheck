<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { User } from "@/types";
import { ProfileData, SocialLinks } from "@/types/types";
import UserForm from "@/Features/Profile/Forms/UserForm.vue";
import PasswordForm from "@/Features/Profile/Forms/PasswordForm.vue";
import BusinessForm from "@/Features/Profile/Forms/BusinessForm.vue";
import SocialForm from "@/Features/Profile/Forms/SocialForm.vue";

defineProps<{
    auth: {
        user: User;
    };
    profile: ProfileData | null;
    socialLinks: SocialLinks[];
}>();
</script>

<template>
    <Head title="Edit Profile" />
    <AuthenticatedLayout>
        <main
            class="flex flex-col flex-1 py-5 font-montserrat text-textColor items-center overflow-y-auto"
        >
            <div
                class="w-full max-w-[710px] flex flex-col gap-[20px] h-full px-6 py-4"
            >
                <div class="font-bold text-2xl">Edit Profile</div>

                <UserForm :auth="auth" />

                <PasswordForm />

                <BusinessForm :profile="profile" />

                <SocialForm :social-links="socialLinks" />
            </div>
        </main>
    </AuthenticatedLayout>
</template>
