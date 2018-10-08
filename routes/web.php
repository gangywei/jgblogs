<?php

//登陆页面的Login路由
Route::get('/root','Admin\AdminController@root')->name('root');
Route::post('login','Admin\AdminController@login')->name('login');

//注册页面的路由
Route::get('/register',function(){
    return view('admin.register');
})->name('register');
Route::post('Admin/register','Admin\AdminController@register');
//重置密码的路由
Route::get('find',function(){
    return view('admin.find');
})->name('find');
Route::post('chpwd','Admin\AdminController@chpwd')->name('chpwd');
Route::get('s_email','Admin\AdminController@s_email');

//功能页面
Route::group(['middleware' => 'root'], function () {

    Route::get('logout','Admin\AdminController@logout');
    //博客资源路由
    Route::resource('histories','Admin\HistoriesController');
    Route::resource('blog', 'Admin\BlogController');
    Route::get('blog/comDelete/{id}','Admin\BlogController@comDelete');
    Route::resource('word', 'Admin\WordController');
    Route::resource('file', 'Admin\FileController');
    Route::get('file/comDelete/{id}','Admin\FileController@comDelete');
    Route::resource('role', 'Admin\RoleController');
    Route::resource('user', 'Admin\UserController');
    Route::resource('permiss', 'Admin\PermissController');
    Route::resource('label', 'Admin\LabelController',['names' => [
        'create' => 'photo.build'
    ]]);
    Route::get('label/comDelete/{id}','Admin\LabelController@comDelete');
    //创建文章
    Route::get('ceblog/{blog?}','Admin\BlogController@ceblog')->where('blog','[0-9]+')->name('ceblog');
});


//前台界面路由
Route::group(['middleware' => 'read'], function () {
    Route::get('', 'Home\BgIndexController@index');
    Route::post('word', 'Home\BgIndexController@word');
    Route::get('index', 'Home\BgIndexController@index');
    Route::get('reblog/{id?}', 'Home\BgIndexController@blog')->where('id', '[0-9]+');
    Route::get('archive', 'Home\BgIndexController@archive');
    Route::get('history', 'Home\BgIndexController@history');
    Route::get('introduce', 'Home\BgIndexController@introduce');
});
