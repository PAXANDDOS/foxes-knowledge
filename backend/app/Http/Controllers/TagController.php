<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest\TagStoreRequest;
use App\Http\Requests\TagRequest\TagUpdateRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $search = $request->input('search');
        $tags = Tag::query()
            ->with(['posts', 'parent']);
        if (isset($search)) {
            $tags->where('name', 'ILIKE', "%{$search}%");
        }

        return response($tags->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagStoreRequest $request): Response
    {
        $tag = Tag::create($request->validated());

        return response($tag, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag): Response
    {
        return response(Tag::with(['posts', 'parent'])->find($tag->id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TagUpdateRequest $request, Tag $tag): Response
    {
        $tag->update($request->validated());

        return response($tag, Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag): Response
    {
        $tag->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }

    public function getTopFiveTags(): Response
    {
        $tags = Tag::withCount('posts as posts')
            ->orderBy('posts', 'desc')
            ->take(5)
            ->get();

        return response($tags);
    }
}
