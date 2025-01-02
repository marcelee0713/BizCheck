<script setup lang="ts">
import { ProfileData, SocialLinks } from "@/types/types";
import { InertiaForm, router } from "@inertiajs/vue3";
import { EvaluationForm } from "../../types/submission-type";
import { validateForm } from "../../utils/validate-evaluation-form";
import BusinessInformation from "../Partials/BusinessInformation.vue";
import DisplayList from "../Partials/DisplayList.vue";
import DisplayCompetitorList from "../Partials/DisplayCompetitorList.vue";
import DisplayMetricList from "../Partials/DisplayMetricList.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { ref } from "vue";
import { defineProps } from "vue";

const props = defineProps<{
    profile: ProfileData;
    socialLinks: SocialLinks[];
    form: InertiaForm<EvaluationForm>;
}>();

const form = validateForm(props.form.data());
const isLoading = ref(false);

const onSaveAndEvaluate = () => {
    isLoading.value = true;
    router.post(
        route("submission.store.evaluate"),
        {
            ...form,
        },
        {
            onFinish: () => {
                isLoading.value = false;
            },
        }
    );
};
</script>
<template>
    <div
        class="relative flex flex-col gap-[25px] overflow-y-auto text-textColor"
    >
        <!-- Loading indicator -->
        <div
            v-if="isLoading"
            class="absolute top-[-10px] left-0 right-0 h-1 bg-primary-yellow animate-loading-line z-50"
        ></div>

        <BusinessInformation
            :profile="props.profile"
            :social-links="socialLinks"
        />

        <DisplayList
            head="General Information"
            :lists="[form.title, form.description]"
        />

        <DisplayList
            v-if="form.objectives"
            head="Objectives"
            :lists="form.objectives"
        />

        <DisplayList
            v-if="form.challenges"
            head="Challenges"
            :lists="form.challenges"
        />

        <DisplayCompetitorList
            head="Direct Competitors"
            v-if="props.form.directCompetitors"
            :lists="props.form.directCompetitors"
        />

        <DisplayCompetitorList
            head="Indirect Competitors"
            v-if="props.form.indirectCompetitors"
            :lists="props.form.indirectCompetitors"
        />

        <DisplayMetricList
            head="Metrics"
            v-if="form.metrics"
            :lists="form.metrics"
        />

        <DisplayList
            v-if="form.additionalInsights"
            head="Additional Insights"
            :lists="form.additionalInsights"
        />

        <div class="flex justify-center items-center">
            <button
                type="button"
                @click="onSaveAndEvaluate"
                :disabled="isLoading"
                class="w-half bg-primary text-secondary font-bold py-2 px-4 rounded-md hover:bg-opacity-90 transition-all"
            >
                Save & Evaluate
            </button>
        </div>
    </div>
</template>
