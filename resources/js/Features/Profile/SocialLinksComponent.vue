<script setup lang="ts">
import { SocialLinks } from "@/types/types";
import { capitalize } from "@/utils";
defineProps<{
    socialLinks: SocialLinks[];
}>();
</script>

<template>
    <div class="flex flex-col gap-1">
        <div class="font-bold">Social Links</div>
        <ul
            v-if="socialLinks.length"
            class="flex flex-col gap-2 list-disc list-outside ms-8"
        >
            <li v-for="({ link, platform }, i) in socialLinks" :key="i">
                <strong class="text-sm">{{ capitalize(platform) }}: </strong>
                <a :href="link" class="hover:underline">{{ link }}</a>
            </li>
        </ul>
        <div class="text-sm italic text-gray-500" v-else="text">
            Not provided
        </div>
    </div>
</template>
