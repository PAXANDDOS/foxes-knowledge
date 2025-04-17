<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest\SignInRequest;
use App\Http\Requests\AuthRequest\SignUpRequest;
use App\Models\Invitation;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Register a user and issue a token.
     */
    public function signUp(SignUpRequest $request, UserService $userService): Response
    {
        $invitation = Invitation::where('token', $request->token)->first();

        if (! $invitation || $invitation->email !== $request->email) {
            return response(['message' => 'Invalid access token'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = $userService->create($request->validated());

        $invitation->delete();

        $token = $user->createToken('auth_token');

        return response([
            'message' => 'Signed up successfully.',
            'user' => $user->toArray(),
            'token' => [
                'type' => 'Bearer',
                'value' => $token->plainTextToken,
                'ttl' => config('sanctum.expiration'),
            ],
        ], Response::HTTP_CREATED);
    }

    /**
     * Issue user a token.
     */
    public function signIn(SignInRequest $request): Response
    {
        if (! Auth::attempt($request->only('email', 'password'))) {
            return response([
                'message' => 'Invalid login credentials.',
            ], Response::HTTP_CONFLICT);
        }

        $user = User::where('email', $request->input('email'))->firstOrFail();

        $token = $user->createToken('auth_token');

        return response([
            'message' => 'Signed in successfully.',
            'user' => $user->toArray(),
            'token' => [
                'type' => 'Bearer',
                'value' => $token->plainTextToken,
                'ttl' => config('sanctum.expiration'),
            ],
        ]);
    }

    /**
     * Revoke a token.
     */
    public function signOut(): Response
    {
        /**
         * @var $token
         *
         * @method delete() Delete token.
         */
        $token = Auth::user()->currentAccessToken();
        $token->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Revoke a token.
     */
    public function revokeTokens(): Response
    {
        Auth::user()->tokens()->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Get current user.
     */
    public function me(): Response
    {
        return response(Auth::user());
    }
}
