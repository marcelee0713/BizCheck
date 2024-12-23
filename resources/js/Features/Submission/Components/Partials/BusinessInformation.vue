<script setup lang="ts">
import { ProfileData, SocialLinks } from "@/types/types";
import { capitalize } from "@/utils";

const props = defineProps<{
    profile: ProfileData;
    socialLinks: SocialLinks[];
}>();
</script>
<template>
    <div class="flex flex-col gap-[5px] pr-3">
        <div class="text-lg font-bold">Business Information</div>
        <ul class="flex flex-col gap-2 list-disc list-outside ms-8">
            <li><strong>Business Name: </strong>{{ profile.business_name }}</li>
            <li>
                <strong>Business Model: </strong>{{ profile.business_model }}
            </li>
            <li><strong>Industry: </strong>{{ profile.industry }}</li>
            <li>
                <strong>Unique Selling Point: </strong
                >{{ profile.unique_selling_point }}
            </li>
            <li><strong>Website URL: </strong>{{ profile.website_url }}</li>
            <li>
                <strong>Target Audience: </strong>{{ profile.target_audience }}
            </li>
            <li>
                <strong>Business Description: </strong>{{ profile.description }}
            </li>
        </ul>
    </div>

    <div class="flex flex-col gap-[5px]">
        <div class="text-lg font-bold">Social Links</div>
        <ul class="flex flex-col gap-2 list-disc list-outside ms-8">
            <li v-for="({ link, platform }, i) in props.socialLinks" :key="i">
                <strong>{{ capitalize(platform) }}: </strong>
                <a :href="link" class="hover:underline">{{ link }}</a>
            </li>
        </ul>
    </div>
</template>
