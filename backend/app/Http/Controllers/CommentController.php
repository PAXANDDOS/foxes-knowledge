<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest\CommentStoreRequest;
use App\Http\Requests\CommentRequest\CommentUpdateRequest;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CommentService $commentService): Response
    {
        return response($commentService->getWithReactions());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentStoreRequest $request): Response
    {
        $comment = Comment::create($request->validated());

        return response($comment, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment, CommentService $commentService): Response
    {
        return response($commentService->getWithReactions($comment));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentUpdateRequest $request, Comment $comment): Response
    {
        $comment->update($request->validated());

        return response($comment, Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment): Response
    {
        $comment->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }
}
