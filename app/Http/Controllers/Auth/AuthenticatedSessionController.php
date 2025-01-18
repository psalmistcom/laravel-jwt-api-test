<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{

    use HttpResponses;
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        try {
            $request->validated($request->all());

            $data = Auth::attempt($request->only(['email', 'password']));
            if (!$data) {
                return $this->error('', 'Credential do not match', 400);
            }

            $user = User::where('email', $request->email)->first();

            return $this->success([
                'user' => $user,
                'token' => $user->createToken('API token of ' . $user->name)->plainTextToken
            ]);
        } catch (\Throwable $th) {
            return $this->error($th, 'Something went wrong from the server', 400);
        }

        // $request->authenticate();

        // $request->session()->regenerate();

        // return response()->noContent();
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        // Auth::user()->currentAccessToken()->delete();
        $request->user()->currentAccessToken()->delete();
        return $this->success([
            'message' => 'Logged out succesfully'
        ]);
        // Auth::guard('web')->logout();

        // $request->session()->invalidate();

        // $request->session()->regenerateToken();

        // return response()->noContent();
    }
}
