<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { ref } from "vue";

const verificationCode = ref("");
const verificationError = ref("");

const submitVerification = () => {
    // Reset previous error
    verificationError.value = "";

    // Validate verification code
    if (!verificationCode.value.trim()) {
        verificationError.value = "Please enter the verification code";
        return;
    }

    // Validate code length (assuming 6-digit code)
    if (verificationCode.value.trim().length !== 6) {
        verificationError.value = "Verification code must be 6 digits";
        return;
    }

    router.post(
        "/verify-update",
        { code: verificationCode.value },
        {
            onSuccess: () => {
                // Redirect to profile or show success message
                router.visit("/profile");
            },
            onError: (errors: any) => {
                // Handle verification error
                verificationError.value =
                    errors.message || "Verification failed";
                console.error(errors);
            },
        }
    );
};
</script>

<template>
    <Head title="Update Verification" />
    <AuthenticatedLayout>
        <main
            class="flex flex-1 gap-5 mx-auto container py-5 justify-center font-montserrat"
        >
            <div class="h-[370px] w-[500px] bg-secondary rounded-lg p-6">
                <h2 class="text-white text-2xl font-bold mb-4 text-center">
                    Verification
                </h2>

                <p class="text-white text-sm mb-6 text-center">
                    We've sent a verification code to your email. Please enter
                    the code below.
                </p>

                <!-- Error Message Display -->
                <div
                    v-if="verificationError"
                    class="text-red-500 text-sm mb-4 text-center"
                >
                    {{ verificationError }}
                </div>

                <form @submit.prevent="submitVerification" class="space-y-4">
                    <div>
                        <label
                            for="verification-code"
                            class="text-white block mb-2"
                        >
                            Verification Code
                        </label>
                        <input
                            id="verification-code"
                            v-model="verificationCode"
                            type="text"
                            placeholder="Enter 6-digit code"
                            class="w-full bg-transparent border-2 border-accent text-white rounded-md px-3 py-2 outline-none"
                        />
                    </div>

                    <div class="flex justify-center">
                        <button
                            type="submit"
                            class="bg-primary text-secondary font-bold py-2 px-6 rounded-md hover:bg-opacity-90 transition-all"
                        >
                            Verify
                        </button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <button
                        @click="router.visit('/profile')"
                        class="text-primary-yellow underline text-sm"
                    >
                        Back to Edit Profile
                    </button>
                </div>
            </div>
        </main>
    </AuthenticatedLayout>
</template>
