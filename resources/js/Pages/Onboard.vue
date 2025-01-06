<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import { reactive } from "vue";
import PrimaryTextArea from "@/Components/PrimaryTextArea.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { isValidUrl } from "@/utils";
import PrimaryDropdown from "@/Components/PrimaryDropdown.vue";
import { BUSINESS_MODELS, INDUSTRIES } from "@/constants/global";
import { ProfileData, SocialLinks } from "@/types/types";

const socialLinks: SocialLinks[] = reactive([
    {
        platform: "facebook",
        link: "",
    },
    {
        platform: "instagram",
        link: "",
    },
    {
        platform: "twitter",
        link: "",
    },
    {
        platform: "linkedin",
        link: "",
    },
]);

const form = useForm<ProfileData>({
    business_name: "",
    business_model: "",
    industry: "",
    target_audience: "",
    unique_selling_point: "",
    location: "",
    phoneNumber: "",
    website_url: "",
    social_links: socialLinks,
    description: "",
});

const submit = () => {
    form.social_links = socialLinks.filter((val) => isValidUrl(val.link));

    form.post(route("profile.store"), {
        onSuccess: () => {
            window.location.href = route('submission.create')
        }
    });
};
const onSelectBusinessModel = (i: number) => {
    form.business_model = BUSINESS_MODELS[i];
};

const onSelectIndustries = (i: number) => {
    form.industry = INDUSTRIES[i];
};
</script>

<template>
    <Head title="Create Profile" />

    <AuthenticatedLayout>
        <main
            class="flex flex-col flex-1 gap-5 mx-auto container py-5 overflow-y-auto"
        >
            <div class="flex flex-col gap-1">
                <div class="font-bold text-2xl">
                    <span class="font-normal">Welcome</span>
                    {{ $page.props.auth.user.name }}!
                </div>

                <div class="text-textColor">
                    Filling out your Business Profile now will make things much
                    easier and faster for you during the upcoming evaluation.
                </div>

                <div class="text-sm text-accent">
                    You can always edit this information in your profile.
                </div>
            </div>

            <form @submit.prevent="submit" class="w-full flex flex-col gap-5">
                <div class="flex gap-5">
                    <TextInput
                        :err="form.errors.business_name"
                        :disabled="form.processing"
                        v-model="form.business_name"
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
                        :err="form.errors.business_model"
                    />

                    <PrimaryDropdown
                        label="Industry"
                        :arr="INDUSTRIES"
                        :onSelect="onSelectIndustries"
                        :err="form.errors.industry"
                    />
                </div>
                <div class="flex gap-5">
                    <TextInput
                        :err="form.errors.target_audience"
                        :disabled="form.processing"
                        v-model="form.target_audience"
                        label="Target Audience"
                        type="text"
                        id="target_audience"
                        class="flex-1"
                    />
                    <TextInput
                        :err="form.errors.unique_selling_point"
                        :disabled="form.processing"
                        v-model="form.unique_selling_point"
                        label="Unique Selling Point"
                        type="text"
                        id="unique_selling_point"
                        class="flex-1"
                    />
                </div>
                <div class="flex gap-5">
                    <TextInput
                        :err="form.errors.location"
                        :disabled="form.processing"
                        v-model="form.location"
                        label="Location"
                        type="text"
                        id="location"
                        class="flex-1"
                    />
                    <TextInput
                        :err="form.errors.phoneNumber"
                        :disabled="form.processing"
                        v-model="form.phoneNumber"
                        label="Phone Number"
                        type="number"
                        id="phone_number"
                        class="flex-1"
                    />
                </div>

                <PrimaryTextArea
                    :err="form.errors.description"
                    :disabled="form.processing"
                    v-model="form.description"
                    label="Business Description"
                    type="text"
                    textarea
                    id="description"
                />

                <div class="flex flex-col gap-5">
                    <div class="text-lg font-bold text-textColor">Links</div>
                    <TextInput
                        :err="form.errors.website_url"
                        :disabled="form.processing"
                        v-model="form.website_url"
                        label="Website URL"
                        type="text"
                        id="website_url"
                        class="flex-1"
                    />
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <TextInput
                        v-for="(social, index) in socialLinks"
                        :key="index"
                        :disabled="form.processing"
                        v-model="social.link"
                        :label="
                            social.platform.charAt(0).toUpperCase() +
                            social.platform.slice(1)
                        "
                        type="url"
                        :id="social.platform"
                    />
                </div>

                <PrimaryButton
                    text="Save"
                    :disabled="form.processing"
                    type="submit"
                />
            </form>
        </main>
    </AuthenticatedLayout>
</template>
