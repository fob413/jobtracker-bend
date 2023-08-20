<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illumiate\Http\JsonResponse;
use App\Models\Stage;

class StageController extends Controller
{
    //
    public function create (Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string'
        ]);

        $user = auth()->user();

        $new_stage = new Stage([
            'name' => $data['name']
        ]);

        $user->stages()->save($new_stage);

        return response()->json([
            'message' => 'Successfully created stage'
        ], 201);
    }

    public function list (): JsonResponse
    {
        $user = auth()->user();

        $stages = Stage::where('user_id', $user['id'])->get();

        return response()->json([
            'message' => 'Successfully retrieved stages',
            'data' => $stages
        ]);
    }
}
