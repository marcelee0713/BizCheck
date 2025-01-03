<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { User } from "@/types";
import { ProfileData, SocialLinks } from "@/types/types";
import { useForm } from "@inertiajs/vue3";
import { reactive, ref, watch } from "vue";
import userPfp from "../../../../public/images/profile.png";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ProfileSelector from "@/Features/Profile/UserForm/ProfileSelector.vue";
import TextInput from "@/Components/TextInput.vue";
import { BUSINESS_MODELS, INDUSTRIES } from "@/constants/global";
import PrimaryDropdown from "@/Components/PrimaryDropdown.vue";
import PrimaryTextArea from "@/Components/PrimaryTextArea.vue";

const props = defineProps<{
    auth: {
        user: User;
    };
    profile: ProfileData | null;
    socialLinks: SocialLinks[];
}>();

const haveChanges = ref<boolean>(false);

const userForm = useForm<{
    name: string;
    email: string;
    preview?: string | null;
    avatar?: string | File | null;
    removePic: boolean;
}>({
    name: props.auth.user.name,
    avatar: props.auth.user.avatar,
    email: props.auth.user.email,
    preview: props.auth.user.avatar,
    removePic: false,
});

const passForm = useForm({
    currentPassword: "",
    password: "",
    password_confirmation: "",
});

const profileForm = useForm<ProfileData>({
    business_name: props.profile ? props.profile.business_name : "",
    business_model: props.profile ? props.profile.business_model : "",
    industry: props.profile ? props.profile.industry : "",
    ...props.profile,
    social_links: props.socialLinks,
});

const socialLinks: SocialLinks[] = useForm([
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

const onChange = (e: Event): void => {
    const target = e.target as HTMLInputElement;

    if (target && target.files && target.files.length > 0) {
        userForm.avatar = target.files[0];
        userForm.preview = URL.createObjectURL(target.files[0]);
        userForm.removePic = false;
    }
};

const onRemovePic = () => {
    if (!userForm.avatar) return;

    userForm.removePic = true;
    userForm.avatar = null;
    userForm.preview = null;

    if (!props.auth.user.avatar) userForm.removePic = false;
};

watch(
    () => userForm,
    () => {
        haveChanges.value =
            userForm.name !== props.auth.user.name ||
            userForm.avatar !== props.auth.user.avatar ||
            userForm.removePic !== false;
    },
    { deep: true }
);

const userSubmit = () => {};

const passSubmit = () => {};

const profileSubmit = () => {};

const onSelectBusinessModel = (i: number) => {
    profileForm.business_model = BUSINESS_MODELS[i];
};

const onSelectIndustries = (i: number) => {
    profileForm.industry = INDUSTRIES[i];
};
</script>

<template>
    <Head title="Edit Profile" />
    <AuthenticatedLayout>
        <main
            class="flex flex-col flex-1 py-5 font-montserrat text-textColor items-center overflow-y-auto"
        >
            <div
                class="w-full max-w-[710px] flex flex-col gap-[20px] h-full px-6 py-4"
            >
                <div class="font-bold text-2xl">Edit Profile</div>

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
                        <div
                            class="text-sm cursor-pointer self-end hover:underline"
                        >
                            Change email
                        </div>
                    </div>

                    <PrimaryButton
                        type="submit"
                        text="Submit"
                        :disabled="!haveChanges"
                    />
                </form>

                <form
                    @submit.prevent="passSubmit"
                    class="flex flex-col gap-5 bg-secondary p-4 rounded-md"
                >
                    <div class="font-bold text-lg">Password</div>

                    <TextInput
                        id="currPass"
                        type="password"
                        label="Current Password"
                        v-model="passForm.currentPassword"
                        :disabled="passForm.processing"
                        :err:="passForm.errors.currentPassword"
                        autofocus
                        required
                    />

                    <TextInput
                        id="password"
                        type="password"
                        label="New Password"
                        v-model="passForm.password"
                        :disabled="passForm.processing"
                        :err:="passForm.errors.password"
                        autofocus
                        required
                    />

                    <TextInput
                        id="password_confirmation"
                        type="password"
                        label="Confirm New Password"
                        v-model="passForm.password_confirmation"
                        :disabled="passForm.processing"
                        :err:="passForm.errors.password_confirmation"
                        required
                    />

                    <div
                        class="text-accent text-[13px] w-full text-center font-bold"
                    >
                        This will log out all of signed in devices
                    </div>

                    <PrimaryButton type="submit" text="Submit" />
                </form>

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
                        :initial-index="
                            BUSINESS_MODELS.indexOf(profileForm.business_model)
                        "
                    />

                    <PrimaryDropdown
                        label="Industry"
                        :arr="INDUSTRIES"
                        :onSelect="onSelectIndustries"
                        :initial-index="
                            INDUSTRIES.indexOf(profileForm.industry)
                        "
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
                        :err="profileForm.errors.phoneNumber"
                        :disabled="profileForm.processing"
                        v-model="profileForm.phoneNumber"
                        label="Phone Number"
                        type="number"
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
            </div>
        </main>
    </AuthenticatedLayout>
</template>
