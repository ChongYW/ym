<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;
use DB;
use Cookie;
use Session;
use Illuminate\Support\Facades\Cache;
use App\Admin;
use App\Site;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use App\Productclassify;
use App\Product;
use App\Seting;
use Storage;


class BaseController extends Controller
{
    public function __construct(Request $request)
    {



        //验证受权功能
        $uuid='';
        $key='';

        $HttpHost=  $request->getHttpHost();

        if (! file_exists (public_path("uploads/UUID") )) {
            $uuid=str_random(40);
        }else{
            $uuid=  Storage::disk("uploads")->get('UUID');
        }

        if (file_exists ( public_path("uploads/KEYS") )) {
            $codes = Storage::disk("uploads")->get('KEYS');
            $codes = base64_decode($codes);

            try {

                $codes=str_replace( base64_encode(md5(md5($uuid))),"",$codes);

                $Dkeydata = Crypt::decrypt($codes);
                if(!empty($Dkeydata)) {


                    foreach($Dkeydata as $k=> $v){
                        $decryptData[$k] =  Crypt::decrypt($v);
                    }


                    if($decryptData['uuid'] !=$uuid){
                        $msg=$HttpHost . "受权UUID错误";
                        return response()->view("hui.error",["msg"=>$msg,"icon"=>"layui-icon-404"]);
                    }

                    $timer = Carbon::now();

                    $expiretime = Carbon::now()->setTimestamp(strtotime($decryptData['expiretime']));
                    $domain = $request->getHttpHost();
                    if ($timer > $expiretime) {
                        $msg=$HttpHost . "受权已过期,UUID[{$uuid}]m";
                        return response()->view("hui.error",["msg"=>$msg,"icon"=>"layui-icon-404"]);
                    }


                    $activation_domain=array_values($decryptData['domain']);

                    if (!in_array($domain, $activation_domain) && !in_array("*",$activation_domain)) {

                        $msg=$HttpHost . "域名未受权,您的UUID[{$uuid}]";
                        return response()->view("hui.error",["msg"=>$msg,"icon"=>"layui-icon-404"]);

                    }


                }

            } catch (DecryptException $e) {

            }



        }else {

            $msg = "您的网站占未受权，非法盗版使用，请购买受权使用！";
            //die($msg);

            return response()->view("hui.error",["msg"=>$msg,"icon"=>"layui-icon-404"]);

        }


        $this->DefaultTemplate=env('Template');
        $this->cachetime=1;

        $this->RouteName=  \Request::route()->getName();


        $RouteNames=  explode('.',$this->RouteName);

        $this->RouteController=$RouteNames[0].'.'.$RouteNames[1];
        $this->RouteAction=$RouteNames[2];

        $this->middleware(function($request, $next) {
            $Admin =$request->session()->get('Admin');
            $this->Admin = $Admin;

            Admin::where("id",$this->Admin->id)->update(['updated_at'=>Carbon::now()]);

            return $next($request);
        });

    }

    function ShowTemplate($data=[]){

        $TemplateFile=  explode('.',$this->RouteName);

        if (view()->exists($this->DefaultTemplate."." . $TemplateFile[1]."." . $TemplateFile[2])) {

            return view($this->DefaultTemplate."." . $TemplateFile[1]."." . $TemplateFile[2],$data);
        }else{

            return view("hui.error",["msg"=>"系统错误 '".$this->DefaultTemplate."." . $TemplateFile[1]."." . $TemplateFile[2]."' 模板未找到","icon"=>"layui-icon-404"]);
            //dd($this->DefaultTemplate."." . $TemplateFile[1]."." . $TemplateFile[2]."-模板不存在");
        }

    }
}
