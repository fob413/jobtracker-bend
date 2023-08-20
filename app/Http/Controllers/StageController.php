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
}
