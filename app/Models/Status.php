<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{

    protected $fillable = ['content'];
    	
    //指明一条微博属于一个用户：1.一对多，所以用户要单数 2.微博里写用户
    public function user()
    {
    	return $this->belongsTo(User::class);
    	// == 
    	// return $this->belongsTo(User::class,'user_id','id');
    }
}
