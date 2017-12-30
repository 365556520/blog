<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::group(['middieware'=>['web']],function (){
    //前台（带home前缀）
    Route::group(['namespace'=>'Home'],function () {
        Route::get('/','IndexController@index');
        Route::get('/cate/{cate_id}','IndexController@cate');
        Route::get('/a/{art_id}','IndexController@article');
    });
    //后台（带admin前缀）
    Route::group(['prefix' => 'admin','namespace'=>'Admin'],function (){
        //crypt加密解密(测试路由)
      //  Route::any('crypt','LoginController@crypt');
        //login登录路由
        Route::any('login','LoginController@login');
        //code验证码路由
        Route::get('code','LoginController@code');
        //带admin.login中间件的路由
        Route::group(['middleware' => ['admin.login']], function () {
            //index主页路由并且添加
            Route::get('/','IndexController@index')->name('admin');
            Route::get('info','IndexController@info');
            //退出
            Route::get('quit','LoginController@quit');
            //修改密码
            Route::any('pass','IndexController@pass');
            //分类资源路由 分类路由  这个路由会生成很多种有用方法
            Route::resource('catcgory','CatcgoryController');
            //分类异步修改排序
            Route::post('cate/changeorder','CatcgoryController@changeorder');
            //文章资源路由
            Route::resource('article','ArticleController');
            //友情链接资源路由
            Route::resource('links','LinksController');
            //友情链接异步修改排序
            Route::post('links/changeorder','LinksController@changeorder');
            //自定义导航资源路由
            Route::resource('navs','NavsController');
            //导航异步修改排序
            Route::post('navs/changeorder','NavsController@changeorder');
            //把配置文件写到文件夹里面(自定义路由如果和资源路由用一个控制器（如果不带参数）那么就要写在资源路由的上面)
            Route::get('config/putfile','ConfigController@putFile');
            //网站配置异步修改排序
            Route::post('config/changeorder','ConfigController@changeorder');
            //网站配置修改配置值
            Route::post('config/changecontent','ConfigController@changeContent');
            //网站配置资源路由
            Route::resource('config','ConfigController');
            //接收上传文件
            Route::any('upload','CommonController@upload');
        });
        //这个测试提取验证码的
//    Route::get('getcode','LoginController@getCode');
    });
});
