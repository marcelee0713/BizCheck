import { EvaluationForm } from "../types/submission-type";

const validateForm = (form: EvaluationForm): EvaluationForm => {
    const val: EvaluationForm = {
        title: form.title,
        description: form.description,
    };

    if (form.title.length > 100) form.title = form.title.substring(0, 100);

    if (form.description.length > 1000)
        val.description = form.description.substring(0, 1000);

    if (form.objectives && Array.isArray(form.objectives)) {
        val.objectives = form.objectives.filter((objective) =>
            objective.length > 150 ? objective.substring(0, 150) : objective
        );
    }

    if (form.challenges && Array.isArray(form.challenges)) {
        val.challenges = form.challenges.filter((challenge) =>
            challenge.length > 150 ? challenge.substring(0, 150) : challenge
        );
    }

    if (form.additionalInsights && Array.isArray(form.additionalInsights)) {
        val.additionalInsights = form.additionalInsights.filter((insight) =>
            insight.length > 150 ? insight.substring(0, 150) : insight
        );
    }

    if (form.directCompetitors) {
        const validDirectCompetitors = form.directCompetitors.filter(
            (competitor) => {
                const isValidName =
                    competitor.name && competitor.name.trim().length > 0;
                const isValidDescription =
                    competitor.description &&
                    competitor.description.trim().length > 0;
                return isValidName && isValidDescription;
            }
        );

        val.competitors = [
            ...(val.competitors || []),
            ...validDirectCompetitors,
        ];
    }

    if (form.indirectCompetitors) {
        const validIndirectCompetitors = form.indirectCompetitors.filter(
            (competitor) => {
                const isValidName =
                    competitor.name && competitor.name.trim().length > 0;
                const isValidDescription =
                    competitor.description &&
                    competitor.description.trim().length > 0;
                return isValidName && isValidDescription;
            }
        );

        val.competitors = [
            ...(val.competitors || []),
            ...validIndirectCompetitors,
        ];
    }

    if (form.metrics) {
        val.metrics = form.metrics.filter((metric) => {
            if (!metric.value || !metric.name) return false;

            const isValidName = metric.name && metric.name.trim().length > 0;
            const isValidValue =
                !isNaN(metric.value) &&
                metric.value !== undefined &&
                metric.value !== null;
            return isValidName && isValidValue;
        });
    }

    return val;
};

export { validateForm };
