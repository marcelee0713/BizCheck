<script setup lang="ts">
import { ProfileData, SocialLinks } from "@/types/types";
import { InertiaForm } from "@inertiajs/vue3";
import { EvaluationForm } from "../../types/submission-type";
import { validateForm } from "../../utils/validate-evaluation-form";
import BusinessInformation from "../Partials/BusinessInformation.vue";
import DisplayList from "../Partials/DisplayList.vue";
import DisplayCompetitorList from "../Partials/DisplayCompetitorList.vue";
import DisplayMetricList from "../Partials/DisplayMetricList.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps<{
    profile: ProfileData;
    socialLinks: SocialLinks[];
    form: InertiaForm<EvaluationForm>;
}>();

const form = validateForm(props.form.data());

const onClick = () => {
    console.log(form);
};
</script>

<template>
    <div class="flex flex-col gap-[25px] overflow-y-auto text-textColor">
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

        <PrimaryButton
            text="Save & Evaluate"
            type="button"
            :onClick="onClick"
        />
    </div>
</template>
