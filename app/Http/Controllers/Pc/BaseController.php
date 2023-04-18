<?php

namespace App\Http\Controllers\Pc;
use App\Auth;
use App\Category;
use App\Channel;
use App\Http\Controllers\Controller;
use App\Log;
use App\Member;
use App\Memberphone;
use App\Order;
use App\Product;
use Carbon\Carbon;
use DB;
use App\Admin;
use App\Ad;
use App\Site;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Session;
use Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use App\Authorized;



class BaseController extends Controller
{
    public $cachetime=600;
    public function __construct(Request $request)
    {

        if(Cache::get('sitename')==''){
            Cache::flush();
        }

        if(!Cache::has('SetingTime')){
            Cache::flush();
            Cache::put('SetingTime',time(),60*60*2);
        }

        /**网站缓存功能生成**/

       if(!Cache::has('setings')){
           $setings=DB::table("setings")->get();
       
           if($setings){
       
               foreach($setings as $sv){
                   Cache::put($sv->keyname, $sv->value,$this->cachetime);
               }
               Cache::put("setings", $setings,$this->cachetime);
           }
       
       }



        //验证访问权限是否开启

        $this->middleware(function ($request, $next) {

            $UserId =$request->session()->get('UserId');

            if($UserId>=1){
                \App\Member::OnLineSet($UserId);

                $Member= Member::find($UserId);
                if($Member){
                    $this->Member=$Member;
                    view()->share("Member",$Member);
                }else{
                    $YKUserId =$request->session()->get('YKUserId');
                    if($YKUserId==''){
                        $YKUserId=rand(10000,99999).time();
                        $request->session()->put('YKUserId',$YKUserId, 120);
                    }


                    view()->share("YKUserId",$YKUserId);

                }

            }else{

                $YKUserId =$request->session()->get('YKUserId');
                if($YKUserId==''){
                    $YKUserId=rand(10000,99999).time();
                    $request->session()->put('YKUserId',$YKUserId, 120);
                }


                view()->share("YKUserId",$YKUserId);

            }



            return $next($request);
        });

        if(Cache::get("PcTemplate")!=''){
            $this->DefaultTemplate="pc.".Cache::get("PcTemplate");
        }else{
            $this->DefaultTemplate="pc.".env('PcTemplate');
        }



        /**广告数据**/
        $Ad=new Ad();

        if(Cache::has("pc.ad")){
            $wapad= Cache::get("pc.ad");
            view()->share("pcad",$wapad );
        }else{
            $wapad['banner']=$Ad->GetAd('电脑端幻灯片');
            $wapad['hongbao']=$Ad->GetAd('首页邀请好友红包');
            $wapad['houdong']=$Ad->GetAd('活动浮动广告');
            $wapad['hzmt']=$Ad->GetAd('合作媒体');
            $wapad['bottombanner']=$Ad->GetAd('电脑端首页底部通栏');
            Cache::put("pc.ad",$wapad,$this->cachetime);
            view()->share("pcad", $wapad);
        }




        /**菜单导航栏**/
        if(Cache::has('pc.category')){
            $footcategory=Cache::get('pc.category');
        }else{
            $footcategory= DB::table('category')->whereRaw("FIND_IN_SET(?,templates)",Cache::get("PcTemplate"))->where("ismenus","1")->orderBy("sort","asc")->limit(8)->get();
            Cache::put('pc.category',$footcategory,$this->cachetime);
        }


        view()->share("categorys",$footcategory);
        /**菜单导航栏 END **/

        /**项目分类菜单导航栏**/
        if(Cache::has('pc.ProductsCategory')){
            $ProductsCategory=Cache::get('pc.ProductsCategory');
        }else{
            $ProductsCategory= Category::where("model","products")->whereRaw("FIND_IN_SET(?,templates)",Cache::get("PcTemplate"))->where("atindex","1")->orderBy("sort","asc")->get();

            foreach ($ProductsCategory as $item) {
                $item->Products=DB::table("products")->where("category_id",$item->id)->where("issy","1")->where("status", "1")->orderBy("sort","asc")->get();
            }

            Cache::put('pc.ProductsCategory',$ProductsCategory,$this->cachetime);
        }


        view()->share("ProductsCategory",$ProductsCategory);
        /**项目分类菜单导航栏 END **/


        /**项目分类列表**/
        if(Cache::has('wap.ProductsCategoryList')){
            $ProductsCategoryList=Cache::get('wap.ProductsCategoryList');
        }else{
            $ProductsCategoryList= Category::where("model","products")->whereRaw("FIND_IN_SET(?,templates)",Cache::get("PcTemplate"))->where("ismenus","1")->orderBy("sort","asc")->orderBy("created_at","desc")->get();

            Cache::put('wap.ProductsCategoryList',$ProductsCategoryList,$this->cachetime);
        }



        view()->share("ProductsCategoryList",$ProductsCategoryList);
        /**项目分类菜单导航栏 END **/


        $NavCategory= Category::whereIn("model",["products","articles","singlepages"])->whereRaw("FIND_IN_SET(?,templates)",Cache::get("PcTemplate"))->orderBy("sort","asc")->get();

        view()->share("NavCategory",$NavCategory);


        $kefulinks=DB::table('category')->where("name","在线客服")->value("links");
        view()->share("kefulinks",$kefulinks);


        /**20200130 项目自动发布功能 **/
        $Products=  Product::where("tzzt","-1")->get();
        if($Products){
            foreach ($Products as $product) {

                /**20200130 项目自动发布功能 **/


                    if (Carbon::now()->getTimestamp() >= strtotime($product->countdown)) {
                        Cache::flush();
                        $product->tzzt=0;
                        $product->save();

                    }



            }
        }


    }



    function PcShowTemplate($TemplateName,$data=[]){



        if (view()->exists($this->DefaultTemplate."." .$TemplateName )) {

            return view($this->DefaultTemplate."." . $TemplateName,$data);
        }else{

            return view("hui.error",["msg"=>"系统错误 '".$this->DefaultTemplate."." . $TemplateName."' 模板未找到","icon"=>"layui-icon-404"]);

        }

    }



}


?>
