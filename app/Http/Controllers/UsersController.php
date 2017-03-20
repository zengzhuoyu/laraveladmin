<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\User;

use Auth;

class UsersController extends Controller
{

    //Auth中间件
    public function __construct()
    {
        //未登录用户不允许访问个人资料编辑页面和编辑数据提交
        $this->middleware('auth',[
            'only' => ['edit','update','destroy']
        ]);

        //已登录用户不允许访问注册页面
        $this->middleware('guest',[
            'only'=>['create']
        ]);        
    }

	//用户注册页面
    public function create()
    {
    	return view('users/create');
    }

    //用户基本信息页面
    public function show($id)
    {
    	$user = User::findOrFail($id);
    	return view('users/show',compact('user'));
    }

    //用户注册表单提交
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([

            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        Auth::login($user);
        session()->flash('success','欢迎,您将在这里开启一段新的旅程');
        return redirect()->route('users.show',[$user]);
    }

    //用户个人资料编辑页面
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update',$user);

        return view('users.edit',compact('user'));
    }

    //用户个人资料编辑表单提交
    public function update($id,Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:50',
            'password' => 'confirmed|min:6',
        ]);

        $user = User::findOrFail($id);
        $this->authorize('update',$user);
        
        $data = [];
        $data['name'] = $request->name;
        if($request->password){
            $data['password'] = bcrypt($request->password); 
        }
        $user->update($data);

        return redirect()->route('users.show',$id);
    }

    //用户列表页
    public function index()
    {
        // $users = User::all();
        
        //分页
        $users = User::paginate(30);
        
        return view('users.index',compact('users'));
    }

    //删除管理员
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('destroy', $user);
        
        $user->delete();

        session()->flash('success','成功删除用户！');
        return back();
    }
}
