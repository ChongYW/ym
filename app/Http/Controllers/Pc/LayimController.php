<?php

namespace App\Http\Controllers\Pc;
use App\Auth;
use App\Category;
use App\Channel;
use App\Http\Controllers\Controller;
use App\Member;
use App\Memberlevel;
use App\Membermsg;
use App\Memberphone;
use App\Memberticheng;
use App\Order;
use App\Product;
use App\Productbuy;
use App\Seting;
use Carbon\Carbon;
use DB;
use App\Admin;
use App\Ad;
use App\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;
use Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Storage;


class LayimController extends BaseController
{
    public $cachetime=600;
    public function __construct(Request $request)
    {

        parent::__construct($request);
        $this->middleware(function ($request, $next) {

            $UserId =$request->session()->get('UserId');

            if($UserId<1){
               // return redirect()->route("pc.login");
            }

           $this->Member= Member::find($UserId);

            if(!$this->Member){
              //  return redirect()->route("pc.loginout");
            }

            view()->share("Member",$this->Member);

            return $next($request);
        });


        /**网站缓存功能生成**/

        

        /**菜单导航栏**/
        if(Cache::has('wap.category')){
            $footcategory=Cache::get('wap.category');
        }else{
            $footcategory= DB::table('category')->whereRaw("FIND_IN_SET(?,templates)",Cache::get("PcTemplate"))->where("atfoot","1")->orderBy("sort","desc")->limit(5)->get();
            Cache::put('wap.category',$footcategory,$this->cachetime);
        }
        view()->share("footcategory",$footcategory);
        /**菜单导航栏 END **/


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

        view()->share("memberlevel",$memberlevel);
        view()->share("memberlevelName",$memberlevelName);



    }

    /***会员中心***/
    public function index(Request $request){


        $UserId =$request->session()->get('UserId');

        return $this->PcShowTemplate("layim.kefuadmin");


    }
    /***消息拉取***/
    public function getmsg(Request $request){


        $UserId =$request->session()->get('UserId');

        $layims= DB::table("layims")->where("touid",$UserId)->where("status",0)->orderBy("id","asc")->first();
        if($layims){
            DB::table("layims")->where("id",$layims->id)->update(["status"=>1]);

            //$msg['name']="在线客服";
            $msg['username']=$layims->fusername;
            $msg['id']=$layims->fromuid;
            $msg['type']=$layims->type;
            $msg['content']=$layims->content;
            //$msg['avatar']=asset("layim/images/avatar/".($layims->touid%10).".jpg");
            if($layims->fromuid>0){
                $picImg= Member::where('id',$layims->fromuid)->value('picImg');
                $msg['avatar']=$picImg!=''?$picImg:asset("layim/images/avatar/".($layims->fromuid%10).".jpg");
            }else{
                $picImg= Admin::where('id',-$layims->fromuid)->value('img');
                $msg['avatar']=$picImg!=''?$picImg:asset("layim/images/avatar/kf.png");
            }
            return $msg;
        }




    }

    /***消息发送***/
    public function send(Request $request){


        $UserId =$request->session()->get('UserId');
       // $msg= $request->all();

        $data['fusername'] =  $request->fusername;
        $data['tousername'] =  $request->username;
        $data['fromuid'] =  $request->fid;
        $data['touid'] =  $request->id;
        $data['type'] =  $request->type;
        $data['content'] =  $request->content;
        $data['created_at']=Carbon::now();
        $data['updated_at']=Carbon::now();





        $id= DB::table("layims")->insertGetId($data);


      //  DB::table($this->table)->where("id",$id)->update(["invicode"=>($id+513566)]);


        //return $msg;


    }

    /***在线客服***/
    public function kefu(Request $request){


        $UserId =$request->session()->get('UserId');

        return $this->PcShowTemplate("layim.kefu");


    }


    //上传图片
    public function uploadimgage(Request $request)
    {

        if ($request->isMethod('post')) {


            $file = $request->file('file');

            // 文件是否上传成功
            if ($file->isValid()) {

                // 获取文件相关信息
                $originalName = $file->getClientOriginalName(); // 文件原名
                $ext = $file->getClientOriginalExtension();     // 扩展名
                $realPath = $file->getRealPath();   //临时文件的绝对路径
                $type = $file->getClientMimeType();     // image/jpeg

                // 上传文件

                $path = "layim/".date ( 'Ymd'); // 接收文件目录

                if($request->get("filename")!=''){
                    $filename = $request->get("filename");
                }else{
                    $filename = time(). uniqid() . '.' . $ext;
                }


                $filepath=Seting::where("keyname","=","filepath")->first();

                $file_path=$filepath->value.'/'.$path;
                if (! file_exists ( "uploads/".$file_path )) {

                    Storage::disk("uploads")->makeDirectory($file_path);
                }

                $img = Image::make($file);


                $img->save("uploads/".$file_path."/".$filename);
                $imgurl="/uploads/".$file_path."/".$filename;


                return ["code"=>0 ,"msg"=>"上传成功","data"=>["src"=>$imgurl]];


            }

        }

    }




}


?>
