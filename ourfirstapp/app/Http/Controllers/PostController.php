<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function actuallyUpdate(Post $post, Request $request){
$incomingFields = $request->validate(['title'=>'required', 'body'=>'required']); 
$incomingFields['title'] = strip_tags($incomingFields['title']);
$incomingFields['body'] = strip_tags($incomingFields['body']);
$post->update($incomingFields);
return back()->with('success', 'Post updated successfully');}

    public function showEditForm(Post $post){
        return view('edit-post', ['post' => $post]);
// Inside the view file, you will be able to access the $post variable and its value using Blade templating syntax.
            }


    public function delete(Post $post){
$post->delete();
return redirect('/profile/'.auth()->user()->username)->with('success','Post successfully deleted');
    }
    public function viewSinglePost(Post $post){
        return view('single-post', ['post' => $post]);
        //we are using the info inside the single-post blade
    }    
    public function storeNewPost(Request $request){
        $incomingFields = $request->validate(['title'=>'required', 'body'=>'required', ]); 
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();
    $newPost = Post::create($incomingFields);
    return redirect("/post/{$newPost->id}")->with('success', 'New post successfully created.');
    }
    public function showCreateForm(){
        return view('create-post');
    }
}
