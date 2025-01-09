<script lang="ts" setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { SocialLinks } from "@/types/types";
import { isValidUrl } from "@/utils";
import { useForm } from "@inertiajs/vue3";

const props = defineProps<{
    socialLinks: SocialLinks[];
}>();

const initialData = (): SocialLinks[] => {
    return [
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
    ].map((defaultLink) => {
        const existingLink = props.socialLinks.find(
            (link) => link.platform === defaultLink.platform
        );

        return existingLink
            ? { ...defaultLink, link: existingLink.link }
            : defaultLink;
    });
};

const socialForm = useForm({
    social_links: initialData(),
});

const socialSubmit = () => {
    const validLinks = socialForm.social_links.map((val) => {
        if (!isValidUrl(val.link)) {
            return {
                ...val,
                link: "",
            };
        }

        return val;
    });

    socialForm.social_links = validLinks;

    socialForm.patch(route("social_links.update"));
};
</script>

<template>
    <div class="flex flex-col gap-5 bg-secondary p-4 rounded-md">
        <div class="flex flex-col">
            <div class="font-bold text-lg">Social Links</div>
            <div class="text-[13px]">Any invalid URL, will be ignored.</div>
        </div>

        <TextInput
            v-for="(social, index) in socialForm.social_links"
            :key="index"
            v-model="social.link"
            :label="
                social.platform.charAt(0).toUpperCase() +
                social.platform.slice(1)
            "
            type="url"
            :id="social.platform"
        />

        <PrimaryButton type="button" text="Submit" v-on:click="socialSubmit" />
    </div>
</template>
