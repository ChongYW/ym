<?php

namespace App\Http\Controllers\Pc;
use App\Auth;
use App\Channel;
use App\Log;
use App\Member;
use App\Memberphone;
use App\Order;
use Carbon\Carbon;
use DB;
use App\Admin;
use App\Club;
use App\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;
use Session;
use App\Ad;
use Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PublicController extends BaseController
{

    public $cachetime=60;
    public function __construct(Request $request)
    {

        parent::__construct($request);
        /**网站缓存功能生成**/

       


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
                        $url=route('pc.index',["gg"=>"1"]);
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
            return $this->PcShowTemplate("login");
        }

    }


    public function loginout(Request $request){


        $request->session()->forget('UserId');
        $request->session()->forget('UserName');
        $request->session()->forget('Member');
        return redirect()->route("pc.index");



    }

    public function register(Request $request){


        if($request->ajax()){



            if($request->session()->get('PcRegisterTime')>time()-2){
                return response()->json([
                    "msg"=>"请稍等一下,服务器正在处理","status"=>0
                ]);
            }

            $request->session()->put('PcRegisterTime', time(), 120);
            /**验证图形验证码**/
            
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
            $username = $request->username;
            $yaoqingren = $request->yaoqingren;

            $host = $_SERVER['HTTP_HOST'];

            $url_f=$_SERVER["HTTP_REFERER"];

            if(strpos($url_f,'mobile') !== false){
                $url_f2='wap';
            }
            else{
                $url_f2='pc';
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

            if($PHONEex){
                return array('msg'=>"手机号已被注册，请更换手机号",'status'=>"1");
            }

            if(Cache::get("RegisteredIP")=='开启') {

                $ClientIp = Member::where("ip", $this->getClientIp())->first();

                if ($ClientIp) {
                    return array('msg' => "该IP(" . $this->getClientIp() . ")地址只能注册一个帐号", 'status' => "1");
                }
            }

            if($yaoqingrenvv!=''){
                //判断是否存在
                //$sql_lgnvv = "select * from {$db_prefix}member where invicode='".$yaoqingrenvv."'";
                // $rs_lgnvv=$db->get_one($sql_lgnvv);

                $yaoqingrenvvex= Member::where("invicode",$yaoqingrenvv)->first();

                if(!$yaoqingrenvvex){
                    return array('msg'=>"您输入的邀请人推荐ID不存在",'status'=>"1");

                }
            }else{
                $yaoqingren= Cache::get("DefaultRecCode");
            }

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



            if($yaoqingrenvv == $username){
                return array('msg'=>"邀请人不能为自己账号",'status'=>"1");
            }


            $RegMember=new Member();

            $RegMember->username=$username;
            $RegMember->password=\App\Member::EncryptPassWord($request->password);
            $RegMember->paypwd=\App\Member::EncryptPassWord($request->password);
            $RegMember->mobile=\App\Member::EncryptPassWord($tel);
            $RegMember->inviter=$yaoqingren;
            $RegMember->qq=$request->qq;
            $RegMember->ip=$this->getClientIp();
            $RegMember->ipinfo=\App\Member::GetIpInfo($this->getClientIp());
            $RegMember->reg_from='pc/register';
            $RegMember->sourcedomain=$_SERVER['HTTP_HOST'];
            $RegMember->save();



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
                \App\Membermsg::Send($msg);



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
            /*            $pwd = mymd5($mima);
                        $yaoqingren =  trim($yaoqingren);
                        $sql_lgn_ins = "insert into
                    {$db_prefix}member(`username`,`pwd`,`paypwd`,`mobile`,`email`,`inviter`,`ip`,`posttime`,`ismobile`,`level`,`amount`,`qq`,`reg_from`) value('{$username}','{$pwd}','{$pwd}','{$tel}','{$youxiang}','{$yaoqingren}','".getip()."','".time()."',1,1,'{$amount}','{$qq}','{$host}/{$url_f2}')";
                        $result = $db->query($sql_lgn_ins);*/

            if($RegMember){
                //获取自增ID，用以插入用户的推荐码
//            $sql = "select CASE WHEN ISNULL(max(invicode)) THEN '513566' ELSE max(invicode) + 1 END as invicode from dg_member";
                // $sql = "SELECT id,id + 513566 as invicode from {$db_prefix}member where username = '{$username}'";
                //$invicode = $db->get_one($sql);

                $RegMember->invicode=$RegMember->id+5135666;
                $RegMember->save();

                //更新新注册用户的推荐码
                // $sql = "UPDATE {$db_prefix}member SET `invicode` = '{$invicode['invicode']}' WHERE `id` = '{$invicode['id']}'";
                // $db->query($sql);
                //发送站内信
                $request->session()->put('UserName',$RegMember->username, 120);
                $title=   \App\Formatting::Format(Cache::get('newmess'));

                // $title = "尊敬的{$RegMember->username}会员您好！欢迎您注册使用本网站";


                //\App\Sendmobile::SendUContent($RegMember->id,$title);//短信通知

                \App\Sendmobile::SendUid($RegMember->id,'newuser');//短信通知

                //$rs_msg = sendMsg($username, $compnayN, $title, $content, $memo);
                return array('msg'=>"恭喜您注册成功！返回登录页面中...",'status'=>"0");
            }else{
                return array('msg'=>"注册失败,请重新注册",'status'=>"1");
            }





        }else{
            return $this->PcShowTemplate("register",["yaoqingren"=>$request->user]);
        }



    }

    public function sendsms(Request $request){

        if($request->isMethod("post")){

            $rules = ['captcha' => 'required|captcha'];
            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {

                return [
                    'status' => 1,
                    'msg' => '验证码错误'
                ];
            }

            $action='regcode';
            /*if($request->action!=''){
                $action= $request->action;
            }*/

            \App\Sendmobile::SendPhone($request->tel,$action,'');//短信通知

            if($request->ajax()){
                return response()->json([
                    "msg"=>"短信验证码发送成功","status"=>0
                ]);
            }


        }

    }



    public function zcxy(Request $request){

        return $this->PcShowTemplate("zcxy",["ym"=>Carbon::now()->format("Y年m月")]);


    }

    public function forgot(Request $request){

        if($request->ajax()){


            $username =  trim($request->username);
            $mobile   =  trim($request->mobile);
            $code     =  trim($request->code);




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
            $data['ip']=$this->getClientIp();//$request->getClientIp();
            $data['created_at']=$data['updated_at']=Carbon::now();
            DB::table('memberlogs')->insert($data);


            $datas=$request->all();
            unset($datas['_token']);

            $Log=new Log();
            $Log->title="重置密码";
            $Log->ip=$this->getClientIp();//$request->getClientIp();
            $Log->url=$request->url();
            $Log->username=$MemberInfo->username;
            $Log->type="user";
            $Log->datas=json_encode($datas,JSON_UNESCAPED_UNICODE);
            $Log->save();

            return array('msg'=>"重置成功",'status'=>"0","url"=>route('pc.login'));


        }else{
            return $this->PcShowTemplate("forgot");
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

        $file= public_path('uploads/ewm.png');

        $file ='uploads/ewm.png';

        $img = Image::make($file)
           // ->insert(public_path('uploads/ewm.png'), 'bottom-right', 115, 160)
            ->resize(200, 200);



        return $img->response('jpg');



    }

    public function APPQrCode(Request $request){

        header( "Content-type: image/jpeg");
        $logo= public_path('uploads/'.Cache::get("appdownloge"));



        $QrCode = QrCode::encoding('UTF-8')->format('png')
            ->size(500)
            ->margin(1)
            ->errorCorrection('H')
            ->merge($logo, .3, true)
            ->generate(Cache::get('AppDownloadUrl'),public_path('uploads/ewm.png'));

        $file= public_path('uploads/ewm.png');

        $file ='uploads/ewm.png';

        $img = Image::make($file)
           // ->insert(public_path('uploads/ewm.png'), 'bottom-right', 115, 160)
            ->resize(200, 200);



        return $img->response('jpg');



    }


    //ykgetmsg
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
