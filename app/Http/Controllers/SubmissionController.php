<?php

namespace App\Http\Controllers;

use App\Helpers\MessageFormat;
use App\Http\Requests\SubmissionCreateRequest;
use App\Models\Submissions;
use App\Models\Evaluations;
use App\Services\AIService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubmissionController extends Controller
{
    public function index()
    {
        return Inertia::render('Submission/All', [
            'evaluations' => Evaluations::latest()->paginate()
        ]);
    }
    public function create(Request $request)
    {
        $profile = $request->user()->profile;
        
        if (!$profile) {
            return redirect()->route('onboard');
        }

        $socialLinks = $profile ? $profile->socialLinks()->get() : [];

        return Inertia::render("Submission/Create", [
            'profile' => $profile,
            'socialLinks' => $socialLinks
        ]);
    }

    public function store(SubmissionCreateRequest $request) {
        $fields = $request->validated();

        $user = $request->user();

        try {
            DB::beginTransaction();

            $profile = $user->profile;

            if (!$profile) return redirect()->back()->withErrors(['error' => 'Please complete your profile before proceeding.']);

            $socialLinks = $profile->socialLinks;

            $socialLinks = $socialLinks ?? [];

            $submission = Submissions::create([
                'title' => $fields['title'], // This will now contain the business name
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
                    $business_name = $request->input('business_name') ?? 'Default Business Name';

                    $evaluation = Evaluation::create([
                        'submission_id' => $submission->id,
                        'user_id' => $user->id,
                        'business_name' => $business_name,
                        'id' => $submission->id, 
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]);
            DB::commit();

            return redirect()->route("submissions");

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Something went wrong while creating your profile. Please try again.']);
        }
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

            $message = MessageFormat::formatFirstMessage($fields, $profile, $user, $socialLinks);

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
            dd($e);
            DB::rollBack();
            return back()->withErrors(['error' => 'Something went wrong while doing this request. Please try again.']);
        }

    }

    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            
            $submission = Submissions::findOrFail($id);
            
            // Delete related records first
            $submission->metrics()->delete();
            $submission->challenges()->delete();
            $submission->competitors()->delete();
            $submission->evaluations()->delete();
            $submission->objectives()->delete();
            $submission->insights()->delete();
            
            // Delete the submission
            $submission->delete();
            
            DB::commit();
            
            return redirect()->route('submissions.index')->with('success', 'Submission deleted successfully');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to delete submission']);
        }
    } // Add this closing brace

    public function destroySubmission(Request $request, $id) 
    {
        $user = $request->user();

        $submission = Submissions::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$submission) {
            return back()->with('error', 'Submission not found.');
        }

        $submission->delete();
        
        return back()->with('success', 'Submission deleted successfully');
    }

}