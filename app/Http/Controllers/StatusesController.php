<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Status;
use Auth;

class StatusesController extends Controller
{
    //已登录用户才能发布、删除微博
    public function __construct()
    {
    	$this->middleware('auth',[
    		'only' => ['store','destroy']
    	]);
    }

    //发布微博
    public function store(Request $request)
    {
    	$this->validate($request,[
    		'content' => 'required|max:140'
    	]);

    	Auth::user()->statuses()->create([
    		'content' => $request->content
    	]);

    	return back();
    } 

    //删除微博
    public function destroy($id)
    {
        $status = Status::findOrFail($id);

        $this->authorize('destroy',$status);

        $status->delete();

        session()->flash('success','微博删除成功!');
        return back();
    }
}
