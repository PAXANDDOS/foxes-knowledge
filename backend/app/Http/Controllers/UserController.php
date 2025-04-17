<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest\UserStoreRequest;
use App\Http\Requests\UserRequest\UserUpdateRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $users = User::with('posts')->get();

        return response($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request, UserService $userService): Response
    {
        $user = $userService->create((array) $request->validated());

        return response($user, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): Response
    {
        return response(User::with('posts')->find($user->id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user, UserService $userService): Response
    {
        $user = $userService->update((array) $request->validated(), $user);

        return response($user, Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): Response
    {
        $user->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }
}
