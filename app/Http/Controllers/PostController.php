<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $post = Post::query()->orderBy('created_at', 'desc')->paginate();
        return $this->success(
            PostResource::collection($post),
            'All Posts fetched succesfully',
            201
        );
    }

    /**
     * Display a listing that belongs to a specific user.
     */
    public function userPosts(): JsonResponse
    {
        $post = Post::where('user_id', Auth::user()->id)->paginate();
        if (!empty($post)) {
            return $this->success(PostResource::collection($post));
        }
        return $this->success('You have not created any post');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = Auth::id();
            $post = Post::create($data);
            if (!$post) {
                return $this->error('', 'Post not saved', 400);
            }
            return $this->success(
                new PostResource($post),
                'Post created succesfully',
                201
            );
        } catch (\Throwable $th) {
            return $this->error('', 'Something went wrong from the server', 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post): JsonResponse
    {
        try {
            if (Auth::id() !== $post->user_id) {
                return $this->error(
                    '',
                    'You are not authorized to update other peoples post',
                    403
                );
            }

            $post->update($request->all());

            return $this->success(
                new PostResource($post),
                'Post Updated succesfully',
                201
            );
        } catch (\Throwable $th) {
            return $this->error($th, 'Something went wrong from the server', 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        try {
            if (Auth::id() !== $post->user_id) {
                return $this->error(
                    '',
                    'You are not authorized to delete other peoples post',
                    403
                );
            }

            $post->delete();

            return $this->success(
                '',
                'Post Deleted succesfully',
                200
            );
        } catch (\Throwable $th) {
            return $this->error($th, 'Something went wrong from the server', 400);
        }
    }
}
