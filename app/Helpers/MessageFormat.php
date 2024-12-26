<?php


namespace App\Helpers;

class MessageFormat {
    public static function formatFirstMessage($fields, $profile, $user, $socialLinks) {

        $message = "Hello, I am {$user->name}. I want your evaluation based on my information below.\n\n";

        $message .= "Business Information\n";
        $message .= "- Business Name: {$profile->business_name}\n";
        $message .= "- Business Model: {$profile->business_model}\n";
        $message .= "- Industry: {$profile->industry}\n";
        $message .= "- Unique Selling Point: {$profile->unique_selling_point}\n";
        $message .= "- Website URL: {$profile->website_url}\n";
        $message .= "- Target Audience: {$profile->target_audience}\n";
        $message .= "- Business Description: {$profile->description}\n\n";

        $message .= "Social Links\n";
        if ($socialLinks->isNotEmpty()) {
            foreach ($socialLinks as $link) {
                $message .= "- {$link->platform}: {$link->link}\n";
            }
        } else {
            $message .= "- No social links provided.\n";
        }
        $message .= "\n";

        $message .= "General Information\n";
        $message .= "- Title: {$fields['title']}\n";
        $message .= "- Description: {$fields['description']}\n\n";

        if (!empty($fields['objectives'])) {
            $message .= "Objectives\n";
            foreach ($fields['objectives'] as $objective) {
                $message .= "- {$objective}\n";
            }
            $message .= "\n";
        }

        if (!empty($fields['challenges'])) {
            $message .= "Challenges\n";
            foreach ($fields['challenges'] as $challenge) {
                $message .= "- {$challenge}\n";
            }
            $message .= "\n";
        }

        if (!empty($fields['competitors'])) {
            $message .= "Competitors\n";

            $directCompetitors = array_filter($fields['competitors'], fn($competitor) => $competitor['type'] === 'DIRECT');
            if (!empty($directCompetitors)) {
                $message .= "Direct Competitors:\n";
                foreach ($directCompetitors as $competitor) {
                    $message .= "- {$competitor['name']}: {$competitor['description']}\n";
                }
            }

            $indirectCompetitors = array_filter($fields['competitors'], fn($competitor) => $competitor['type'] === 'INDIRECT');
            if (!empty($indirectCompetitors)) {
                $message .= "Indirect Competitors:\n";
                foreach ($indirectCompetitors as $competitor) {
                    $message .= "- {$competitor['name']}: {$competitor['description']}\n";
                }
            }

            $message .= "\n";
        }

        if (!empty($fields['metrics'])) {
            $message .= "Metrics\n";
            foreach ($fields['metrics'] as $metric) {
                $message .= "- {$metric['name']}: {$metric['value']} ({$metric['description']})\n";
            }
            $message .= "\n";
        }

        if (!empty($fields['additionalInsights'])) {
            $message .= "Additional Insights\n";
            foreach ($fields['additionalInsights'] as $insight) {
                $message .= "- {$insight}\n";
            }
        }

        return $message;
    }
}
