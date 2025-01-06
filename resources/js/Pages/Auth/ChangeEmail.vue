<script setup lang="ts">
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import GuestLayout from "@/Features/Auth/Layouts/GuestLayout.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm } from "@inertiajs/vue3";

defineProps<{
    status?: string;
}>();

const form = useForm({
    email: "",
});

const submit = () => {
    form.post(route("change_email.store"));
};
</script>
<template>
    <Head title="Change Email" />

    <AuthenticatedLayout>
        <GuestLayout text="Change Email">
            <form @submit.prevent="submit" class="flex flex-col gap-5">
                <div
                    class="flex flex-col gap-2 text-sm text-textColor text-center"
                >
                    <p>
                        Looking to update your email address? Click below to
                        initiate the email change process and verify your new
                        address.
                    </p>

                    <p>
                        After a successful request. This will
                        <strong>log out all of your logged in devices.</strong>
                    </p>
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
                    text="Submit"
                    :disabled="form.processing"
                    type="submit"
                />
            </form>
        </GuestLayout>
    </AuthenticatedLayout>
</template>
