<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

// docs:
// https://github.com/z-song/laravel-admin/blob/master/docs/zh/model-form.md

//
use Encore\Admin\Layout\Content;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Grid;
use Encore\Admin\Form;

//
use App\Models\Status;

class StatusController extends Controller
{
    use ModelForm;

    public function index()
    {

        return Admin::content(function (Content $content) {

            $content->header('微博列表');
            $content->description('我是描述');
 
            $content->body($this->grid());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Status::class, function (Grid $grid) {

		$grid->id('ID');
		$grid->user()->name('用户');

		// $grid->content();
		$grid->content('内容')->display(function($content) {
			return str_limit($content, 30, '...');
		});

		$grid->created_at('发布时间')->sortable();
		// $grid->updated_at();

		$grid->model()->orderBy('created_at', 'desc');

		$grid->paginate(10);
        });
    }    

    //新建
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('新建微博');
            $content->description('我是新建');

            $content->body($this->form());
        });
    }    

    //编辑
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('编辑微博');
            $content->description('我是编辑');

            $content->body($this->form()->edit($id));
        });
    }

    protected function form()
    {
        return Admin::form(Status::class, function (Form $form) {

	$form->display('id', 'ID');//编辑页面出现

	// 添加describe的textarea输入框
	$form->textarea('content', '内容');

	$form->display('created_at', 'Created At');//编辑页面出现
	$form->display('updated_at', 'Updated At');//编辑页面出现


        });
    }    
}
