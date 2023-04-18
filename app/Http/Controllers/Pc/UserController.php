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
use App\Moneylog;
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

class UserController extends BaseController
{
    public $cachetime=600;
    public function __construct(Request $request)
    {

        parent::__construct($request);
        $this->middleware(function ($request, $next) {
            //dd($request->session()->all());

            $UserId =$request->session()->get('UserId');

            if($UserId<1){
                return redirect()->route("wap.login");
            }

           $this->Member= Member::find($UserId);

            if(!$this->Member){
                return redirect()->route("wap.loginout");
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

            $Productbuys=  Productbuy::where("userid",$UserId)->limit(10)->orderBy("id","desc")->get();

            view()->share("Productbuys",$Productbuys);


            $ShouYis=  Moneylog::where("moneylog_userid",$UserId)
                ->where("moneylog_status","+")
                ->where("moneylog_type","项目分红")
                ->limit(10)
                ->orderBy("id","desc")
                ->get();


            view()->share("ShouYis",$ShouYis);


            $buys=  Productbuy::where("userid",$UserId)->where("status","1")->orderBy("id","desc")->get();

            $daiShouyi=0;
            foreach ($buys as $By){
                $daiShouyi+=($By->amount)*(\App\Product::GetShouYi($By->productid)/100)*($By->sendday_count-$By->useritem_count);
            }

            view()->share("daiShouyi",$daiShouyi);

           return $this->PcShowTemplate("user.index");


    }


    /****我的资料***/
    public function my(Request $request){


        $UserId =$request->session()->get('UserId');

           return $this->PcShowTemplate("user.my");


    }





    /***会员登录日志***/
    public function loginloglist(Request $request){


        if($request->ajax()){
            $UserId =$request->session()->get('UserId');
                $pagesize=6;
                $pagesize=Cache::get("pcpagesize");
                $where=[];

                $list = DB::table("memberlogs")
                    ->where("userid",$UserId)
                    ->orderBy("id","desc")
                    ->paginate($pagesize);
                foreach ($list as $item){
                    $item->date=date("m-d H:i",strtotime($item->created_at));
                }

            return ["status"=>0,"list"=>$list,"pagesize"=>$pagesize];
        }else {

            return $this->PcShowTemplate("user.memberlogs");
        }


    }



    /***会员资料修改***/
    public function edit(Request $request){


        if($request->ajax()){
            $UserId =$request->session()->get('UserId');

           $EditMember= Member::where("id",$UserId)->first();

           if($EditMember){

               $i=[];

               if($EditMember->realname==''){

                   if(Cache::get('RealNameOnly')=='开启'){
                       if(\App\Member::RealNameOnly(trim($request->realname))){
                           return ["status"=>1,"msg"=>"真实姓名已存在"];
                       }else{
                           $EditMember->realname=trim($request->realname);
                           $i[]='realname';
                       }

                   }else{

                       $EditMember->realname=trim($request->realname);
                       $i[]='realname';
                   }




               }

               if($EditMember->card==''){


                   if(mb_strlen($request->card,"UTF-8") != 18){
                       return ["status"=>1,"msg"=>"身份证号码格式错误"];
                   }

                   if(Cache::get('rename')=='开启'){

                       $Renzheng=\App\Member::IdCard($request->realname,$request->card);

                       if(isset($Renzheng['status']) && $Renzheng['status']=='01'){
                          // return ["status"=>0,"msg"=>"实名认证通过","data"=>$Renzheng];
                       }else{
                           return ["status"=>1,"msg"=>"实名认证不通过","data"=>$Renzheng];
                       }

                   }


                   $card=  Member::where("card",$request->card)->first();

                   if($card){
                       return ["status"=>1,"msg"=>"身份证号码已注册"];
                   }


                   $EditMember->card=trim($request->card);
                   $i[]='realname';
               }

               if($EditMember->qq==''){
                   $EditMember->qq=trim($request->qq);
                   $i[]='realname';
               }

               $EditMember->save();

               if(count($i)){
                   return ["status"=>0,"msg"=>"修改成功"];
               }else{
                   return ["status"=>0,"msg"=>"修改成功"];
               }



           }
        }else {

            return $this->PcShowTemplate("user.edit");
        }


    }

    /***会员银行信息***/
    public function bank(Request $request){


        if($request->ajax()){
            $UserId =$request->session()->get('UserId');

           $EditMember= Member::where("id",$UserId)->first();

           if($EditMember){

               $i=[];

               if($EditMember->bankname==''){
                   $EditMember->bankname=trim($request->bankname);
                   $i[]='bankname';
               }

               if($EditMember->bankrealname==''){

                   $EditMember->bankrealname=trim($request->bankrealname);
                   $i[]='bankrealname';
               }

               if($EditMember->bankcode==''){
                   $EditMember->bankcode=trim($request->bankcode);
                   $i[]='bankcode';
               }
               if($EditMember->bankaddress==''){
                   $EditMember->bankaddress=trim($request->bankaddress);
                   $i[]='bankaddress';
               }

               $EditMember->isbank=1;
               $EditMember->save();

               if(count($i)){
                   return ["status"=>0,"msg"=>"修改成功"];
               }else{
                   return ["status"=>1,"msg"=>"修改失败"];
               }



           }
        }else {

            return $this->PcShowTemplate("user.bank");
        }


    }

    /***会员认证中心***/
    public function certification(Request $request){


            return $this->PcShowTemplate("user.certification");


    }



    /***会员手机认证***/
    public function phone(Request $request){


        if($request->ajax()){
            $UserId =$request->session()->get('UserId');

           $EditMember= Member::where("id",$UserId)->first();

           if($EditMember){
               $mobile=$request->mobile;

            // $password= \App\Member::DecryptPassWord($EditMember->password);

               $isPhones= Memberphone::IsUpdate($mobile,$UserId);

               if ($isPhones) {
                   return array('msg'=>"手机号已存在",'status'=>"1");
               }


               if ($request->telcode=='') {
                   return array('msg'=>"请输入短信验证码",'status'=>"1");
               }

               if ($request->telcode!=Cache::get("mobile.code.".$mobile)) {
                   return array('msg'=>"你输入的短信验证码错误",'status'=>"1");
               }
               $EditMember->ismobile=1;
               $EditMember->mobile=\App\Member::EncryptPassWord($request->mobile);
               $EditMember->save();


               return ["status"=>0,"msg"=>"手机认证成功"];




           }
        }else {

            return $this->PcShowTemplate("user.phone");
        }


    }

    /***会员手机认证***/
    public function security(Request $request){


        if($request->ajax()){
            $UserId =$request->session()->get('UserId');

           $EditMember= Member::where("id",$UserId)->first();

           if($EditMember){

               $EditMember->question=$request->question;
               $EditMember->answer=$request->answer;
               $EditMember->isquestion=1;
               //$EditMember->mobile=\App\Member::EncryptPassWord($request->mobile);
               $EditMember->save();


               return ["status"=>0,"msg"=>"密保设置成功"];




           }
        }else {

            return $this->PcShowTemplate("user.security");
        }


    }



    /***会员密码修改***/
    public function password(Request $request){


        if($request->ajax()){
            $UserId =$request->session()->get('UserId');

           $EditMember= Member::where("id",$UserId)->first();

           if($EditMember){


             $password= \App\Member::DecryptPassWord($EditMember->password);

               if($request->pass!=$password){
                   return ["status"=>1,"msg"=>"输入旧密码错误"];
               }

               if($request->newpass!=$request->renewpass){
                   return ["status"=>1,"msg"=>"输入两次密码不至"];
               }

               $EditMember->password=\App\Member::EncryptPassWord($request->newpass);
               $EditMember->save();


               return ["status"=>0,"msg"=>"登录密码修改成功"];




           }
        }else {

            return $this->PcShowTemplate("user.password");
        }


    }


    /***会员交易密码修改***/
    public function paypwd(Request $request){


        if($request->ajax()){
            $UserId =$request->session()->get('UserId');

           $EditMember= Member::where("id",$UserId)->first();

           if($EditMember){

               $mobile= \App\Member::DecryptPassWord($EditMember->mobile);


                $paypwd= \App\Member::DecryptPassWord($EditMember->paypwd);

               if($request->pass=='' || $request->newpass=='' || $request->renewpass==''){
                   return ["status"=>1,"msg"=>"请输入密码"];
               }

               if($request->pass!=$paypwd){
                   return ["status"=>1,"msg"=>"输入旧密码错误"];
               }

               if($request->newpass!=$request->renewpass){
                   return ["status"=>1,"msg"=>"输入两次密码不至"];
               }


/*
               if ($request->telcode=='') {
                   return array('msg'=>"请输入短信验证码",'status'=>"1");
               }

               if ($request->telcode!=Cache::get("mobile.code.".$mobile)) {
                   return array('msg'=>"你输入的短信验证码错误",'status'=>"1");
               }*/


               $EditMember->paypwd=\App\Member::EncryptPassWord($request->newpass);
               $EditMember->save();


               return ["status"=>0,"msg"=>"交易密码修改成功"];




           }
        }else {

            return $this->PcShowTemplate("user.paypwd");
        }


    }


    /***会员重置交易密码修改***/
    public function retrieve(Request $request){


        if($request->ajax()){
            $UserId =$request->session()->get('UserId');

           $EditMember= Member::where("id",$UserId)->first();

           if($EditMember){

               $mobile= \App\Member::DecryptPassWord($EditMember->mobile);



               if ($request->telcode=='') {
                   return array('msg'=>"请输入短信验证码",'status'=>"1");
               }

               if ($request->telcode!=Cache::get("mobile.code.".$mobile)) {
                   return array('msg'=>"你输入的短信验证码错误",'status'=>"1");
               }


               if( $request->newpass=='' || $request->renewpass==''){
                   return ["status"=>1,"msg"=>"请输入密码"];
               }


               if($request->newpass!=$request->renewpass){
                   return ["status"=>1,"msg"=>"输入两次密码不至"];
               }




               $EditMember->paypwd=\App\Member::EncryptPassWord($request->newpass);
               $EditMember->save();


               return ["status"=>0,"msg"=>"交易密码修改成功"];




           }
        }else {

            return $this->PcShowTemplate("user.retrieve");
        }


    }


    /***会员短信验证码发送***/
    public function SendCode(Request $request){


        if($request->ajax()){
            $UserId =$request->session()->get('UserId');

            $EditMember= Member::where("id",$UserId)->first();

            $mobile= \App\Member::DecryptPassWord($EditMember->mobile);

            \App\Sendmobile::SendPhone($mobile,$request->action,'');//短信通知

            if($request->ajax()){
                return response()->json([
                    "msg"=>"短信验证码发送成功","status"=>0
                ]);
            }


        }


    }


    /***会员认证短信验证码发送***/
    public function SendRZCode(Request $request){


        if($request->ajax()){
            $UserId =$request->session()->get('UserId');

            $EditMember= Member::where("id",$UserId)->first();

           // $mobile= \App\Member::DecryptPassWord($EditMember->mobile);

            \App\Sendmobile::SendPhone($request->mobile,$request->action,'');//短信通知

            if($request->ajax()){
                return response()->json([
                    "msg"=>"短信验证码发送成功","status"=>0
                ]);
            }


        }


    }


    /**站内消息管理**/

    /***消息列表***/
    public function msglist(Request $request){


        if($request->ajax()){
            $UserId =$request->session()->get('UserId');
                $pagesize=6;
                $pagesize=Cache::get("pcpagesize");
                $where=[];

                $list = DB::table("membermsg")
                    ->where("userid",$UserId)
                    ->orderBy("id","desc")
                    ->paginate($pagesize);
                foreach ($list as $item){
                    $item->date=date("m-d H:i",strtotime($item->created_at));
                }

            return ["status"=>0,"list"=>$list,"pagesize"=>$pagesize];
        }else {

            return $this->PcShowTemplate("user.msglist");
        }


    }

    /***投资产品***/
    public function products(Request $request){


        if($request->ajax()){
            $UserId =$request->session()->get('UserId');


                $pagesize=6;
                $pagesize=Cache::get("pcpagesize");
                $where=[];

                $list = DB::table("products")
                    ->orderBy("sort","desc")
                    ->paginate($pagesize);
                foreach ($list as $item){
                    $item->date=date("m-d H:i",strtotime($item->created_at));
                    $item->url=route("product",["id"=>$item->id]);
                }

            return ["status"=>0,"list"=>$list,"pagesize"=>$pagesize];
        }else {

            return $this->PcShowTemplate("user.products");
        }


    }



    /**站内消息标记已读**/

    public function MsgRead(Request $request){


        if($request->ajax()){
            $UserId =$request->session()->get('UserId');
            DB::table("membermsg")
                ->where("userid",$UserId)
                ->where("id",$request->id)
                ->update(["status"=>1]);



            return ["status"=>0,"msg"=>"已读"];
        }





    }

    /**站内消息删除**/
    public function MsgDel(Request $request){


        if($request->ajax()){

            if(count($request->id)<1){
                return ["status"=>1,"msg"=>"请选择再删除"];
            }
            $UserId =$request->session()->get('UserId');
            DB::table("membermsg")
                ->where("userid",$UserId)
                ->whereIn("id",$request->id)
                ->delete();

            return ["status"=>0,"msg"=>"已删除"];
        }

    }



    /***站内消息结束***/





    /****项目购买*****/
    public function nowToMoney(Request $request){


        if($this->Member->locking==1){
            return response()->json([
                "msg"=>Cache::get("MemberLockingMsg"),"status"=>1
            ]);
        }

        if($request->session()->get('nowToMoneyUTime')>time()-3){
            return response()->json([
                "msg"=>"请稍等一下,服务器正在处理","status"=>0
            ]);
        }

        $request->session()->put('nowToMoneyUTime', time(), 120);


            if($this->Member->realname=='' || $this->Member->card==''){
                return response()->json([
                    "msg"=>"请先进行实名认证","status"=>1,"url"=>route("user.edit")
                ]);
            }

        //购买项目

            //die("ceshi");
            $amountPay = trim($request->amountPay);
            $idPay 	   = intval($request->idPay);
            $pwdPay    = trim($request->pwdPay);

            if(!$amountPay || !$idPay || !$pwdPay ){
                echo json_encode(array('status'=>0,'msg'=>"数据存在异常，请刷新尝试"));
                die();
            }

            //判断项目是否存在

            $Product=  Product::find($idPay);
            //$sqlsc = "select * from  {$db_prefix}project where id = '".$idPay."'";
            //$rssc = $db->get_one($sqlsc);
            if(!$Product){
                echo json_encode(array('status'=>0,'msg'=>"项目不存在，请刷新尝试"));
                die();
            }


            if($Product->isaouttm==1){

                $endtime=strtotime($Product->endingtime);
                if($endtime<Carbon::now()->getTimestamp()){
                    echo json_encode(array('status'=>0,'msg'=>"该项目已经停止投资"));
                    die();
                }
            }





            $hkfs      = trim($Product->hkfs);	//还款方式
            $zhouqi    = trim($Product->shijian);//周期
            $isft      = trim($Product->isft);	//判断是否复投
            $tqsyyj    = intval(trim($Product->tqsyyj));	//提取收益佣金
            $futoucishu    = trim($Product->futoucishu);	//复投次数限制

            //判断投资是否投过
            if($isft == 0){
               $Productbuy= Productbuy::where("productid",$idPay)->where("userid",$this->Member->id)->count();
                if($Productbuy>=$futoucishu){
                    echo json_encode(array('status'=>0,'msg'=>"抱歉，当前项目只允许投".$futoucishu."次。"));
                    die();
                }
            }else if($isft == 1){
                $Productbuy= Productbuy::where("productid",$idPay)->where("userid",$this->Member->id)->count();
                if($Productbuy>=$futoucishu){
                    echo json_encode(array('status'=>0,'msg'=>"此项目只允许投".$futoucishu."次。"));
                    die();
                }
            }

            //判断项目是否停止
            if($Product->tzzt == 1){
                echo json_encode(array('status'=>0,'msg'=>"该项目已经停止投资"));
                die();
            }

            //判断项目是否停止
            if($Product->tzzt == -1){
                echo json_encode(array('status'=>0,'msg'=>"该项目尚未开始投资"));
                die();
            }

            if(is_int($amountPay)){
                echo json_encode(array('status'=>0,'msg'=>"金额必须整数倍"));
                die();
            }

            //判断起投数量
            if($Product->qtje > $amountPay){
                echo json_encode(array('status'=>0,'msg'=>"你输入的小于起投金额"));
                die();
            }

            //判断最高投
            if((int)$Product->zgje !== 0){
                if($amountPay > $Product->zgje){
                    echo json_encode(array('status'=>0,'msg'=>"该项目最高可投金额为".$Product->zgje));
                    die();
                }
            }


            //判断密码是否正确 dd($this->Member->id);
            //$sql2pwd = "select pwd,amount,paypwd from  {$db_prefix}member where username = '".$username."'";
            //$rs2pwd = $db->get_one($sql2pwd);
            $BuyMember=  Member::where("id",$this->Member->id)->first();


            if($Product->level>$BuyMember->level){

                echo json_encode(array('status'=>0,'msg'=>"抱歉，你的会员级别不能投资本项目。"));
                die();

            }

            $paypwd= $BuyMember->paypwd;
            $Mamount=  $BuyMember->amount;
            if(\App\Member::DecryptPassWord($paypwd) !== $pwdPay){
                echo json_encode(array('status'=>0,'msg'=>"您输入的交易密码错误"));
                die();
            }

            if(floatval($Mamount) < floatval($amountPay)){
                echo json_encode(array('status'=>0,'msg'=>"您的金额不足，请进行充值"));
                die();
            }

            if(intval($Product->zgje) > 0) {
                //总投资金额限制
                $BuyAmounts = Productbuy::where("productid", $Product->id)
                    ->where("userid", $this->Member->id)
                    ->sum('amount');

                if (($BuyAmounts + $amountPay) > $Product->zgje) {
                    echo json_encode(array('status' => 0, 'msg' => "该项目最高可投金额为" . $Product->zgje . ",您已购买" . $BuyAmounts));
                    die();
                }
            }

            //判断下一次领取时间
            if($hkfs == 0 || $hkfs == 3 || $hkfs == 4){
                if($Product->qxdw == '个交易日'){
                    $zq = weekname(date('w',time()));
                    switch ($zq) {
                        case '星期一':
                            $useritem_time2 = \App\Productbuy::DateAdd("d",1, date('Y-m-d H:i:s',time()));
                            break;
                        case '星期二':
                            $useritem_time2 = \App\Productbuy::DateAdd("d",1, date('Y-m-d H:i:s',time()));
                            break;
                        case '星期三':
                            $useritem_time2 = \App\Productbuy::DateAdd("d",1, date('Y-m-d H:i:s',time()));
                            break;
                        case '星期四':
                            $useritem_time2 = \App\Productbuy::DateAdd("d",1, date('Y-m-d H:i:s',time()));
                            break;
                        case '星期五':
                            $useritem_time2 = \App\Productbuy::DateAdd("d",3, date('Y-m-d H:i:s',time()));
                            break;
                        case '星期六':
                            $useritem_time2 = \App\Productbuy::DateAdd("d",2, date('Y-m-d H:i:s',time()));
                            break;
                        case '星期日':
                            $useritem_time2 = \App\Productbuy::DateAdd("d",1, date('Y-m-d H:i:s',time()));
                            break;
                        default:break;
                    }
                }else if($Product->qxdw =='个自然日'){
                    $useritem_time2 = \App\Productbuy::DateAdd("d",1, date('Y-m-d H:i:s',time()));
                }else{
                    $useritem_time2 = \App\Productbuy::DateAdd("h",1, date('Y-m-d H:i:s',time()));
                }
            }else if($hkfs == 1){
                if($Product->qxdw == '个交易日'){
                    $z = 0 ;
                    for($ii =0 ;$ii<$zhouqi;$ii++){
                        $xhrq = \App\Productbuy::DateAdd("d",$ii, date('Y-m-d',time()));
                        $abc  = \App\Productbuy::weekname(date('w',$xhrq));
                        if($abc == "星期六"){
                            $z=$z+1;
                        }else if($abc == "星期日"){
                            $z=$z+1;
                        }else{
                            $zhouqi=$zhouqi+$z;
                            $useritem_time2 = \App\Productbuy::DateAdd("d",$zhouqi, date('Y-m-d H:i:s',time()));
                        }
                    }
                }else if($Product->qxdw =='个自然日'){
                    $useritem_time2 = \App\Productbuy::DateAdd("d",$zhouqi, date('Y-m-d H:i:s',time()));
                }else{
                    $useritem_time2 = \App\Productbuy::DateAdd("h",$zhouqi, date('Y-m-d H:i:s',time()));
                }
            }else{
                $useritem_time2 = \App\Productbuy::DateAdd("h",1, date('Y-m-d H:i:s', time()));
            }
            $ip = $request->getClientIp();
            $notice = "加入项目(".$Product->title.")(-)";
            //meoneyLog($this->Member->username,$amountPay,$ip,$notice,'-'); //金额记录日志



        //站内消息
        $msg=[
            "userid"=>$this->Member->id,
            "username"=>$this->Member->username,
            "title"=>"加入项目",
            "content"=>"成功加入项目(".$Product->title.")",
            "from_name"=>"系统通知",
            "types"=>"加入项目",
        ];
        \App\Membermsg::Send($msg);



        $BuyMember->decrement('amount',$amountPay);
        $log=[
            "userid"=>$this->Member->id,
            "username"=>$this->Member->username,
            "money"=>$amountPay,
            "notice"=>$notice,
            "type"=>"加入项目",
            "status"=>"-",
            "yuanamount"=>$Mamount,
            "houamount"=>$BuyMember->amount,
            "ip"=>\Request::getClientIp(),
        ];

        \App\Moneylog::AddLog($log);


            $sendDay_count = $hkfs == 1?1:$zhouqi;

           $NewProductbuy= new Productbuy();
            //插入项目


            $NewProductbuy->userid=$BuyMember->id;
            $NewProductbuy->username=$BuyMember->username;
            $NewProductbuy->productid=$idPay;
            $NewProductbuy->amount=$amountPay;
            $NewProductbuy->ip=$ip;
            $NewProductbuy->useritem_time=Carbon::now();
            $NewProductbuy->useritem_time2=$useritem_time2;
            $NewProductbuy->level=$BuyMember->level;
            $NewProductbuy->sendDay_count=$sendDay_count;
            $NewProductbuy->save();

            $Proxxtcbl=[];
            if($Product->xxtc==1){
                $Proxxtcbl=json_decode($Product->xxtcbl,true);
            }

            if(!$NewProductbuy->id){
                echo json_encode(array('status'=>0,'msg'=>"投资失败，请重新操作"));
                die();
            }else{
                //插入上家分成,百分比奖励
                //当前用户上家

               $Tichengs= Memberticheng::orderBy("id","asc")->get();
                //$checkBayong = \App\Productbuy::checkBayong($idPay);
                $username= $buyman = $this->Member->username;

               foreach ($Tichengs as $recent){
                   $shangjia = \App\Productbuy::checkTjr($username);//上家姓名
                   if ($shangjia=='') {
                       break;
                   }
                   $ShangjiaMember= Member::where("username",$shangjia)->first();
                   //dd($shangjia);
                   if (!$ShangjiaMember) {
                       break;
                   }

                   if(isset($Proxxtcbl[$recent->id])){
                       $recentpercent= $Proxxtcbl[$recent->id];
                   }else{
                       $recentpercent= $recent->percent;
                   }

                    //分成钱数
                    $rewardMoney = $amountPay  * $recentpercent  / 100;

                   if($rewardMoney>0) {

                       $title = "尊敬的{$shangjia}会员您好！您的{$recent->name}分成已到账";
                       $content = "您的下线{$buyman}购买产品成功,{$rewardMoney}元已赠送到您的账号,当前的提成比例为" . $recentpercent . "%";
                       //站内消息
                       $msg = [
                           "userid" => $ShangjiaMember->id,
                           "username" => $ShangjiaMember->username,
                           "title" => $title,
                           "content" => $content,
                           "from_name" => "系统通知",
                           "types" => "下线购买分成",
                       ];
                       \App\Membermsg::Send($msg);


                       $MOamount = $ShangjiaMember->amount;

                       $ShangjiaMember->increment('amount', $rewardMoney);

                       $notice = "下线购买项目分成(" . $Product->title . ")(+)";

                       $log = [
                           "userid" => $ShangjiaMember->id,
                           "username" => $ShangjiaMember->username,
                           "money" => $rewardMoney,
                           "notice" => $notice,
                           "type" => "下线购买分成",
                           "status" => "+",
                           "yuanamount" => $MOamount,
                           "houamount" => $ShangjiaMember->amount,
                           "ip" => \Request::getClientIp(),
                       ];


                       \App\Moneylog::AddLog($log);

                       $data = [
                           "userid" => $ShangjiaMember->id,
                           "username" => $ShangjiaMember->username,
                           "xxuserid" => $BuyMember->id,
                           "xxusername" => $BuyMember->username,
                           "amount" => $amountPay,
                           "preamount" => $rewardMoney,
                           "type" => "下线分成",
                           "status" => "1",
                           "xxcenter" => $recent->name,
                           "created_at" => Carbon::now(),
                           "updated_at" => Carbon::now(),
                       ];

                       DB::table("membercashback")->insert($data);
                   }
                   $username=$shangjia;

                }

                $member_level_amount= Productbuy::where("userid",$this->Member->id)->sum("amount");

                //用户等级
                $levels= Memberlevel::where("inte","<=",$member_level_amount)->orderBy("id","desc")->first();


                if($BuyMember->level<$levels->id){
                    $BuyMember->level=$levels->id;
                    $BuyMember->save();
                }

                echo json_encode(array('status'=>1,'msg'=>"投资成功，请进入会员中心进行管理","member_level_amount"=>$member_level_amount,"levels"=>$levels,"userid"=>$this->Member->id));
                die();
            }




    }


    public function msg(Request $request){



        $UserId = $request->session()->get('UserId');

        $layims=  DB::table("layims")->where("touid",$UserId)->where("status",0)->count();


        if(Cache::has("msgs." . $UserId)){
            $msgcount=Cache::get("msgs." . $UserId);
            //$msgcount =$msgcount +$layims;
            return ["playSound"=>0,"msgs"=>$msgcount,"layims"=>$layims];

        }else {
            $msgcount = Membermsg::where("userid", $UserId)->where("status", "0")->count();
           // $msgcount =$msgcount +$layims;
            Cache::put("msgs." . $UserId, $msgcount, 60);
            return ["playSound"=>1,"msgs"=>$msgcount,"layims"=>$layims];

        }




    }

    public function Memberamount(Request $request){

        $UserId = $request->session()->get('UserId');
        $Member= Member::find($UserId);
        echo $Member->amount;


    }





    /***会员签到***/
    public function qiandao(Request $request){


        if($request->ajax()){
            $UserId =$request->session()->get('UserId');
              $moneys= Cache::get("qiandao");
              $content= $notice= "今日已签到";

            $qiandaotime=strtotime($this->Member->lastqiandao);
           if($moneys>0 && $qiandaotime< strtotime(date("Y-m-d",time()))){

               $content= $notice= "签到".$moneys."元";
               //站内消息
               $msg=[
                   "userid"=>$this->Member->id,
                   "username"=>$this->Member->username,
                   "title"=>"今日签到",
                   "content"=>$content,
                   "from_name"=>"系统通知",
                   "types"=>"每日签到",
               ];
               \App\Membermsg::Send($msg);


               $MOamount=$this->Member->amount;

               $this->Member->lastqiandao=Carbon::now();
               $this->Member->save();

               $this->Member->increment('amount',$moneys);
               $log=[
                   "userid"=>$this->Member->id,
                   "username"=>$this->Member->username,
                   "money"=>$moneys,
                   "notice"=>$notice,
                   "type"=>"每日签到",
                   "status"=>"+",
                   "yuanamount"=>$MOamount,
                   "houamount"=>$this->Member->amount,
                   "ip"=>\Request::getClientIp(),
               ];

               \App\Moneylog::AddLog($log);

           }

            return ["status"=>0,"msg"=>$notice];
        }else {

            //return view("wap.user.memberlogs");
        }


    }


    public function QrCodeBg(Request $request){

        header( "Content-type: image/jpeg");
        $logo= public_path('uploads/'.Cache::get("appdownloge"));
        $QrCode = QrCode::encoding('UTF-8')->format('png')
            ->size(500)
            ->margin(1)
            ->errorCorrection('H')
            ->merge($logo, .3, true)
            ->generate(Cache::get('AppDownloadUrl'),public_path('uploads/ewm.png'));

        $file= public_path('uploads/'.Cache::get("APPErwmbj"));

        $file ='uploads/'.Cache::get("APPErwmbj");

        $img = Image::make($file)
            ->insert(public_path('uploads/ewm.png'), 'bottom-right', 115, 160)
            ->resize(750, 1200);


        $title = Cache::get("codetitle");
        $img->text($title, 120, 80, function ($font) {
            $font->file(public_path('uploads/font/PingFang.ttc'));
            $font->size(60);
            $font->color('#fff000');
        });

        $invicode = "推广ID:".$this->Member->invicode;
        $img->text($invicode, 260, 1150, function ($font) {
            $font->file(public_path('uploads/font/msyhbd.ttf'));
            $font->size(40);
            $font->color('#ffffff');
        });


        return $img->response('jpg');



    }





    /***大转盘游戏***/
    public function lotterys(Request $request){


        if($request->ajax()){
            $UserId =$request->session()->get('UserId');


            $pagesize=6;
            $pagesize=Cache::get("pcpagesize");
            $where=[];

            $list = DB::table("products")
                ->orderBy("sort","desc")
                ->paginate($pagesize);
            foreach ($list as $item){
                $item->date=date("m-d H:i",strtotime($item->created_at));
                $item->url=route("product",["id"=>$item->id]);
            }

            return ["status"=>0,"list"=>$list,"pagesize"=>$pagesize];
        }else {

            return $this->PcShowTemplate("user.lotterys");
        }


    }

    /***我的签名***/
    public function sign(Request $request){


        if($request->ajax()){
            $UserId =$request->session()->get('UserId');

            Member::where("id",$UserId)->update(["sign"=>$request->sign]);

            return ["status"=>0,"msg"=>$request->sign];
        }


    }



    //上传缩略图
    public function uploadimg(Request $request)
    {

        if ($request->isMethod('post')) {

            $UserId =$request->session()->get('UserId');
            if($request->file('file')){
                $file = $request->file('file');
            }else if($request->file('thumb')){
                $file = $request->file('thumb');
            }
            //$file = $request->file('thumb');

            // 文件是否上传成功
            if ($file->isValid()) {

                // 获取文件相关信息
                $originalName = $file->getClientOriginalName(); // 文件原名
                $ext = $file->getClientOriginalExtension();     // 扩展名
                $realPath = $file->getRealPath();   //临时文件的绝对路径
                $type = $file->getClientMimeType();     // image/jpeg

                // 上传文件

                $path = date ( 'Ymd'); // 接收文件目录

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
                $config=Seting::where("keyname","=","thumbsize")->first();
                $imgconfig=explode("*",$config->value);
                if($img->width()> $img->height()){
                    $img->widen( $imgconfig[0], function($constraint){       // 阻止可能的尺寸变化(保持图像大小)
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }else if($img->width() < $img->height()){

                    $img->heighten( $imgconfig[1], function($constraint){       // 阻止可能的尺寸变化(保持图像大小)
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });


                }else{
                    $img->resize($imgconfig[0],$imgconfig[1]);
                }

                $img->save("uploads/".$file_path."/".$filename);

                $imgurl="/uploads/".$file_path."/".$filename;

                Member::where("id",$UserId)->update(["picImg"=>$imgurl]);

                return ["status"=>0 ,"msg"=>"上传成功","src"=>$imgurl];

            }

        }

    }


}


?>
