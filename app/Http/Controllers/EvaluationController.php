<?php

namespace App\Http\Controllers;

use App\Models\Evaluations;
use App\Services\AIService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;


class EvaluationController extends Controller
{
    public function show($id) {

        $evaluation = Evaluations::findOrFail($id);

        $responses = $evaluation->responses()->orderBy('created_at', 'asc')->get();

        return Inertia::render("Evaluation", [
            'evaluation' => $evaluation,
            'responses' => $responses
        ]);
    }

    public function create(Request $request, $id) {
        $fields = $request->validate([
            'message' => ['required', 'string','max:12000']
        ]);

        try {
            DB::beginTransaction();

            $evaluation = Evaluations::find($id);

            $responses = $evaluation->responses;

            $history = $responses->map(function ($response) {
                return [
                    'role' => $response->sender,
                    'content' => $response->message
                ];
            })->toArray();

            $history[] = [
                'role' => 'user',
                'content' => $fields['message']
            ];

            $evaluation->responses()->create(['message' => $fields['message'], 'sender' => 'user']);

            $aiService = new AIService();

            $aiResponse = $aiService->send($history);

            $evaluation->responses()->create(['message' => $aiResponse, 'sender' => 'assistant']);

            DB::commit();

            return redirect()->back()->with('response', $aiResponse);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Something went wrong while creating your profile. Please try again.']);
        }


    }
}
