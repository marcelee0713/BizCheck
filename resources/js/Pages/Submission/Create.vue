<script setup lang="ts">
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import { ProfileData, SocialLinks } from "@/types/types";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SubmissionHeading from "@/Features/Submission/Components/SubmissionHeading.vue";
import {
    EvaluationForm,
    EvaluationStructure,
} from "@/Features/Submission/types/submission-type";
import FormSlider from "@/Features/Submission/Components/FormSlider.vue";
import GeneralInformationForm from "@/Features/Submission/Components/Forms/GeneralInformationForm.vue";
import ObjectiveAndChallengesForm from "@/Features/Submission/Components/Forms/ObjectiveAndChallengesForm.vue";
import CompetitorsForm from "@/Features/Submission/Components/Forms/CompetitorsForm.vue";
import MetricsAndInsightsForm from "@/Features/Submission/Components/Forms/MetricsAndInsightsForm.vue";
import OverAllForm from "@/Features/Submission/Components/Forms/OverAllForm.vue";

const props = defineProps<{
    profile: ProfileData;
    socialLinks: SocialLinks[];
}>();

const form = useForm<EvaluationForm>({
    title: "",
    description: "",
    challenges: [],
    objectives: [],
    competitors: [],
    directCompetitors: [],
    indirectCompetitors: [],
    metrics: [],
    additionalInsights: [],
});

const index = ref<number>(0);

const slides: EvaluationStructure[] = [
    {
        id: 0,
        name: "General Information",
        component: GeneralInformationForm,
        props: {
            form,
        },
    },
    {
        id: 1,
        name: "Objectives & Challenges",
        component: ObjectiveAndChallengesForm,
        props: {
            objectives: form.objectives,
            challenges: form.challenges,
        },
    },
    {
        id: 2,
        name: "Competitors",
        component: CompetitorsForm,
        props: {
            directCompetitors: form.directCompetitors,
            indirectCompetitors: form.indirectCompetitors,
        },
    },
    {
        id: 3,
        name: "Metrics & Insights",
        component: MetricsAndInsightsForm,
        props: {
            additionalInsights: form.additionalInsights,
            metrics: form.metrics,
        },
    },
    {
        id: 4,
        component: OverAllForm,
        description:
            "Please review your responses before submitting the evaluation. Any invalid input will be removed.",
        props: {
            form: form,
            profile: props.profile,
            socialLinks: props.socialLinks,
        },
    },
];

const onChangeIndex = (i: number) => {
    index.value = i;
};

const onClickLeft = () => {
    if (index.value === 0) return;

    index.value--;
};

const onClickRight = () => {
    if (index.value === slides.length - 1) return;

    index.value++;
};
</script>

<template>
    <Head title="Submission" />

    <AuthenticatedLayout>
        <main
            class="flex flex-1 gap-5 mx-auto container py-5 justify-center font-montserrat"
        >
            <div
                class="flex-1 flex flex-col gap-3 h-full max-w-[710px] max-h-full"
            >
                <div class="flex-1 flex flex-col gap-3">
                    <div
                        class="flex flex-col gap-3 bg-secondary px-6 py-5 rounded-lg max-h-[750px]"
                        :class="{ '!h-full': index === 4 }"
                    >
                        <SubmissionHeading
                            :page-name="slides[index].name"
                            :description="slides[index].description"
                        />
                        <component
                            :is="slides[index].component"
                            v-model="slides[index].props"
                            v-bind="slides[index].props"
                            :key="slides[index].id"
                        ></component>
                    </div>
                </div>

                <FormSlider
                    :arr="slides"
                    :onChangeIndex="onChangeIndex"
                    :onClickLeft="onClickLeft"
                    :onClickRight="onClickRight"
                    :current-index="index"
                />
            </div>
        </main>
    </AuthenticatedLayout>
</template>
