<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ActorController extends Controller
{
    public function getActors(): JsonResponse
    {
        $actors = Actor::paginate(10);

        return response()->json($actors);
    }

    public function getActorById(int $id): JsonResponse
    {
        $actor = Actor::with(['country'])->find($id);
        return response()->json($actor);
    }

    public function storeActor(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|integer|max:20',
            'birthday' => 'required|string|max:255',
            'description' => 'required|string|max:900',
        ]);

        $actor = Actor::create($data);
        return response()->json($actor);
    }
}
