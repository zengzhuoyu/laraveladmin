@extends('layouts.common')

@section('title')

@section('content')

  @if (Auth::check())
    <div class="row">
      <div class="col-md-8">
        <section class="status_form">
          @include('statuses.send_status')
        </section>
        <h3>微博列表</h3>
        @include('statuses.home_status')        
      </div>
      <aside class="col-md-4">
        <section class="user_info">
          @include('layouts.user_info', ['user' => Auth::user()])
        </section>
        <section class="stats">
          @include('layouts.stats', ['user' => Auth::user()])
        </section>        
      </aside>
    </div>
  @else
    <div class="jumbotron">
      <h1>Hello Laravel</h1>
      <p class="lead">
        你现在所看到的是 <a href="https://laravel-china.org/laravel-tutorial/5.1">Laravel 入门教程</a> 的项目主页。
      </p>
      <p>
        一切，将从这里开始。
      </p>
      <p>
        <a class="btn btn-lg btn-success" href="{{ route('users.create') }}" role="button">现在注册</a>
      </p>
    </div>
  @endif

@stop