<script setup lang="ts">
import GuestLayout from "@/Features/Auth/Layouts/GuestLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, useForm } from "@inertiajs/vue3";

defineProps<{
    status?: string;
}>();

const form = useForm({
    email: "",
});

const submit = () => {
    form.post(route("password.email"));
};
</script>

<template>
    <Head title="Forgot Password" />

    <GuestLayout text="Forgot Password">
        <form @submit.prevent="submit" class="flex flex-col gap-5">
            <div class="text-sm text-textColor text-center">
                Forgot your password? No problem. Just let us know your email
                address and we will email you a password reset link that will
                allow you to choose a new one.
            </div>

            <div v-if="status" class="text-sm text-accent text-center">
                {{ status }}
            </div>

            <TextInput
                label="Email"
                id="email"
                type="email"
                v-model="form.email"
                :disabled="form.processing"
                :err="form.errors.email"
                autofocus
            />

            <PrimaryButton
                text="Email Password Reset Link"
                :disabled="form.processing"
                type="submit"
            />
        </form>
    </GuestLayout>
</template>
