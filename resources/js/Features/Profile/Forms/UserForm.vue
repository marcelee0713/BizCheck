<script setup lang="ts">
import { User } from "@/types";
import { useForm } from "@inertiajs/vue3";
import userPfp from "../../../../../public/images/profile.png";
import { computed, ref } from "vue";
import ProfileSelector from "./Partials/ProfileSelector.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps<{
    auth: {
        user: User;
    };
}>();

const haveChanges = computed(() => {
    return (
        userForm.name !== props.auth.user.name ||
        userForm.avatar !== props.auth.user.avatar
    );
});

const userForm = useForm<{
    name: string;
    email: string;
    removePic: string;
    preview?: string | null;
    avatar?: File | null;
}>({
    name: props.auth.user.name,
    avatar: null,
    email: props.auth.user.email,
    preview: props.auth.user.avatar
        ? "/storage/" + props.auth.user.avatar
        : null,
    removePic: "0",
});

const onChange = (e: Event): void => {
    const target = e.target as HTMLInputElement;

    if (target && target.files && target.files.length > 0) {
        userForm.avatar = target.files[0];
        userForm.preview = URL.createObjectURL(target.files[0]);
        userForm.removePic = "0";
    }
};

const onRemovePic = () => {
    if (!userForm.avatar && !userForm.preview) return;

    userForm.removePic = "1";
    userForm.avatar = null;
    userForm.preview = null;

    if (!props.auth.user.avatar) userForm.removePic = "0";
};

const userSubmit = () => userForm.post(route("user.update"));
</script>
<template>
    <form
        @submit.prevent="userSubmit"
        class="flex flex-col gap-5 bg-secondary p-4 rounded-md"
    >
        <ProfileSelector
            :preview="userForm.preview ?? userPfp"
            :onRemove="onRemovePic"
            :onChange="onChange"
            :err="userForm.errors.avatar"
        />

        <TextInput
            label="Name"
            id="name"
            v-model="userForm.name"
            :err="userForm.errors.name"
        />

        <div class="flex flex-col gap-2">
            <TextInput
                label="Email"
                id="email"
                v-model="userForm.email"
                :disabled="true"
            />
            <div class="text-sm cursor-pointer self-end hover:underline">
                Change email
            </div>
        </div>

        <PrimaryButton
            type="submit"
            text="Submit"
            :disabled="!haveChanges || userForm.processing"
        />
    </form>
</template>
