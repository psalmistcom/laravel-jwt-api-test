<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Post::with('user')->get(), 200);
        // $post = Post::with('user')->get();
        // return $this->success([
        //     'user' => new PostResource($post),
        // ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $post = Post::create($data);
        return $this->success([
            'DOne' => $post,
        ], 'Post created succesfully', 201);

        // try {
        //     $request->validated();
        //     $post = Post::create([
        //         'title' => $request->title,
        //         'content' => $request->content,
        //         'user_id' => Auth::id(),
        //     ]);
        //     if (!$post) {
        //         return $this->error('', 'Post not saved', 400);
        //     }
        //     return $this->success([
        //         'user' => new PostResource($post),
        //     ], 'Post created succesfully', 201);
        // } catch (\Throwable $th) {
        //     return $this->error('', 'Something went wrong from the server', 400);
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

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
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
