<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import GuestLayout from "@/Features/Auth/Layouts/GuestLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps<{
    error?: string;
}>();
</script>
<template>
    <Head title="Change Email Verification" />

    <AuthenticatedLayout>
        <GuestLayout text="Change Email Verification">
            <div
                v-if="error"
                class="flex flex-col text-[13px] text-center bg-red-400 bg-opacity-25 rounded-lg text-red-400 p-3"
            >
                <div class="font-bold">An error occured</div>
                <div>{{ error }}</div>
            </div>
            <div v-else class="w-full text-center">
                This is an unexpected error.
            </div>

            <Link :href="route('change_email.create')" class="w-full">
                <PrimaryButton
                    text="GO TO CHANGE EMAIL"
                    type="submit"
                    class="w-full"
                />
            </Link>
        </GuestLayout>
    </AuthenticatedLayout>
</template>
