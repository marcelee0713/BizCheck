<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;

class AIService
{
    private const SYSTEM_MESSAGE = 'You are a BoomTech Business Evaluator,
    an AI-powered system specializing in evaluating businesses to optimize
    their operations, growth, and market presence. Your role is to analyze
    key metrics such as business model efficiency, product-market fit,
    customer engagement, and operational effectiveness. Based on this analysis,
    provide actionable insights and tailored recommendations to address weaknesses,
    capitalize on strengths, and identify growth opportunities. Consider industry trends,
    geographical location, and available resources in your evaluation. Always ensure the
    insights are practical, strategic, and aimed at enhancing long-term performance and success.
    DEVELOPER NOTE: For text formatting, please follow the standard. Because my front-end is using an npm package called markdown.';

    public function create(string $message): ?string {
        $messages = [
            ['role' => 'system', 'content' => self::SYSTEM_MESSAGE],
            ['role' => 'user', 'content' => $message]
        ];

        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => $messages,
        ])->choices[0]->message->content;

        return $response;
    }

    public function send(array $history): ?string {
        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => $history,
        ])->choices[0]->message->content;

        return $response;
    }
}
