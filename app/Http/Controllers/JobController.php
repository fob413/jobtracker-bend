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

    public function list ()
    {
        $user = auth()->user();

        $jobs = Job::where('user_id', $user['id'])->where('is_archived', false)->get();

        return response()->json([
            'message' => 'Successfully retrived jobs',
            'data' => $jobs
        ]);
    }

    public function update (Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'string',
            'comments' => 'string',
            'reference' => 'string',
            'stage_id' => 'int'
        ]);

        $user = auth()->user();

        $job = Job::where('user_id', $user['id'])->where('id', $id)->first();

        if (!$job) {
            return response()->json([
                'message' => 'Job does not exist'
            ], 404);
        }

        if ($data['stage_id']) {
            $stage = Stage::where('user_id', $user['id'])->where('id', $data['stage_id'])->first();

            if (!$stage) {
                return response()->json([
                    'message' => 'Stage does not exist'
                ], 404);
            }
        }

        $job['title'] = $data['title'] ?? $job['title'];
        $job['comments'] = $data['comments'] ?? $job['comments'];
        $job['reference'] = $data['reference'] ?? $job['reference'];
        $job['stage_id'] = $data['stage_id'] ?? $job['stage_id'];

        $job->save();

        return response()->json([
            'message' => 'Job updated successfully'
        ]);
    }

    public function delete ($id)
    {
        $user = auth()->user();

        $job = Job::where('user_id', $user['id'])->where('id', $id)->first();

        if (!$job) {
            return response()->json([
                'message' => 'Job does not exist'
            ], 404);
        }

        $job['is_archived'] = true;
        $job->save();

        return response()->json([
            'message' => 'Job archived successfully'
        ]);
    }
}
