<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('/signup', 'signUp');
    Route::post('/signin', 'signIn');
    Route::post('/signout', 'signOut')->middleware('auth:sanctum');
    Route::post('/revoke', 'revokeTokens')->middleware('auth:sanctum');
    Route::get('/me', 'me')->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tags/top', [TagController::class, 'getTopFiveTags']);
    Route::get('/posts/listing', [PostController::class, 'getListing']);

    Route::apiResource('users', UserController::class);
    Route::apiResource('tags', TagController::class);
    Route::apiResource('posts', PostController::class);
    Route::apiResource('comments', CommentController::class);
    Route::apiResource('invitations', InvitationController::class);
    Route::apiResource('attachments', AttachmentController::class);

    Route::controller(ReactionController::class)->group(function () {
        Route::post('/posts/{post}/reactions', 'reactPost');
        Route::post('/comments/{comment}/reactions', 'reactComment');
    });
});
