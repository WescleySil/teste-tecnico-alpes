<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\Auth\LoginService;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(
        LoginRequest $request,
        LoginService $service
    )
    {
        $data = $request->validated();
        $user = $service->run($data);

        return response()->json(new UserResource($user), 200);
    }

    public function me()
    {
        $user = Auth::user();

        return response()->json([
            'data' => $user
        ]);
    }

    public function logout()
    {
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout realizado com sucesso.']);
    }
}
