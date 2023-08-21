<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;

class FollowController extends Controller
{

    public function createFollow(User $user) {
        // you cannot follow yourself
        // you cannot follow someone you're already following

        $newFollow = new Follow;
        $newFollow->user_id = auth()->user()->id;
        $newFollow->followedid = $user->id; 
        $newFollow->save(); 
    }


    public function removeFollow() {}

}
