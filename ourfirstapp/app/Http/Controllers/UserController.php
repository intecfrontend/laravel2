<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
// lesson 37 make a smaller jpg

class UserController extends Controller
{
    // interesant ivm de syntax
    public function storeAvatar(Request $request){
        $request->file('avatar')->store('public/avatars');
$user = auth()->user();
$filename = $user->id. '-' . uniqid() . '.jpg';
       $imgData = Image::make($request->file('avatar'))->fit(200)->encode('jpg');
       // composer require intervention/image    PHP reduces imgsize
        // return 'hellothere';
        Storage::put('public/avatars/'.$filename, $imgData );
        $oldAvatar = $user->avatar;
        $user->avatar = $filename;
        $user->save();
if($oldAvatar != "/fallback-avatar.jpg"){
    Storage::delete(str_replace("/storage/", "public", $oldAvatar));
}
return back()->with('success', 'congrats with the new avatar.');

       }

       public function showAvatarForm(){
        return view('avatar-form');
       }
    //    **seehim
       public function profile(User $nameConnector){
        return view('profile-posts', ['avatar' => $nameConnector->avatar,'username' => $nameConnector->username, 'posts'=> $nameConnector->posts()->latest()->get(), 'postCount' => $nameConnector->posts()->count()]);
       }
    public function logout(){
        (auth()->logout()); return redirect('/')->with('success', 'You are now logged out');
    }
    public function showCorrectHomepage(){
        if (auth()->check()) {
            return view('homepage_feed');
    } else {
    return view('homepage');
    }
}
 public function login(Request $request){
        $incomingFields = $request->validate([
            'loginusername' => 'required',
            'loginpassword' => 'required',
        ]);
        if (auth()->attempt(['username' => $incomingFields['loginusername'], 'password' => $incomingFields['loginpassword']])) {
            $request->session()->regenerate(); return redirect('/')->with('success', 'You are now logged in');;
        } else {
            return  redirect('/')->with('failure', 'Invalid login.');
        } 
    }
        public function register(Request $request){
        $incomingFields = $request->validate([
            'username' => ['required', 'min:3', 'max:20', Rule::unique('users', 'username')],
            'email' => ['required','email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:3', 'confirmed'],
        ]);
        $incomingFields['password'] = bcrypt($incomingFields['password']);
        $user=User::create($incomingFields);
        auth()->login($user);
        return redirect('/')->with('success', 'Thanks for registering');
    }    
}
