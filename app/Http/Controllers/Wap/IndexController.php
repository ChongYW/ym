<?php

namespace App\Http\Controllers\Wap;
use App\Auth;
use App\Category;
use App\Channel;
use App\Http\Controllers\Controller;
use App\Member;
use App\Order;
use App\Product;
use App\Seal;
use Carbon\Carbon;
use DB;
use App\Admin;
use App\Ad;
use App\Productbuy;
use App\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Session;

class IndexController extends BaseController
{
    public $cachetime=600;
    public function __construct(Request $request)
    {


        parent::__construct($request);
        //\App\Member::GetIpInfo('183.160.77.29');
        /**网站缓存功能生成**/


        //验证访问权限是否开启

        $this->middleware(function ($request, $next) {

            if(Cache::get('AccessPrivileges')!='开启'){
                $UserId =$request->session()->get('UserId');

                if($UserId<1){
                    return redirect()->route("wap.login");
                }

                $Member= Member::find($UserId);
                if($Member){
                    $this->Member=$Member;
                    view()->share("Member",$Member);
                }



                view()->share("Member",$this->Member);
            }else{

                $UserId =$request->session()->get('UserId');


                $Member= Member::find($UserId);
                if($Member){
                    $this->Member=$Member;
                    view()->share("Member",$Member);
                }


            }



            return $next($request);
        });



        /**广告数据**/
        $Ad=new Ad();

        if(Cache::has("wap.ad")){
            $wapad= Cache::get("wap.ad");
            view()->share("wapad",$wapad );
        }else{
            $wapad['banner']=$Ad->GetAd('手机首页幻灯');
            $wapad['hongbao']=$Ad->GetAd('首页邀请好友红包');
            $wapad['houdong']=$Ad->GetAd('活动浮动广告');
            Cache::put("wap.ad",$wapad,$this->cachetime);
            view()->share("wapad", $wapad);
        }



        /**项目分类菜单导航栏**/
        if(Cache::has('wap.ProductsCategory')){
            $ProductsCategory=Cache::get('wap.ProductsCategory');
        }else{
            $ProductsCategory= Category::where("model","products")->whereRaw("FIND_IN_SET(?,templates)",Cache::get("WapTemplate"))->where("atindex","1")->orderBy("sort","asc")->get();

            foreach ($ProductsCategory as $item) {
                $item->Products=DB::table("products")->where("category_id",$item->id)->where("issy","1")->orderBy("sort","asc")->get();
            }

            Cache::put('wap.ProductsCategory',$ProductsCategory,$this->cachetime);
        }


        view()->share("ProductsCategory",$ProductsCategory);
        /**项目分类菜单导航栏 END **/



       $ShowProducts= DB::table("products")->where("issy","1")->where("status", "1")->orderBy("sort","asc")->get();

        view()->share("ShowProducts",$ShowProducts);


        /**项目分类列表**/
        if(Cache::has('wap.ProductsCategoryList')){
            $ProductsCategoryList=Cache::get('wap.ProductsCategoryList');
        }else{
            $ProductsCategoryList= Category::where("model","products")
                ->where("isshow","1")
                ->whereRaw("FIND_IN_SET(?,templates)",Cache::get("WapTemplate"))
                ->orderBy("sort","asc")->orderBy("created_at","desc")->get();

            Cache::put('wap.ProductsCategoryList',$ProductsCategoryList,$this->cachetime);
        }



        view()->share("ProductsCategoryList",$ProductsCategoryList);
        /**项目分类菜单导航栏 END **/



        if(Cache::has('memberlevel.list')){
            $memberlevel=Cache::get('memberlevel.list');
        }else{
            $memberlevel= DB::table("memberlevel")->orderBy("id","asc")->get();
            Cache::get('memberlevel.list',$memberlevel,Cache::get("cachetime"));
        }

        $memberlevelName=[];
        foreach($memberlevel as $item){
            $memberlevelName[$item->id]=$item->name;
        }

        $this->memberlevelName=$memberlevelName;

        view()->share("memberlevel",$memberlevelName);


        /**自动标记投资满额 20190814**/
/*        $Products=  Product::where("tzzt","0")->get();
        if($Products){
            foreach ($Products as $product) {
                if($product->xmjd>=100){
                    $product->tzzt=1;
                }

                $product->save();
            }
        }*/

    }


    public function index(Request $request){






        /**手机首页导航栏**/
        if(Cache::has('wap.morec.category')){
            $moreccategory=Cache::get('wap.morec.category');
        }else{
            $moreccategory= DB::table('category')->whereRaw("FIND_IN_SET(?,templates)",Cache::get("WapTemplate"))->where("morec","1")->orderBy("sort","asc")->limit(20)->get();
            Cache::put('wap.morec.category',$moreccategory,$this->cachetime);
        }
        //dump($moreccategory);die;
        view()->share("moreccategory",$moreccategory);
        /**手机首页导航栏 END **/

       // $newmess=   \App\Formatting::Format(Cache::get('newmess'));//UserName

        $UserId =$request->session()->get('UserId');


        $Member= Member::find($UserId);
$gg=   Cache::get('boxgg');//UserName

  view()->share("gg",stripslashes($gg));
  
 // print_r($gg);
  
  
       return $this->WapShowTemplate("index");

    }


    /**商品**/
    public function products(Request $request)
    {


          view()->share("request",$request);
          if($request->links!=''){
              $category = DB::table("category")->whereRaw("FIND_IN_SET(?,templates)",Cache::get("WapTemplate"))->where("model", "products")->where("links", $request->links)->first();
              if ($category) {
                  view()->share("category", $category);
                  view()->share("title", $category->name);



                  if(Cache::has('wap.productsLists.category.'.$category->id)){
                      $productsLists=Cache::get('wap.productsLists.category.'.$category->id);
                  }else{
                      $productsLists=  DB::table("products")->where("category_id", $category->id)
                          ->where("status", "1")
                          ->orderBy("sort", "asc")
                          ->orderBy("created_at", "desc")
                          ->orderBy("tzzt", "asc")
                          ->orderBy("qtje", "asc")
                          ->get();
                      Cache::put('wap.productsLists.category.'.$category->id,$productsLists,$this->cachetime);
                  }


                  view()->share("productsLists", $productsLists);
                  return $this->WapShowTemplate("productlist");
              }
          }elseif($request->coupon>0){


              if(Cache::has('wap.productsLists.coupon.'.$request->coupon)){
                  $productsLists=Cache::get('wap.productsLists.coupon.'.$request->coupon);
              }else{
                  $productsLists=  DB::table("products")
                      ->where("status", "1")
                      ->whereRaw("FIND_IN_SET(?,coupon)",$request->coupon)
                      ->orderBy("sort", "asc")
                      ->orderBy("created_at", "desc")
                      ->orderBy("tzzt", "asc")
                      ->orderBy("qtje", "asc")
                      ->get();
                  Cache::put('wap.productsLists.coupon.'.$request->coupon,$productsLists,$this->cachetime);
              }


              view()->share("AllProducts", $productsLists);

              return $this->WapShowTemplate("products");

          }else{


              if(Cache::has('wap.productsLists.all.')){
                  $productsLists=Cache::get('wap.productsLists.all.');
              }else{
                  $productsLists=  DB::table("products")
                      ->where("status", "1")
                      ->orderBy("sort", "asc")
                      ->orderBy("created_at", "desc")
                      ->orderBy("tzzt", "asc")
                      ->orderBy("qtje", "asc")
                      ->get();
                  Cache::put('wap.productsLists.all',$productsLists,$this->cachetime);
              }


              view()->share("AllProducts", $productsLists);

              return $this->WapShowTemplate("products");
          }



    }

    public function product(Request $request)
    {

        DB::table("products")->where("id",$request->id)->increment('click_count',1);

        if(Cache::has('wap.product.'.$request->id)){
            $product=Cache::get('wap.product.'.$request->id);
        }else{
            $product=DB::table("products")->where("id",$request->id)->first();

            $product->links= DB::table("category")->whereRaw("FIND_IN_SET(?,templates)",Cache::get("WapTemplate"))->where("id",$product->category_id)->value('links');
            $product->thumb_url= DB::table("category")->where("id",$product->category_id)->value('thumb_url');

            Cache::put('wap.product.'.$request->id,$product,$this->cachetime);
        }
        view()->share("title",$product->category_name.'-'.$product->title);
        view()->share("productview",$product);


        view()->share("productid",$request->id);

        $Memberamount=0;
        $UserId = $request->session()->get('UserId');
        if($UserId>0){
            $Member= Member::find($UserId);


            if(!$Member){
                return redirect()->route("wap.loginout");
            }
            $Memberamount=$Member->amount;

        }
        view()->share("Memberamount",$Memberamount);


/*
        $Productbuys= Productbuy::where("productid",$request->id)->orderBy("id","desc")->limit(10)->get();
        if(count($Productbuys)<1){
            $Productbuys= Productbuy::orderBy("id","desc")->limit(10)->get();
        }
        view()->share("buylists",$Productbuys);*/


        return $this->WapShowTemplate("product");

    }


    /**项目投资**/
    public function buy(Request $request)
    {



        if(Cache::has('wap.product.'.$request->id)){
            $product=Cache::get('wap.product.'.$request->id);
        }else{
            $product=DB::table("products")->where("id",$request->id)->first();

            $product->links= DB::table("category")->whereRaw("FIND_IN_SET(?,templates)",Cache::get("WapTemplate"))->where("id",$product->category_id)->value('links');
            $product->thumb_url= DB::table("category")->where("id",$product->category_id)->value('thumb_url');

            Cache::put('wap.product.'.$request->id,$product,$this->cachetime);
        }
        view()->share("title",$product->category_name.'-'.$product->title);
        view()->share("productview",$product);


        view()->share("productid",$request->id);

        $Memberamount=0;
        $UserId = $request->session()->get('UserId');
        if($UserId>0){
            $Member= Member::find($UserId);
            $Memberamount=$Member->amount;
        }
        view()->share("Memberamount",$Memberamount);

        return $this->WapShowTemplate("buy");

    }



    /**新闻**/


    public function articles(Request $request)
    {


        if($request->ajax()){

            $pagesize=10;
            $pagesize=Cache::get("pcpagesize");
            $where=[];

            if(Cache::has('wap.ArticlesList.'.$request->page.'.'.$request->links)){
                $articles=Cache::get('wap.ArticlesList.'.$request->page.'.'.$request->links);
            }else{

                if($request->links){
                    $category = DB::table("category")->whereRaw("FIND_IN_SET(?,templates)",Cache::get("WapTemplate"))->where("model", "articles")->where("links", $request->links)->first();
                    $where=["category_id"=> $category->id];
                }


                $articles = DB::table("articles")
                    ->where($where)
                    ->where("status", 2)
                    ->orderBy("sort","desc")
                    ->orderBy("id","desc")
                    ->paginate($pagesize);


                foreach($articles as $article){
                    $article->url=\route("article",["id"=>$article->id]);
                    $article->title=\App\Formatting::Format($article->title);
                }

                Cache::put('wap.ArticlesList.'.$request->page.'.'.$request->links,$articles,$this->cachetime);
            }

            return ["status"=>0,"list"=>$articles,"pagesize"=>$pagesize];
        }else {
            //分类信息

            if($request->links) {
                $category = DB::table("category")->whereRaw("FIND_IN_SET(?,templates)",Cache::get("WapTemplate"))->where("model", "articles")->where("links", $request->links)->first();

                if ($category) {








                    view()->share("title", $category->name );
                    view()->share("category", $category);






                    return $this->WapShowTemplate("articles");

                }
            }else{

                /**所有文章**/




                view()->share("title",  '新闻资讯' );





                return $this->WapShowTemplate("articles");


            }
        }




    }

    public function article(Request $request)
    {

        DB::table("articles")->where("id",$request->id)->increment('click_count',1);

        if(Cache::has('wap.article.'.$request->id)){
            $article=Cache::get('wap.article.'.$request->id);
        }else{
            $article=DB::table("articles")->where("id",$request->id)->first();

            $article->links= DB::table("category")->whereRaw("FIND_IN_SET(?,templates)",Cache::get("WapTemplate"))->where("id",$article->category_id)->value('links');
            $article->thumb_url= DB::table("category")->where("id",$article->category_id)->value('thumb_url');

            Cache::put('wap.article.'.$request->id,$article,$this->cachetime);
        }
        view()->share("title",$article->category_name);
        view()->share("article",$article);
        return $this->WapShowTemplate("article");


    }

    /**单页**/
    public function singlepages(Request $request)
    {



        view()->share("title",  '帮助说明');



        /**菜单导航栏**/
        if (Cache::has('wap.singlepagescategory')) {
            $articlescategory = Cache::get('wap.singlepagescategory');
        } else {
            $articlescategory = DB::table('category')->whereRaw("FIND_IN_SET(?,templates)",Cache::get("WapTemplate"))->where("model", "singlepages")->orderBy("sort", "desc")->get();

            Cache::put('wap.singlepagescategory', $articlescategory, $this->cachetime);
        }
        view()->share("articlescategory", $articlescategory);
        /**菜单导航栏 END **/


        return $this->WapShowTemplate("singlepages");


    }

    public function singlepage(Request $request)
    {

        if($request->links){
            DB::table("category")->whereRaw("FIND_IN_SET(?,templates)",Cache::get("WapTemplate"))->where("links",$request->links)->increment('click_count',1);

            if(Cache::has('wap.singlepage.'.$request->links)){
                $singlepage=Cache::get('wap.singlepage.'.$request->links);
            }else{
                $singlepage=DB::table("category")->whereRaw("FIND_IN_SET(?,templates)",Cache::get("WapTemplate"))->where("links",$request->links)->first();
                Cache::put('wap.singlepage.'.$request->links,$singlepage,$this->cachetime);
            }


        }else if($request->id){
            DB::table("category")->whereRaw("FIND_IN_SET(?,templates)",Cache::get("WapTemplate"))->where("id",$request->id)->increment('click_count',1);

            if(Cache::has('wap.singlepage.'.$request->id)){
                $singlepage=Cache::get('wap.singlepage.'.$request->id);
            }else{
                $singlepage=DB::table("category")->whereRaw("FIND_IN_SET(?,templates)",Cache::get("WapTemplate"))->where("id",$request->id)->first();
                Cache::put('wap.singlepage.'.$request->id,$singlepage,$this->cachetime);
            }


        }


        view()->share("title",$singlepage->name);
        view()->share("article",$singlepage);
        return $this->WapShowTemplate("singlepage");

    }


    /** 在线留言 **/
    public function SendMsg(Request $request)
    {

        $Post= $request->all();


        $data=[];
        if($Post['Type']=='QQ'){
            $data['msg']=$Post['Type'].'-'.$Post['InquiryType'];
            $data['qq']=$Post['TxtValue'];

        }else if($Post['Type']=='手机'){
            $data['msg']=$Post['Type'].'-'.$Post['InquiryType'];
            $data['phone']=$Post['TxtValue'];
        }else if($Post['Type']=='Tel'){
            $data['msg']=$Post['Type'].'-'.$Post['InquiryType'];
            $data['phone']=$Post['TxtValue'];
        }
        $data['tip']=$request->Tip."-".$request->productname;
        $data['pid']=$request->ProductID;
        $data['wx']=$request->WebChart;
        $data['name']=$request->Name;
        $data['sex']=$request->sex;
        $data['adddate']=Carbon::now();

        $msg=  DB::table("onlinemsg")->insert($data);

        return response()->json([
            "msg"=>"请求成功",
            "status"=>0
        ]);

    }



    public function appdown(Request $request){
        $app="Android";
        $links="Android.apk";

        if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
            $app="IOS";
            $links="IOS.ipa";
        }else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
            $app="Android";
            $links="Android.apk";
        }


        view()->share("app",$app);
        view()->share("links",$links);


        return $this->WapShowTemplate("appdown");
    }


    public function calculation(Request $request){


        return $this->WapShowTemplate("calculation");
    }

    public function piaofang(Request $request){


        return $this->WapShowTemplate("piaofang");
    }


    public function Seal(Request $request){

        $bljg=  Product::where("id",$request->id)->value("bljg");

        if($bljg==''){
            $bljg=Cache::get("CompanyLong");
        }

        $SealTextLeng=  mb_strlen($bljg);

        $seal = new Seal($bljg,100,5,50,0,-1,16,0,$SealTextLeng+5);
        $seal->doImg();
    }

    public function CompanySeal(Request $request){

        $bljg=Cache::get("CompanyLong");
        $SealTextLeng=  mb_strlen($bljg);
        $seal = new Seal($bljg,100,5,50,0,-1,16,0,$SealTextLeng+5);
        $seal->doImg();
    }



}


?>
