<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest\PostStoreRequest;
use App\Http\Requests\PostRequest\PostUpdateRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $search = $request->input('search');
        $order = $request->input('order');
        $posts = Post::query()
            ->with('user', 'tags', 'parent', 'child')
            ->withCount([
                'comments as comments',
                'attachments as attachments',
                'reactions as reactions',
            ]);

        if (isset($search)) {
            $posts->where('title', 'ILIKE', "%{$search}%")
                ->orWhere('content', 'ILIKE', "%{$search}%");
        }

        if (isset($order)) {
            $order = explode(',', $order);

            if (count($order) === 1) {
                $order[] = 'desc';
            }
            $posts->orderBy($order[0], $order[1]);
        }

        return response($posts->paginate(15));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request, PostService $postService): Response
    {
        $data = $request->validated();

        if (! isset($data['user_id'])) {
            $data['user_id'] = auth()->id();
        }

        $post = $postService->create($data);

        return response($post, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): Response
    {
        return response($post->load(['user', 'reactions', 'tags', 'attachments', 'parent', 'child', 'comments.user', 'comments.reactions']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, Post $post, PostService $postService): Response
    {
        $data = $request->validated();

        if (! isset($data['user_id'])) {
            $data['user_id'] = auth()->id();
        }

        $post = $postService->update($data, $post);

        return response($post, Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): Response
    {
        $post->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Display posts listing
     */
    public function getListing(): Response
    {
        $posts = Post::has('child')
            ->doesntHave('parent')
            ->with(['user', 'tags'])
            ->get();

        foreach ($posts as $post) {
            $depth = 0;
            $child = $post;
            while ($child->child != null) {
                $child = Post::findOrFail($child->child->id);
                $depth++;
            }
            $post->child_depth = $depth; // @phpstan-ignore-line
        }

        return response($posts);
    }
}
