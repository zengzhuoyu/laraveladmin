<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\User;

use Auth;
use Mail;

class UsersController extends Controller
{

    //Auth中间件
    public function __construct()
    {
        //未登录用户不允许访问个人资料编辑页面和编辑数据提交
        $this->middleware('auth',[
            'only' => ['edit','update','destroy','followings','followers']
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

            $statuses = $user->statuses()
                                            ->orderBy('created_at','desc')
                                            ->paginate(30);
    	return view('users/show',compact('user','statuses'));
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

        // Auth::login($user);
        $this->_sendEmailConfirmationTo($user);

        session()->flash('success','欢迎,您将在这里开启一段新的旅程');
        // return redirect()->route('users.show',[$user]);
        return redirect('/');
    }

    //发送注册邮件
    private function _sendEmailConfirmationTo($user)
    {
        $view = 'emails/confirm';
        $data = compact('user');
        // $from = 'zengzhuoyu24@163.com';
        // $name = 'zengzhuoyu';
        $to = $user->email;
        $subject = '感谢注册 Laravel rumen 应用！请确认你的邮箱。';

        // Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
        //     $message->from($from, $name)->to($to)->subject($subject);
        // });        

        Mail::send($view, $data, function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });        
    }

    //点击邮件里的链接激活邮件
    public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success', '恭喜你，激活成功！');
        return redirect()->route('users.show', [$user]);        
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

        session()->flash('success', '个人资料更新成功！');
        
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

    //关注列表
    public function followings($id)
    {
        $user = User::findOrFail($id);
        $users = $user->followings()->paginate(30);
        $title = '关注的人';
        return view('users.show_follow', compact('users', 'title'));
    }    

    //粉丝列表
    public function followers($id)
    {
        $user = User::findOrFail($id);
        $users = $user->followers()->paginate(30);
        $title = '粉丝';
        return view('users.show_follow', compact('users', 'title'));
    }    






}
