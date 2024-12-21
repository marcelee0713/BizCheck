<script setup lang="ts">
import GuestLayout from "@/Features/Auth/Layouts/GuestLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import PasswordFormat from "@/Features/Auth/Components/PasswordFormat.vue";
import { Head, useForm } from "@inertiajs/vue3";

const props = defineProps<{
    email: string;
    token: string;
}>();

const form = useForm({
    token: props.token,
    email: props.email,
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("password.store"), {
        onFinish: () => {
            form.reset("password", "password_confirmation");
        },
    });
};
</script>

<template>
    <Head title="Reset Password" />

    <GuestLayout text="Reset Password">
        <form @submit.prevent="submit" class="flex flex-col gap-5">
            <TextInput
                id="email"
                type="email"
                label="Email"
                v-model="form.email"
                :disabled="form.processing"
                :err:="form.errors.email"
                autofocus
            />

            <TextInput
                id="password"
                type="password"
                label="New Password"
                v-model="form.password"
                :disabled="form.processing"
                :err:="form.errors.password"
                autofocus
                required
            />

            <TextInput
                id="password_confirmation"
                type="password"
                label="Confirm New Password"
                v-model="form.password_confirmation"
                :disabled="form.processing"
                :err:="form.errors.password_confirmation"
                required
            />

            <PasswordFormat />

            <PrimaryButton
                text="Reset password"
                type="submit"
                :disabled="form.processing"
            />
        </form>
    </GuestLayout>
</template>
