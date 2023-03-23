<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\BulkTagRequest;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\IndexPostRequest;
use App\Http\Resources\Post\PostCollection;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\Tag\TagResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public PostService $postService;

    /**
     * @param PostService $postService
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index(IndexPostRequest $request)
    {
        $posts = $this->postService->index($request->validated());

        return PostCollection::make($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $post = $this->postService->store($request->validated());

        return PostResource::make($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {

        return PostResource::make($post);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $post = $this->postService->update($post, $request->validated());

        return PostResource::make($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function bulk(Post $post,BulkTagRequest $request){
        $tags = $this->postService->bulk($post,$request->validated());

        return TagResource::collection($tags);
    }
}
