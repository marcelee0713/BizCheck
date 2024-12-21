<script setup lang="ts">
import Checkbox from "@/Components/Checkbox.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import GuestLayout from "@/Features/Auth/Layouts/GuestLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => {
            form.reset("password");
        },
    });
};
</script>

<template>
    <Head title="Log in" />
    <GuestLayout text="Log in">
        <form @submit.prevent="submit" class="flex flex-col gap-5">
            <TextInput
                :err="form.errors.email"
                :disabled="form.processing"
                v-model="form.email"
                label="Email"
                type="email"
                id="email"
                autofocus
            />

            <TextInput
                :err="form.errors.password"
                :disabled="form.processing"
                v-model="form.password"
                label="Password"
                type="password"
                id="password"
            />

            <div class="flex items-center gap-2 justify-between">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm text-accent"
                        >Keep me signed in</span
                    >
                </label>

                <Link
                    :href="route('password.request')"
                    class="text-sm text-accent hover:underline"
                    >Forgot your password?</Link
                >
            </div>

            <PrimaryButton
                text="SUBMIT"
                type="submit"
                :disabled="form.processing"
            />

            <Link
                :href="route('register')"
                class="text-accent self-center hover:underline text-sm"
                >Don't have an account?</Link
            >
        </form>
    </GuestLayout>
</template>
