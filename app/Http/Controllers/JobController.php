<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stage;
use App\Models\Job;

class JobController extends Controller
{
    //
    public function create (Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'comments' => 'string',
            'reference' => 'string',
            'stage_id' => 'required|int'
        ]);

        $user = auth()->user();

        $stage = Stage::where('user_id', $user['id'])->where('id', $data['stage_id'])->first();

        if (!$stage) {
            return response()->json([
                'message' => 'Stage does not exist'
            ], 404);
        }

        $new_job = new Job([
            'title' => $data['title'],
            'reference' => $data['reference'] ?? '',
            'comments' => $data['comments'] ?? '',
            'is_archived' => false
        ]);

        $new_job->user()->associate($user);
        $new_job->stage()->associate($stage);

        $new_job->save();

        return response()->json([
            'message' => 'Successfully created job',
        ], 201);
    }
}
