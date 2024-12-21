<script setup lang="ts">
import GuestLayout from "@/Features/Auth/Layouts/GuestLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import PasswordFormat from "@/Features/Auth/Components/PasswordFormat.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => {
            form.reset("password", "password_confirmation");
        },
    });
};
</script>

<template>
    <Head title="Register" />
    <GuestLayout text="Register">
        <form @submit.prevent="submit" class="flex flex-col gap-5">
            <TextInput
                label="Name"
                id="name"
                type="text"
                v-model="form.name"
                :disabled="form.processing"
                :err="form.errors.name"
                autofocus
            />

            <TextInput
                label="Email"
                id="email"
                type="email"
                v-model="form.email"
                :disabled="form.processing"
                :err="form.errors.email"
            />

            <TextInput
                label="Password"
                id="password"
                type="password"
                v-model="form.password"
                :disabled="form.processing"
                :err="form.errors.password"
            />

            <TextInput
                label="Confirm Password"
                id="password_confirmation"
                type="password"
                v-model="form.password_confirmation"
                :disabled="form.processing"
                :err="form.errors.password_confirmation"
            />

            <PasswordFormat />

            <PrimaryButton
                text="Submit"
                type="submit"
                :disabled="form.processing"
            />
        </form>

        <Link
            :href="route('login')"
            class="text-accent self-center hover:underline text-sm"
        >
            Already registered?
        </Link>
    </GuestLayout>
</template>
