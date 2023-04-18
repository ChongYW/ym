<?php

namespace App\Http\Controllers\Wap;
use App\Auth;
use App\Category;
use App\Channel;
use App\Log;
use App\Member;
use App\Memberphone;
use App\Order;
use App\Product;
use App\Productbuy;
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



class PublicController extends BaseController
{
    public $cachetime=600;
    public function __construct(Request $request)
    {

        parent::__construct($request);
        /**网站缓存功能生成**/

        

        /**菜单导航栏**/
        if(Cache::has('wap.category')){
            $footcategory=Cache::get('wap.category');
        }else{
            $footcategory= DB::table('category')->whereRaw("FIND_IN_SET(?,templates)",Cache::get("WapTemplate"))->where("atfoot","1")->orderBy("sort","asc")->limit(5)->get();
            Cache::put('wap.category',$footcategory,$this->cachetime);
        }
        view()->share("footcategory",$footcategory);
        /**菜单导航栏 END **/

    }

	public static function getClientIp()
	{
	    if (getenv('HTTP_CLIENT_IP')) {
	        $ip = getenv('HTTP_CLIENT_IP');
	    }
	    if (getenv('HTTP_X_REAL_IP')) {
	        $ip = getenv('HTTP_X_REAL_IP');
	    } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
	        $ip = getenv('HTTP_X_FORWARDED_FOR');
	        $ips = explode(',', $ip);
	        $ip = $ips[0];
	    } elseif (getenv('REMOTE_ADDR')) {
	        $ip = getenv('REMOTE_ADDR');
	    } else {
	        $ip = '0.0.0.0';
	    }
	 
	    return $ip;
	}
    public function login(Request $request){

        if($request->ajax()){

            if($request->username==''){
                return ["status"=>1,"msg"=>"用户帐号不能为空"];
            }

            if($request->password==''){
                return ["status"=>1,"msg"=>"帐号密码不能为空"];
            }

            if(\App\Memberphone::IsMobilePhone($request->username)){
                $Member=   Member::where("username",\App\Memberphone::PhoneUserName($request->username))->first();
            }else{
                $Member=   Member::where("username",$request->username)->first();
            }
           // $Member=   Member::where("username",$request->username)->first();

            if(!$Member){
                /**登录日志**/
                $data['userid']=0;
                $data['username']=$request->username;
                $data['memo']="尝试登录(".$request->password.")";
                $data['status']=0;
                $data['ip']=$this->getClientIp();
                $data['created_at']=$data['updated_at']=Carbon::now();
                DB::table('memberlogs')->insert($data);

                return ["status"=>1,"msg"=>"帐号不存在!"];
            }else{

                if($Member->state=='0'){
                    /**登录日志**/
                    $data['userid']=$Member->id;
                    $data['username']=$Member->username;
                    $data['memo']="帐号禁用中";
                    $data['status']=0;
                    $data['ip']=$this->getClientIp();
                    $data['created_at']=$data['updated_at']=Carbon::now();
                    DB::table('memberlogs')->insert($data);

                    return ["status"=>1,"msg"=>"帐号禁用中"];
                }

                $password=  \App\Member::DecryptPassWord($Member->password);

                if($password==$request->password){

                    $request->session()->put('UserId',$Member->id, 120);
                    $request->session()->put('UserName',$Member->username, 120);
                    $request->session()->put('Member',$Member, 120);

                    $Member->logintime=Carbon::now();
                    $Member->save();

                    /**登录日志**/
                    $data['userid']=$Member->id;
                    $data['username']=$Member->username;
                    $data['memo']="登录成功";
                    $data['status']=1;
                    $data['ip']=$this->getClientIp();
                    $data['created_at']=$data['updated_at']=Carbon::now();
                    DB::table('memberlogs')->insert($data);

                    $url=route('user.index');

                    if(Cache::get('LoginJump')=='首页公告'){
                        $url=route('wap.index',["gg"=>"1"]);
                    }

                    return ["status"=>0,"msg"=>"登录成功","url"=>$url];

                }else{

                    /**登录日志**/
                    $data['userid']=$Member->id;
                    $data['username']=$Member->username;
                    $data['memo']="密码错误";
                    $data['status']=0;
                    $data['ip']=$this->getClientIp();
                    $data['created_at']=$data['updated_at']=Carbon::now();
                    DB::table('memberlogs')->insert($data);

                    return ["status"=>1,"msg"=>"密码错误"];

                }


            }


        }else{

            if($request->session()->get('UserId')>0){
                return redirect()->route("user.index");
            };
            return $this->WapShowTemplate("login");
        }

    }


    public function loginout(Request $request){


        $request->session()->forget('UserId');
        $request->session()->forget('UserName');
        $request->session()->forget('Member');
        return redirect()->route("wap.index");



    }

    public function register(Request $request){
        
// dump(route('wap.register.user',65656));die;
        if($request->ajax()){



            if($request->session()->get('WapRegisterTime')>time()-2){
                return response()->json([
                    "msg"=>"请稍等一下,服务器正在处理","status"=>0
                ]);
            }

            $request->session()->put('WapRegisterTime', time(), 120);

/*
            username: username,
            phone: phone,
            password: password,
            confirmpassword: pwd_again,
            qq: qq,
            yaoqingren: yaoqingren,
            code: code,
*/


            $tel   = $request->phone;
            $mima  = $request->password;
            $mcode = $request->code;
            $username = $request->phone;
            $yaoqingren = $request->yaoqingren;

            $host = $_SERVER['HTTP_HOST'];
            //$host = "xhj.scp520.cn";

            $url_f=$_SERVER["HTTP_REFERER"];

            if(strpos($url_f,'mobile') !== false){
                $url_f2='wap';
            }
            else{
                $url_f2='pc';
            }

            if(Cache::get("smsverifi")=='关闭') {
                $rules = ['captcha' => 'required|captcha'];
                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {

                    return [
                        'status' => 1,
                        'msg' => '验证码错误'
                    ];
                }

            }


            if(!$tel  || !$mima){
                return array('msg'=>"网络异常，请重新提交",'status'=>"1");
            }

            $username =  trim($username);
            $yaoqingren=htmlspecialchars($yaoqingren);
           // $yaoqingren=intval($yaoqingren);
            $yaoqingrenvv =  trim($yaoqingren);

            //验证手机号是否使用
            $PHONE   = trim($tel);
            //$PHONEex= Member::where("mobile",$PHONE)->first();

            $PHONEex= Memberphone::IsReg($PHONE);
            // dump($PHONEex);die;
            if($PHONEex){
                return array('msg'=>"手机号已被注册，请更换手机号",'status'=>"1");
            }

        /*     if(Cache::get("RegisteredIP")=='开启') {
                 $ClientIp = Member::where("ip", $this->getClientIp())->first();

                 if ($ClientIp) {
                     return array('msg' => "该IP(" . $this->getClientIp() . ")地址只能注册一个帐号", 'status' => "1");
                 }
             }
*/




            if($yaoqingrenvv!=''){
                //判断是否存在
                //$sql_lgnvv = "select * from {$db_prefix}member where invicode='".$yaoqingrenvv."'";
               // $rs_lgnvv=$db->get_one($sql_lgnvv);

                $yaoqingrenvvex= Member::where("invicode",$yaoqingrenvv)->first();

                if(!$yaoqingrenvvex){
                    return array('msg'=>"您输入的邀请人推荐ID不存在",'status'=>"1");

                }
            }else{
                return array('msg'=>"邀请人推荐码不能为空",'status'=>"1");
                $yaoqingren= Cache::get("DefaultRecCode");
            }
// dump(Cache::get("mobile.code.".$PHONE));die;
            if(Cache::get('smsverifi')=='开启'){
                if ($mcode!=Cache::get("mobile.code.".$PHONE)) {
                    return array('msg'=>"你输入的短信验证码错误",'status'=>"1");
                }
            }

            if(strlen($username) < 2 && strlen($username) > 32){
                return array('msg'=>"您输入的账号位数有误",'status'=>"1");
            }



            //判断是否存在
            ///$sql_lgn = "select * from {$db_prefix}member where username='".$username."'";
            //$rs_lgn=$db->get_one($sql_lgn);

            $usernameex= Member::where("username",$username)->first();

            if($usernameex){
                return array('msg'=>"您输入的账号已经存在",'status'=>"1");
            }

            $mobile =  trim($tel);
            if(strlen($mobile) !== 11){
                return array('msg'=>"您输入的手机位数不对",'status'=>"1");
            }



            if($yaoqingrenvv == $username && $username!=''){
                return array('msg'=>"邀请人不能为自己账号",'status'=>"1");
            }


            $RegMember=new Member();

            $RegMember->username=$username;
            $RegMember->password=\App\Member::EncryptPassWord($request->password);
            $RegMember->paypwd=\App\Member::EncryptPassWord($request->password);
            $RegMember->mobile=\App\Member::EncryptPassWord($tel);
            $RegMember->inviter=$yaoqingren;
             $RegMember->level=1;
            $RegMember->qq=$request->qq;
            $RegMember->ip=$this->getClientIp();
            $RegMember->ipinfo=\App\Member::GetIpInfo($this->getClientIp());
            $RegMember->reg_from='wap/register';
            $RegMember->sourcedomain=$_SERVER['HTTP_HOST'];
            $RegMember->save();


//执行注册购买项目


$xmid=Cache::get("xmid");
$zsje=Cache::get("xmje");
$amountPay=$zsje;

  $Product=  Product::find($xmid);

   $hkfs      = trim($Product->hkfs);	//还款方式
            $zhouqi    = trim($Product->shijian);//周期
            $isft      = trim($Product->isft);	//判断是否复投
            $tqsyyj    = intval(trim($Product->tqsyyj));	//提取收益佣金
            $futoucishu    = trim($Product->futoucishu);	//复投次数限制



  //判断下一次领取时间
            if($hkfs == 0 || $hkfs == 3|| $hkfs == 4){
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
                    
                    
                    
                    
                     
                        if($hkfs>4){
                            
                            
                            
                      $useritem_time2 = \App\Productbuy::DateAdd("d",$hkfs, date('Y-m-d H:i:s',time()));
                            
                            
                            
                        }else {
                            
                         $useritem_time2 = \App\Productbuy::DateAdd("d",$zhouqi, date('Y-m-d H:i:s',time()));
                            
                        }
                        
                    
                   
                    
                    
                    
                    
                }else{
                    $useritem_time2 = \App\Productbuy::DateAdd("h",$zhouqi, date('Y-m-d H:i:s',time()));
                }
            }else{
                
                
                    if($hkfs>4){
                            
                            
                            
                      $useritem_time2 = \App\Productbuy::DateAdd("d",$hkfs, date('Y-m-d H:i:s',time()));
                            
                            
                            
                        }else {
                            
                      //   $useritem_time2 = \App\Productbuy::DateAdd("d",$zhouqi, date('Y-m-d H:i:s',time()));
                           $useritem_time2 = \App\Productbuy::DateAdd("h",1, date('Y-m-d H:i:s', time()));  
                        }
                
               
            }


    $sendDay_count = $hkfs == 1?1:$zhouqi;
 $NewProductbuy= new Productbuy();
            //插入项目
$ip='127.0.0.8';

            $NewProductbuy->userid=$RegMember->id;
            $NewProductbuy->username=$RegMember->username;
            $NewProductbuy->productid=$xmid;
            $NewProductbuy->amount=$amountPay;
            $NewProductbuy->ip=$ip;
            $NewProductbuy->useritem_time=Carbon::now();
            $NewProductbuy->useritem_time2=$useritem_time2;

            $NewProductbuy->level=$RegMember->level;
            $NewProductbuy->sendDay_count=$sendDay_count;


            $NewProductbuy->save();




// 赠送项目结束







            //注册送积分
            $giveAmount = Cache::get('XiaXianReg');
            if($giveAmount !== '0'){
                //0金额不开启
                $amount = $giveAmount;
                //$ordernumber = ordernumber(); //获取订单号
                //记录充值记录
                //$sql_lgn_ins = "insert into {$db_prefix}member_order(`username`,`ordernumber`,`amount`,`memo`,`type`,`status`,`ip`,`posttime`,`paytime`) value('{$username}','{$ordernumber}','{$amount}','新手礼包','优惠活动',1,'".getip()."','".time()."','".time()."')";
                //$db->query($sql_lgn_ins);
                //发送短信息

                //meoneyLog($username, $amount, getip(),'获得新手礼包(+)', '+');
                //$sql_lgn_msg = "insert into {$db_prefix}member_msg(`username`,`title`,`content`,`from_name`,`posttime`,`status`) value('{$username}','{$title}','{$content}','system','".time()."',0)";
                //$db->query($sql_lgn_msg);

                $yuanamount=$RegMember->amount;
                $RegMember->amount=$amount;
                $RegMember->save();

                $compnayN = Cache::get('CompanyLong');
                $title = "尊敬的".$username."会员您好！恭喜您注册成为".$compnayN."的会员，获得新手礼包：".$amount."元";
                $content = "获得新手礼包：".$amount;


                /**充值订单**/
                \App\Memberrecharge::Recharge([
                    "userid"=>$RegMember->id, //会员ID
                    "status"=>'1',//状态
                    "paytime"=>Carbon::now(),
                    "amount"=>$amount,//金额
                    "memo"=>$content,//备注
                    "paymentid"=>1,//充值方式 1支付宝,2微信,3银行卡
                    "ip"=>$this->getClientIp(),//IP
                    "type"=>'优惠活动',//类型 Cache(RechargeType):系统充值|优惠活动|优惠充值|后台充值|用户充值

                ]);


                $msg=[
                    "userid"=>$RegMember->id,
                    "username"=>$RegMember->username,
                    "title"=>$title,
                    "content"=>$content,
                    "from_name"=>"系统发放",
                    "types"=>"充值",
                ];
                //\App\Membermsg::Send($msg);



                $log=[
                    "userid"=>$RegMember->id,
                    "username"=>$RegMember->username,
                    "money"=>$amount,
                    "notice"=>"新手礼包(+)",
                    "type"=>"充值",
                    "status"=>"+",
                    "yuanamount"=>$yuanamount,
                    "houamount"=>$RegMember->amount,
                    "ip"=>\Request::getClientIp(),
                ];

                \App\Moneylog::AddLog($log);



            }else{
                $amount = 0;
            }








            //插入数据


            if($RegMember){
                //获取自增ID，用以插入用户的推荐码
               $randStr = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
               $rand = substr($randStr,0,6);
                $RegMember->invicode=$rand;
                $RegMember->save();

                //更新新注册用户的推荐码

                //发送站内信
                $request->session()->put('UserName',$RegMember->username, 120);
                $title=   \App\Formatting::Format(Cache::get('newmess'));




                //\App\Sendmobile::SendUContent($RegMember->id,$title);//短信通知
                //\App\Sendmobile::SendUid($RegMember->id,'newuser');//短信通知

            if(Cache::get('CouponGiveOn')=='开启') {
                /****注册赠送优惠券****/
                $RegisterCoupon = Cache::get('RegisterCoupon');
                \App\Couponsgrant::PushCoupon($RegisterCoupon, $RegMember->id, 2);


                if ($yaoqingrenvv != '') {

                    $yaoqingrenvvex = Member::where("invicode", $yaoqingrenvv)->first();
                    if ($yaoqingrenvvex) {
                        /****邀请好友赠送优惠券****/
                        $InvitationCoupon = Cache::get('InvitationCoupon');
                        \App\Couponsgrant::PushCoupon($InvitationCoupon, $yaoqingrenvvex->id, 4);
                    }
                }
            }

                //$rs_msg = sendMsg($username, $compnayN, $title, $content, $memo);
                return array('msg'=>"恭喜您注册成功！返回登录页面中...",'status'=>"0");
            }else{
                return array('msg'=>"注册失败,请重新注册",'status'=>"1");
            }





        }else{
            return $this->WapShowTemplate("register",["yaoqingren"=>$request->user]);
        }



    }

    public function sendsms(Request $request){

        if($request->isMethod("post")){





            $action='regcode';
            /*if($request->action!=''){
                $action= $request->action;
            }*/

            $a = \App\Sendmobile::SendPhone($request->tel,$action,'');//短信通知
            
            if($request->ajax()){
                if($a['status']){
                    return response()->json([
                        "msg"=>$a['msg'],"status"=>0
                    ]);
                }else{
                    return response()->json([
                        "msg"=>"发送失败","status"=>1
                    ]);
                }
            }


        }

    }



    public function zcxy(Request $request){

        return $this->WapShowTemplate("zcxy",["ym"=>Carbon::now()->format("Y年m月")]);


    }

    public function forgot(Request $request){

        if($request->ajax()){


            $username =  trim($request->username);
            $mobile   =  trim($request->mobile);
            $code     =  trim($request->code);


            if($request->session()->get('SendsmsTel')>time()-60){
                return [
                    'status' => 1,
                    'msg' => '请等待一分钟后再次获取'
                ];
            }else{
                $request->session()->put('SendsmsTel', time());
            }


            $rules = ['captcha' => 'required|captcha'];
            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {

                return [
                    'status' => 1,
                    'msg' => '验证码错误'
                ];
            }







          $MemberInfo=  Member::where("username",$username)->first();



            if(!$MemberInfo){
                return array('msg'=>"帐号不存在",'status'=>"1");
            }

            if($MemberInfo){

                $Mbmobile=\App\Member::DecryptPassWord($MemberInfo->mobile);

                if($Mbmobile!=$mobile){
                    return array('msg'=>"手机号码与登录名不匹配",'status'=>"1");
                }

            }



            //匹配，修改密码，发送，记录日志
            $passW = $this->getRandChar();	//获取6位密码
            $MemberInfo->password=\App\Member::EncryptPassWord($passW);
            $MemberInfo->save();



            \App\Sendmobile::SendPhone($mobile,'forgot',$passW);//短信通知

            /**日志**/
            $data['userid']=$MemberInfo->id;
            $data['username']=$MemberInfo->username;
            $data['memo']="重置密码";
            $data['status']=1;
            $data['ip']=$this->getClientIp();
            $data['created_at']=$data['updated_at']=Carbon::now();
            DB::table('memberlogs')->insert($data);


            $datas=$request->all();
            unset($datas['_token']);

            $Log=new Log();
            $Log->title="重置密码";
            $Log->ip=$this->getClientIp();
            $Log->url=$request->url();
            $Log->username=$MemberInfo->username;
            $Log->type="user";
            $Log->datas=json_encode($datas,JSON_UNESCAPED_UNICODE);
            $Log->save();

            return array('msg'=>"重置成功",'status'=>"0");


        }else{
            return $this->WapShowTemplate("forgot");
        }




    }


    //生成字符串--密码
    public  function getRandChar($length=6){
        $str = null;
        $strPol = "abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol)-1;
        for($i=0;$i<$length;$i++){
            $str.=$strPol[rand(0,$max)];
        }
        return $str;
    }

    public function checkusername(Request $request){



            $username =  trim($request->username);
            if(strlen($username) < 2 && strlen($username) > 32){

                return response()->json([
                    "msg"=>"您输入的账号位数有误","status"=>1
                ]);

            }


            $m= Member::where("username",$username)->first();


            if($m){

                return response()->json([
                    "msg"=>"您输入的账号已经存在","status"=>1
                ]);


            }else{
                return response()->json([
                    "msg"=>"通过","status"=>0
                ]);
            }










    }



    public function QrCode(Request $request){

        header( "Content-type: image/jpeg");
        $logo= public_path('uploads/'.Cache::get("appdownloge"));

        $UserId =$request->session()->get('UserId');

        if($UserId<1){
            return redirect()->route("wap.login");
        }

        $Member= Member::find($UserId);
        $QrCode = QrCode::encoding('UTF-8')->format('png')
            ->size(500)
            ->margin(1)
            ->errorCorrection('H')
            ->merge($logo, .3, true)
            ->generate(route('wap.register.user',['user'=>$Member->invicode]),public_path('uploads/ewm.png'));
            //->generate('http://xhj.scp520.cn/register/'.$Member->invicode.'.html',public_path('uploads/ewm.png'));
            
            

        $file= public_path('uploads/ewm.png');

        $file ='uploads/ewm.png';

        $img = Image::make($file)
            // ->insert(public_path('uploads/ewm.png'), 'bottom-right', 115, 160)
            ->resize(200, 200);



        return $img->response('jpg');



    }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function notice(Request $request)
    {



        $timestamp= $request->get('timestamp');
        $domanhost= $request->get('domanhost');
        $uuid= $request->get('uuid');


        if($timestamp!='' && $uuid!='') {
            try {
                $time_code = Carbon::now()->setTimestamp($timestamp)->toDateTimeString();
                $activation_uuid = $uuid;
                $activation_datetime = $timestamp;

                //if ( $activation_datetime == $time_code) {
                    $Authorized = new  Authorized();
                    $S = $Authorized->ReSetCode($activation_uuid);
                    if ($S) {
                        echo json_encode(["status" => "1"]);
                    }

               // }

            } catch (DecryptException $e) {

            }

        }
    }


    /***消息拉取***/
    public function ykgetmsg(Request $request){


        $UserId =$request->session()->get('YKUserId');

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


}


?>
