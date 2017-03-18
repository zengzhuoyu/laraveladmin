<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class StaticPagesController extends Controller
{
	//首页
    public function home()
    {
    	// return '首页';
    	
    	return view('static_pages/home');
    }

    	//帮助页
    public function help()
    {
    	// return '帮助页';
    	
    	return view('static_pages/help');    	
    }

    	//关于页
    public function about()
    {
    	// return '关于页';
    	
    	return view('static_pages/about');    	
    }        
}
