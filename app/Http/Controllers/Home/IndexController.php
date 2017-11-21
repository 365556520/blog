<?php

namespace App\Http\Controllers\Home;



use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Links;

class IndexController extends CommonController
{
    //主页
    public function index(){
        //站长推荐区域点击量最高的文章
        $pics = Article::orderBy('art_view','desc')->take(6)->get();
        //带分页的图文列表带分页
        $data = Article::orderBy('art_time','desc')->paginate(5);
        //友情链接
        $links = Links::orderBy('link_order','asc')->get();
        return view('home.index',compact('hot','new','data','links','pics'));
    }
    //分类页
    public function cate($cate_id){
        //查询当前分类中的4篇文章图文列表5篇（带分页）
        $data = Article::where('cate_id',$cate_id)->orderBy('art_time','desc')->paginate(4);
        Category::where('cate_id',$cate_id)->increment('cate_view');
      //当前分类的子分类
        $submenu = Category::where('cate_pid',$cate_id)->get();
        $field = Category::find($cate_id);
        return view('home.list',compact('field','data','submenu'));
    }
    //文章页
    public function article($art_id){
        //Join关联查询 解释：Join中第一个参数是你需要连接到的表名，剩余的其它参数则是为连接指定的列约束.
        //get()方法返回的是多纬数组，first()方法，该方法将会返回单个 StdClass 对象
        $field = Article::Join('category','article.cate_id','=','category.cate_id')->where('art_id',$art_id)->first();
        //查看次数自增increment('art_view');这个字段自增默认自增1或者increment('art_view',5);自增5
        Article::where('art_id',$art_id)->increment('art_view');
        //上一篇
        $article['pre'] = Article::where('art_id','<',$art_id)->orderBy('art_id','desc')->first();
        //下一篇
        $article['next'] = Article::where('art_id','>',$art_id)->orderBy('art_id','asc')->first();
        //相关文章
        $data = Article::where('cate_id',$field->cate_id)->orderBy('art_id','desc')->take(6)->get();
        return view('home.new',compact('field','article','data'));
    }
}
