<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Like;
use Illuminate\Support\Facades\Auth;
use Session;

class PostController extends Controller
{
     public function getDashBoard()
    {
    	$posts = Post::orderBy('created_at', 'desc')->get();
    	return view('dashboard')->withPosts($posts);
    }

    public function postCreatePost(Request $request)
    {
    	//validation

    	$this->validate($request, array(

    		'body' => 'required|max:1000'

    	));

    	$posts = new Post();

    	$posts->body = $request->body;
    	$request->user()->posts()->save($posts);
    	
    	return redirect()->route('dashboard');

    }

    public function getDeletePost($id)
    {
    	$post = Post::find($id);
    	if (Auth::user() != $post->user) {
    		return redirect()->back();
    	}
    	$post->delete();
    	return redirect()->route('dashboard');
    }

    public function postEditPost(Request $request)
    {
    	$this->validate($request, array(

    		'body' => 'required'

    	));

    	$post = Post::find($request['postId']);
    	if (Auth::user() != $post->user) {
    		return redirect()->back();
    	}
    	$post->body = $request->body;
    	$post->update();
    	return response()->json(['new-body' => $post->body], 200);
    }

    public function postLikePost(Request $request)
    {
    	$post_id = $request['postId'];
    	$is_like = $request['isLike'] === 'true';
    	$update = false;
    	$post = Post::find($post_id);
    	if(!$post){
    		return null;
    	}
    	$user = Auth::user();
    	$like = $user->likes()->where('post_id', $post_id)->first();
    	if ($like) {
    		
    		$already_like = $like->like;
    		$update = true;
    		if ($already_like == $is_like) {
    			$like->delete();
    			return null;
    		}
    	}else{
    		$like = new Like();
    	}
    		$like->like = $is_like;
    		$like->user_id = $user->id;
    		$like->post_id = $post->id;

    		if($update){
    			$like->update();
    		}else{
    			$like->save();
    		}
    		return null;
    }
}
