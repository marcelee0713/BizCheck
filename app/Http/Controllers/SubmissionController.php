<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmissionCreateRequest;
use App\Services\AIService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubmissionController extends Controller
{
    public function create(Request $request) {

        $profile = $request->user()->profile;

        $socialLinks = $profile->socialLinks()->get();

        return Inertia::render("Submission", [
            'profile' => $profile,
            'socialLinks' => $socialLinks
        ]);
    }

    public function storeAndEvaluate(SubmissionCreateRequest $request) {
        $fields = $request->validated();

        $user = $request->user();

        try {
            DB::beginTransaction();

            $profile = $user->profile;

            if (!$profile) return redirect()->back()->withErrors(['error' => 'Please complete your profile before proceeding.']);

            $socialLinks = $profile->socialLinks;

            $socialLinks = $socialLinks ?? [];

            $message = $this->formatFirstMessage($fields, $profile, $user, $socialLinks);

            $submission = $user->submissions()->create([
                'title' => $fields['title'],
                'description' => $fields['description'],
            ]);

            if (isset($fields['objectives'])) {
                $submission->objectives()->createMany(
                    array_map(function ($objective) {
                        return ['input' => $objective];
                    }, $fields['objectives'])
                );
            }


            if (isset($fields['additionalInsights'])) {
                $submission->insights()->createMany(
                    array_map(function ($insight) {
                        return ['input' => $insight];
                    }, $fields['additionalInsights'])
                );
            }

            if (isset($fields['challenges'])) {
                $submission->challenges()->createMany(
                    array_map(function ($challenge) {
                        return ['input' => $challenge];
                    }, $fields['challenges'])
                );
            }

            if (isset($fields['competitors'])) {
                $submission->competitors()->createMany(
                    collect($fields['competitors'])->map(function ($competitor) {
                        return [
                            'name' => $competitor['name'],
                            'type' => $competitor['type'],
                            'description' => $competitor['description'],
                        ];
                    })->toArray()
                );
            }

            if (isset($fields['metrics'])) {
                $submission->metrics()->createMany(
                    collect($fields['metrics'])->map(function ($metric) {
                        return [
                            'name' => $metric['name'],
                            'value' => $metric['value'],
                            'description' => $metric['description'],
                        ];
                    })->toArray()
                );
            }

            $evaluation = $user->evaluations()->create([
                'submission_id' => $submission->id,
            ]);

            $evaluation->responses()->create(['message' => $message, 'sender' => 'user']);

            $aiService = new AIService();

            $aiResponse = $aiService->create($message);

            $evaluation->responses()->create(['message' => $aiResponse, 'sender' => 'assistant']);

            DB::commit();

            return redirect()->route("evaluation.chat",['id' => $evaluation->id]);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Something went wrong while creating your profile. Please try again.']);
        }

    }

    private function formatFirstMessage($fields, $profile, $user, $socialLinks)
    {

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
