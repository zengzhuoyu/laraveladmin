<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\User;
use Auth;

class FollowersController extends Controller
{
    public function __construct()
    {
    	//未登录用户不允许访问store和destroy
    	$this->middleware('auth',[
    		'only' => ['store','destroy']
    	]);
    }

    public function store($id)
    {
        $user = User::findOrFail($id);

        if (Auth::user()->id === $user->id) {//用户不能对自己进行关注和取消关注
            return redirect('/');
        }

        //此操作是还未关注才允许进行关注操作
        if (!Auth::user()->isFollowing($id)) {//判断当前用户是否已关注了要进行操作的用户
            Auth::user()->follow($id);
        }

        return redirect()->route('users.show', $id);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (Auth::user()->id === $user->id) {//用户不能对自己进行关注和取消关注
            return redirect('/');
        }

        if (Auth::user()->isFollowing($id)) {//判断当前用户是否已关注了要进行操作的用户
            Auth::user()->unfollow($id);
        }

        return back();
        // ==
        // return redirect()->route('users.show', $id);
    }    
}
