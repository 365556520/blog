<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Navs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;


class CommonController extends Controller
{
    //
    public function __construct(){
        //传送导航信息
        $navs = Navs::orderBy('nav_order','asc')->get();
        //点击排行区域点击量最高的文章
        $hot = Article::orderBy('art_view','desc')->take(5)->get();
        //最新发布文章8篇
        $new = Article::orderBy('art_time','desc')->take(8)->get();
        //把信息共享到每个页面Illuminate\Support\Facades\View::share('navs',$navs);
        View::share('navs',$navs);
        View::share('hot',$hot);
        View::share('new',$new);
    }
}