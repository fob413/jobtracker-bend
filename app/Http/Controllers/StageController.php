<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stage;

class StageController extends Controller
{
    //
    public function create (Request $request)
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

    public function list ()
    {
        $user = auth()->user();

        $stages = Stage::where('user_id', $user['id'])->get();

        return response()->json([
            'message' => 'Successfully retrieved stages',
            'data' => $stages
        ]);
    }

    public function delete ($id)
    {
        $user = auth()->user();

        $stage = Stage::where('user_id', $user['id'])->where('id', $id)->first();

        if (!$stage) {
            return response()->json([
                'message' => 'Stage does not exist'
            ], 404);
        }

        $stage->delete();

        return response()->json([
           'message' => 'Successfully deleted stage'
        ]);
    }
}
