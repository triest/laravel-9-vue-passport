<?php
namespace App\Services;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class PostService
{

    public function index(){
        $posts = Post::all();
        return $posts;
    }


    public function view(Post $post){
        return $post;
    }

    public function store($data){

        $post = Post::create($data);

        return $post;

    }

    public function update(Post $post,$data){

        $post->update($data);

        return $post;
    }

    public function delete(Post $post){

        $post->delete();
    }

    public function bulk(Post $post, array $tagsIdArray){
        DB::beginTransaction();

        foreach ($tagsIdArray as $item){
            $tag = Tag::where('id',$item)->firstOrFail();
            $post->tags()->save($tag);
        }

        foreach ( $post->tags()->get() as $item){
            if(!in_array($item->id,$tagsIdArray)){
                $post->tags()->detach($item);
            }
        }

        DB::commit();
        return $post->tags()->get();
    }
}
