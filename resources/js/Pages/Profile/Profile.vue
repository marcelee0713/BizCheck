<script setup lang="ts">
import { ProfileData, SocialLinks } from "@/types/types";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { User } from "@/types";
import userPfp from "../../../../public/images/profile.png";
import TextComponent from "@/Features/Profile/TextComponent.vue";
import SocialLinksComponent from "@/Features/Profile/SocialLinksComponent.vue";

const props = defineProps<{
    auth: {
        user: User;
    };
    profile: ProfileData | null;
    socialLinks: SocialLinks[];
}>();
</script>

<template>
    <Head title="Profile" />
    <AuthenticatedLayout>
        <main
            class="flex flex-col flex-1 mx-auto container py-5 font-montserrat text-textColor items-center overflow-hidden"
        >
            <div
                class="w-full max-w-[710px] flex flex-col gap-[20px] h-full px-6 py-4"
            >
                <div class="font-bold text-2xl">Profile</div>
                <div class="flex gap-5 items-center">
                    <img
                        :src="
                            props.auth.user.avatar
                                ? '/storage/' + props.auth.user.avatar
                                : userPfp
                        "
                        class="w-[150px] h-[150px] flex-shrink-0 bg-accent rounded-full drop-shadow-lg object-cover"
                    />

                    <div class="flex flex-col gap-1">
                        <div class="font-bold text-xl">
                            {{ props.auth.user.name }}
                        </div>
                        <div class="text-sm">{{ props.auth.user.email }}</div>
                    </div>
                </div>

                <hr />

                <div class="flex flex-col gap-5 overflow-y-auto" v-if="profile">
                    <TextComponent
                        :title="profile.business_name"
                        :text="profile.description"
                        class="text-2xl"
                    />

                    <TextComponent
                        title="Business Model"
                        :text="profile.business_model"
                    />

                    <TextComponent title="Industry" :text="profile.industry" />

                    <TextComponent
                        title="Industry"
                        :text="profile.target_audience"
                    />

                    <TextComponent
                        title="Unique Selling Point"
                        :text="profile.unique_selling_point"
                    />

                    <TextComponent
                        title="Phone number"
                        :text="profile.phone_number"
                    />

                    <TextComponent title="Location" :text="profile.location" />

                    <SocialLinksComponent :social-links="socialLinks" />
                </div>

                <div v-else class="flex flex-col gap-2 text-center text-sm">
                    <div>You haven't setup your Business Profile</div>
                    <Link
                        :href="route('profile.edit')"
                        type="button"
                        text="Set up"
                        class="hover:underline font-bold"
                    />
                </div>
            </div>
        </main>
    </AuthenticatedLayout>
</template>
