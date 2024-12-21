<script setup lang="ts">
import { computed } from "vue";
import GuestLayout from "@/Features/Auth/Layouts/GuestLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const props = defineProps<{
    status?: string;
}>();

const form = useForm({});

const submit = () => {
    form.post(route("verification.send"));
};

const verificationLinkSent = computed(
    () => props.status === "verification-link-sent"
);
</script>

<template>
    <Head title="Email Verification" />

    <GuestLayout text="Email Verification Notice">
        <div class="flex flex-col gap-5">
            <div class="text-sm text-textColor text-center">
                Thanks for signing up! Before getting started, could you verify
                your email address by clicking on the link we just emailed to
                you? If you didn't receive the email, we will gladly send you
                another.
            </div>

            <div
                class="text-sm text-accent text-center"
                v-if="verificationLinkSent"
            >
                A new verification link has been sent to the email address you
                provided during registration.
            </div>

            <form @submit.prevent="submit" class="w-full">
                <PrimaryButton
                    text="Resend Email Verification"
                    :disabled="form.processing"
                    type="submit"
                    class="w-full"
                />
            </form>

            <Link
                :href="route('logout')"
                method="post"
                as="button"
                type="button"
                :disabled="form.processing"
                class="text-accent self-center hover:underline text-sm"
            >
                Log out
            </Link>
        </div>
    </GuestLayout>
</template>
