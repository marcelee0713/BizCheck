<script setup lang="ts">
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";

const passForm = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
});

const passSubmit = () => passForm.patch(route("password.update"));
</script>
<template>
    <form
        @submit.prevent="passSubmit"
        class="flex flex-col gap-5 bg-secondary p-4 rounded-md"
    >
        <div class="font-bold text-lg">Password</div>

        <TextInput
            id="current_password"
            type="password"
            label="Current Password"
            v-model="passForm.current_password"
            :err="passForm.errors.current_password"
            autofocus
            required
        />

        <TextInput
            id="password"
            type="password"
            label="New Password"
            v-model="passForm.password"
            :err="passForm.errors.password"
            autofocus
            required
        />

        <TextInput
            id="password_confirmation"
            type="password"
            label="Confirm New Password"
            v-model="passForm.password_confirmation"
            :err="passForm.errors.password_confirmation"
            required
        />

        <PrimaryButton type="submit" text="Submit" />
    </form>
</template>
