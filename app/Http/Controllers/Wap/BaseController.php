<?php

namespace App\Http\Controllers\Wap;
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
    public $DefaultTemplate;
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

        /**菜单导航栏**/

        $footcategory= DB::table('category')->whereRaw("FIND_IN_SET(?,templates)",config("web.WapTemplate"))->where("atfoot","1")->orderBy("sort","asc")->limit(5)->get();

        view()->share("footcategory",$footcategory);
        /**菜单导航栏 END **/




        //验证访问权限是否开启

        $this->middleware(function ($request, $next) {

            $UserId =$request->session()->get('UserId');

            if($UserId>=1){
                \App\Member::OnLineSet($UserId);

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

        if(Cache::get("WapTemplate")!=''){
            $this->DefaultTemplate="mobile.".Cache::get("WapTemplate");
        }else{
            $this->DefaultTemplate="mobile.".env('WapTemplate');
        }


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



    function WapShowTemplate($TemplateName,$data=[]){



        if (view()->exists($this->DefaultTemplate."." .$TemplateName )) {

            return view($this->DefaultTemplate."." . $TemplateName,$data);
        }else{

            return view("hui.error",["msg"=>"系统错误 '".$this->DefaultTemplate."." . $TemplateName."' 模板未找到","icon"=>"layui-icon-404"]);

        }

    }



}


?>
