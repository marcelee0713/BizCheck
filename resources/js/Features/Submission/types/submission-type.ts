import { Component } from "vue";

type GeneralInformation = {
    title: string;
    description: string;
};

type Competitors = {
    type: "DIRECT" | "INDIRECT";
    name: string;
    description: string;
};

type Metrics = {
    name: string;
    value: number;
    description?: string;
};

interface EvaluationStructure {
    id: number;
    component: Component;
    name?: string;
    description?: string;
    props?: Record<string, any>;
}

interface EvaluationForm extends GeneralInformation {
    competitors?: Competitors[];
    directCompetitors?: Competitors[];
    indirectCompetitors?: Competitors[];
    metrics?: Metrics[];
    objectives?: string[];
    challenges?: string[];
    additionalInsights?: string[];
}

interface Submission {
    id: string;
    user_id: string;
    title: string;
    description: string;
    updated_at: Date | string;
    created_at: Date | string;
}

export type {
    GeneralInformation,
    EvaluationForm,
    Competitors,
    Metrics,
    EvaluationStructure,
    Submission,
};
