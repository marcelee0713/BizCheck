<?php

namespace App\Http\Controllers;

use App\Models\Evaluations;
use App\Services\AIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;


class ResponseController extends Controller
{
    public function store(Request $request, $id) {
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

            $evaluation->responses()->create(['message' => $fields['message'], 'sender' => 'user', 'created_at' => now()]);

            // $aiResponse = '';

            // if (App::environment('production')) {
            //     $aiService = new AIService();

            //     $aiResponse = $aiService->send($history);

            //     $evaluation->responses()->create(['message' => $aiResponse, 'sender' => 'assistant']);
            // } elseif (App::environment('local')) {
            //     sleep(2);

            //     $aiResponse = 'Skrrt beep boop, why is the spaghetti sad? Yeet the cheese, zoom zoom,
            //     oops I did it again. UwU vibes 3000, potato-powered chaos machine go brrr. Banana pants,
            //     what even is gravity? Wibbly-wobbly, timey-wimey nonsense with a sprinkle of existential dread.';

            //     $evaluation->responses()->create([
            //         'message' => $aiResponse,
            //         'sender' => 'assistant',
            //         'created_at' => now()->addSeconds(10),
            //     ]);
            // }

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
