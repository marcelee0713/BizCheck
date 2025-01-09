<script setup lang="ts">
import PrimaryButton from "@/Components/PrimaryButton.vue";
import PrimaryDropdown from "@/Components/PrimaryDropdown.vue";
import PrimaryTextArea from "@/Components/PrimaryTextArea.vue";
import TextInput from "@/Components/TextInput.vue";
import { BUSINESS_MODELS, INDUSTRIES } from "@/constants/global";
import { ProfileData } from "@/types/types";
import { useForm } from "@inertiajs/vue3";

const props = defineProps<{
    profile: ProfileData | null;
}>();

const profileForm = useForm<ProfileData>({
    business_name: props.profile ? props.profile.business_name : "",
    business_model: props.profile ? props.profile.business_model : "",
    industry: props.profile ? props.profile.industry : "",
    ...props.profile,
    social_links: [],
});

const onSelectBusinessModel = (i: number) => {
    profileForm.business_model = BUSINESS_MODELS[i];
};

const onSelectIndustries = (i: number) => {
    profileForm.industry = INDUSTRIES[i];
};

const profileSubmit = () => profileForm.patch(route("profile.update"));
</script>

<template>
    <form
        @submit.prevent="profileSubmit"
        class="flex flex-col gap-5 bg-secondary p-4 rounded-md"
        id="business"
    >
        <div class="font-bold text-lg">Business Profile</div>

        <TextInput
            :err="profileForm.errors.business_name"
            :disabled="profileForm.processing"
            v-model="profileForm.business_name"
            label="Business Name"
            type="text"
            id="business_name"
            autofocus
            class="flex-1"
        />

        <PrimaryDropdown
            label="Business Model"
            :arr="BUSINESS_MODELS"
            :onSelect="onSelectBusinessModel"
            :err="profileForm.errors.business_model"
            :initial-index="BUSINESS_MODELS.indexOf(profileForm.business_model)"
        />

        <PrimaryDropdown
            label="Industry"
            :arr="INDUSTRIES"
            :onSelect="onSelectIndustries"
            :initial-index="INDUSTRIES.indexOf(profileForm.industry)"
        />

        <TextInput
            :err="profileForm.errors.target_audience"
            :disabled="profileForm.processing"
            v-model="profileForm.target_audience"
            label="Target Audience"
            type="text"
            id="target_audience"
            class="flex-1"
        />

        <TextInput
            :err="profileForm.errors.unique_selling_point"
            :disabled="profileForm.processing"
            v-model="profileForm.unique_selling_point"
            label="Unique Selling Point"
            type="text"
            id="unique_selling_point"
            class="flex-1"
        />

        <TextInput
            :err="profileForm.errors.location"
            :disabled="profileForm.processing"
            v-model="profileForm.location"
            label="Location"
            type="text"
            id="location"
            class="flex-1"
        />

        <TextInput
            :err="profileForm.errors.phone_number"
            :disabled="profileForm.processing"
            v-model="profileForm.phone_number"
            label="Phone Number"
            type="text"
            id="phone_number"
            class="flex-1"
        />

        <PrimaryTextArea
            :err="profileForm.errors.description"
            :disabled="profileForm.processing"
            v-model="profileForm.description"
            label="Business Description"
            type="text"
            textarea
            id="description"
        />

        <TextInput
            :err="profileForm.errors.website_url"
            :disabled="profileForm.processing"
            v-model="profileForm.website_url"
            label="Website URL"
            type="text"
            id="website_url"
            class="flex-1"
        />

        <PrimaryButton type="submit" text="Submit" />
    </form>
</template>
