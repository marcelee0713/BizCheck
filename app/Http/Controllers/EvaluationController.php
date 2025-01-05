<?php

namespace App\Http\Controllers;

use App\Helpers\MessageFormat;
use App\Models\Evaluations;
use App\Models\Submissions;
use App\Services\AIService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    public function index(Request $request) {
        $dateOrder = $request->query('dateOrder', 'desc');

        $evaluations = $request->user()->evaluations()
        ->orderBy('created_at', $dateOrder)
        ->paginate(10);

        return Inertia::render("Evaluation/All", [
            'evaluations' => $evaluations,
        ]);
    }

    public function show($id) {
        $evaluation = Evaluations::findOrFail($id);
        $responses = $evaluation->responses()->orderBy('created_at', 'asc')->get();

        return Inertia::render("Evaluation/Chat", [
            'evaluation' => $evaluation,
            'responses' => $responses
        ]);
    }

    /**
     * A function to create an Evaluation
     * Also requires the ID of the Submission
     */
    public function store(Request $request, $id) {
        $user = $request->user();

        $profile = $user->profile;

        if (!$profile) return redirect()->back()->withErrors(['error' => 'Please complete your profile before proceeding.']);

        $socialLinks = $profile->socialLinks;

        $submission = Submissions::where('id', $id)->where('user_id', $user->id)->first();

        if (!$submission) return back()->with('error', 'Submission not found.');

        try {
            DB::beginTransaction();

            $competitors = collect($submission->competitors)
            ->map(fn($competitor) => (object) $competitor)
            ->toArray();

            $metrics = collect($submission->metrics)
            ->map(fn($metric) => (object) $metric)
            ->toArray();

            $objectives = collect($submission->objectives)
            ->map(fn($objective) => (string) $objective->input)
            ->toArray();

            $challenges = collect($submission->challenges)
            ->map(fn($challenge) => (string) $challenge->input)
            ->toArray();

            $insights = collect($submission->insights)
            ->map(fn($insight) => (string) $insight->input)
            ->toArray();


            $fields = [
                'title' => $submission->title,
                'description' => $submission->description,
                'competitors' => $competitors,
                'metrics' => $metrics,
                'objectives' => $objectives,
                'challenges' => $challenges,
                'additionalInsights' => $insights
            ];

            $message = MessageFormat::formatFirstMessage($fields, $profile, $user, $socialLinks);

            $evaluation = $user->evaluations()->create([
                'submission_id' => $submission->id,
            ]);

            $evaluation->responses()->create(['message' => $message, 'sender' => 'user']);

            $aiService = new AIService();

            $aiResponse = $aiService->create($message);

            $evaluation->responses()->create(['message' => $aiResponse, 'sender' => 'assistant']);

            DB::commit();

            return redirect()->route("chat",['id' => $evaluation->id]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Something went wrong while doing this request. Please try again.']);
        }
    }

    public function destory(Request $request, $id) {
        $user = $request->user();

        $evaluation = Evaluations::where('id', $id)->where('user_id', $user->id)->first();

        if (!$evaluation) {
            return back()->with('error', 'Evaluation not found.');
        }

        $evaluation->destory();

        return redirect()->back()->with('message', 'Submission deleted successfully!');
    }
}
