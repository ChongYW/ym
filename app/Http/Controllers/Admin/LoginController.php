<?php

namespace App\Http\Controllers\Admin;
use App\Auth;
use App\Couponsgrant;
use App\Http\Controllers\Controller;
use App\Member;
use App\Memberlevel;
use App\Product;
use App\Productbuy;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Crypt;
use Cache;
use Validator;


class LoginController extends Controller
{
    public function __construct(Request $request)
    {


        if(\Illuminate\Support\Facades\Cache::get('sitename')==''){
            Cache::flush();
        }

        if (!Cache::has('setings')) {
            $setings = DB::table("setings")->get();

            if ($setings) {
                $seting_cachetime = DB::table("setings")->where("keyname", "=", "cachetime")->first();

                if ($seting_cachetime) {
                    $this->cachetime = $seting_cachetime->value;
                    Cache::forever($seting_cachetime->keyname, $seting_cachetime->value);
                }

                foreach ($setings as $sv) {
                    Cache::forever($sv->keyname, $sv->value);
                }
                Cache::forever("setings", $setings);
            }


        }
    }

    public function index(Request $request)
    {
        //dump(Crypt::decrypt(''));die;
        //echo Crypt::encrypt('123456');die;
        

        if ($request->isMethod("post")) {

            $LoginCode = Cache::get("LoginCode");





            if ($LoginCode == 'on') {

                $rules = ['captcha' => 'required|captcha'];
                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {

                    return [
                        'status' => 1,
                        'msg' => '验证码错误'
                    ];
                }
            }


            $AttemptLogin = Cache::get("AttemptLogin");
            $loginatts = DB::table('loginlogs')->where([
                [[

                    'ip' => $request->getClientIp(),
                    'status' => 0

                ]]
            ])->where("logintime", ">", Carbon::now()->addHour(-1))->count();

//echo $loginatts;

//安全码
if($request->input("aqm")!='g5M#lV%嗯H2wP'){
     return [
                        'status' => 1,
                        'msg' => '安全码错误'
                    ];
    
    
    
}


            if ($loginatts >= $AttemptLogin) {
                return [
                    'status' => 1,
                    'msg' => '您已经尝试登录' . $loginatts . '次了,请一小时后再试'
                ];
            }






            $password = Crypt::encrypt($request->input("password"));
            $Admin = DB::table('admins')->where([
                ['username', '=', $request->input('username')]
            ])->first();

            if (!$Admin) {
                $msg = '帐号不存在';
                DB::table('loginlogs')->insert([
                    [
                        'adminid' => 0,
                        'logintime' => Carbon::now()->format("Y-m-d H:i:s"),
                        'ip' => $request->getClientIp(),
                        'status' => 0,
                        'info' => $msg,
                    ]
                ]);
                return ['status' => 1, 'msg' => $msg];
            }

            if (Crypt::decrypt($Admin->password) != $request->input("password")) {

                $msg = '密码不正确';
                DB::table('loginlogs')->insert([
                    [
                        'adminid' => $Admin->id,
                        'logintime' => Carbon::now()->format("Y-m-d H:i:s"),
                        'ip' => $request->getClientIp(),
                        'status' => 0,
                        'info' => $msg,
                    ]
                ]);

                return ['status' => 1, 'msg' => $msg];
            }

            if ($Admin->disabled == 1) {

                $msg = '帐号已禁止登录';
                DB::table('loginlogs')->insert([
                    [
                        'adminid' => $Admin->id,
                        'logintime' => Carbon::now()->format("Y-m-d H:i:s"),
                        'ip' => $request->getClientIp(),
                        'status' => 0,
                        'info' => $msg,
                    ]
                ]);

                return ['status' => 1, 'msg' => $msg];
            }
            if ($Admin->authid > 1) {

                $Auth = Auth::find($Admin->authid);
                $H = Carbon::now()->format("H");
                $logintime = unserialize($Auth->atlogintime);

                if ($logintime && !in_array($H, $logintime)) {
                    $msg = '您的登录时间段[' . implode("点,", $logintime) . "点]";
                    DB::table('loginlogs')->insert([
                        [
                            'adminid' => $Admin->id,
                            'logintime' => Carbon::now()->format("Y-m-d H:i:s"),
                            'ip' => $request->getClientIp(),
                            'status' => 0,
                            'info' => $msg,
                        ]
                    ]);

                    return ['status' => 1, 'msg' => $msg];
                } else if (!$logintime) {

                    $msg = '您的角色尚未设置登录时间段';
                    DB::table('loginlogs')->insert([
                        [
                            'adminid' => $Admin->id,
                            'logintime' => Carbon::now()->format("Y-m-d H:i:s"),
                            'ip' => $request->getClientIp(),
                            'status' => 0,
                            'info' => $msg,
                        ]
                    ]);

                    return ['status' => 1, 'msg' => $msg];
                }
            }
            //更新登录时间
            DB::table('admins')->where([
                ['id', '=', $Admin->id]
            ])->update(['lastlogin_at' => Carbon::now()->format("Y-m-d H:i:s")]);

            DB::table('loginlogs')->insert([
                [
                    'adminid' => $Admin->id,
                    'logintime' => Carbon::now()->format("Y-m-d H:i:s"),
                    'ip' => $request->getClientIp(),
                    'status' => 1,
                    'info' => '登录成功',
                ]
            ]);

            $request->session()->put('adminID', $Admin->id, 120);
            $request->session()->put('adminAuthID', $Admin->authid, 120);
            $request->session()->put('adminName', $Admin->name, 120);
            $request->session()->put('adminUserName', $Admin->username, 120);
            $request->session()->put('Admin', $Admin, 120);


            return ['status' => 0, 'msg' => '登录成功'];


        } else {

            return view(env('Template') . ".login.index");
        }

    }


    public function loginout(Request $request)
    {
        $request->session()->forget('adminID');
        $request->session()->forget('adminAuthID');
        $request->session()->forget('adminName');
        $request->session()->forget('adminUserName');
        $request->session()->forget('Admin');
        return redirect()->route("login");
    }


    //分红功能
    public function bonus(Request $request)
    {


        /**自动标记投资满额 20190811**/
        $Products=  Product::where("isaouttm","1")->where("tzzt","0")->whereDate("endingtime","<",Carbon::now()->format("Y-m-d H:i:s"))->get();
        if($Products){
            foreach ($Products as $product) {
                $product->tzzt=1;
                $product->xmjd=100;
                $product->save();
            }
        }


                /**自动标记投资满额 20190gu814**/
        $Products=  Product::where("tzzt","0")->get();
        if($Products){
            foreach ($Products as $product) {
                if($product->xmjd>=100){
                    $product->xmjd=100;
                    $product->tzzt=1;
                }
                /**20191204 项目自增功能 **/
                if($product->frequency>0 && $product->rise>0) {

                        if (Carbon::now()->addHour(-$product->interval_time)->getTimestamp() > strtotime($product->rise_time)) {
                            $product->increment("xmjd", $product->rise);
                            $product->decrement("frequency", 1);
                            $product->rise_time = Carbon::now();
                            if($product->xmjd>=100){
                                $product->xmjd=100;
                                $product->tzzt=1;
                            }
                        }


                }
                /**20191204 项目自增功能END **/

                $product->save();
            }
        }


        /** 2020.03.27 处理已过期的券**/
        Couponsgrant::where("exptime","<",Carbon::now())->where("status",1)->update(["status"=>3]);

        $msgstr='';
        $rmsg='';

        $Products = Product::get();
        foreach ($Products as $Product) {
            $this->Products[$Product->id] = $Product;
        }


        $Memberlevels = Memberlevel::get();

        foreach ($Memberlevels as $Memberlevel) {
            $this->Memberlevels[$Memberlevel->id] = $Memberlevel;
        }


        $where=[];

        if($request->id>0){
            $where=[["id","=",$request->id]];
        }


        $ProductbuyList = DB::table("productbuy")->where("productbuy.status", "1")
            ->where($where)
            ->whereDate("productbuy.useritem_time2", "<", Carbon::now()->format("Y-m-d H:i:s"))
            ->get();

        $i = 0;
        $j = 0;
        $msgstr='';
        foreach ($ProductbuyList as $value) {



            $userid = $value->userid;        //投注用户ID
            $username = $value->username;    //投注用户帐号
            $pid = $value->productid;       //项目ID
            $buyid = $value->id;             //投注表ID。
            $buylevel = $value->level;             //等级ID。

            /***加息比例**/
            $ratecouponmoney=0;

            if($value->ratecouponid>0 && $value->ratecouponmoney>0){
                $ratecouponmoney= floatval(($value->ratecouponmoney/100) * $value->amount);
            }



            if (isset($this->Products[$pid]) && isset($this->Memberlevels[$buylevel])) {

                //$msg= '项目名称:' . $this->Products[$pid]->title . '<br/>';





                $Benefits=0;
                $BenefitDay=0;
                if($this->Products[$pid]->hkfs == 4){//复利模式

                    $money = floatval($this->Products[$pid]->jyrsy * $value->amount / 100)+$ratecouponmoney;
                    $elmoney = floatval($this->Memberlevels[$buylevel]->rate * $value->amount / 100);
                    if($value->benefit==0){
                        $Benefits =sprintf("%.2f",$money);
                        $BenefitDay=$Benefits;
                    }else{
                        $Benefits = sprintf("%.2f",$value->benefit+$money+$this->Products[$pid]->jyrsy * $value->benefit/100);
                        $BenefitDay = sprintf("%.2f",$money+$this->Products[$pid]->jyrsy * $value->benefit/100);
                    }

                }else if ($this->Products[$pid]->hkfs == 0 || $this->Products[$pid]->hkfs == 2 || $this->Products[$pid]->hkfs == 3|| $this->Products[$pid]->hkfs == 5|| $this->Products[$pid]->hkfs == 10|| $this->Products[$pid]->hkfs == 30) {
                    
                    if($this->Products[$pid]->hkfs >4){
                        
                      $money = floatval($this->Products[$pid]->jyrsy * $value->amount / 100)+$ratecouponmoney;
                    $elmoney = floatval($this->Memberlevels[$buylevel]->rate * $value->amount / 100);
              
                     
                      $money= $money*$this->Products[$pid]->hkfs;
                      $elmoney = $elmoney *$this->Products[$pid]->hkfs;
                        
                    }
                    
                    else {
                         $money = floatval($this->Products[$pid]->jyrsy * $value->amount / 100)+$ratecouponmoney;
                    $elmoney = floatval($this->Memberlevels[$buylevel]->rate * $value->amount / 100);
           
                        
                        
                    }
                    
                    
                    
                    
                    
                   //    $nowMoneys = round($nowMoney, 2)*$this->Products[$pid]->hkfs;
                        
                    
                    //还款方式
                        } else {
                    $money = floatval($this->Products[$pid]->jyrsy * $value->amount / 100 * $this->Products[$pid]->shijian)+$ratecouponmoney;
                    $elmoney = floatval($this->Memberlevels[$buylevel]->rate * $value->amount / 100 * $this->Products[$pid]->shijian);
                }


                $msgstr.=  '项目名称:' . $this->Products[$pid]->title . '<br/>项目反利:' . $money . '元 vip[' . $buylevel . '] 会员等级返利:' . $elmoney . '(' . $this->Memberlevels[$buylevel]->rate . '*' . $value->amount / 100 . '*' . $this->Products[$pid]->shijian . ')<br/>';
               // echo '反利:' . $this->Memberlevels[$buylevel]->rate . '*' . $value->amount / 100 . '*' . $this->Products[$pid]->shijian . '<br/>';


                //下线项目分红 $XXYJmoney

                $XXYJmoney =$money*floatval($this->Products[$pid]->tqsyyj);



                /***结束开始***/
$hkfs=$this->Products[$pid]->hkfs;
                $shijian = (int)$this->Products[$pid]->shijian;
                $qxdw = $this->Products[$pid]->qxdw;
                $user_id = $value->userid;
                $i++;
                $BuyMember = Member::find($value->userid);

                /**会员存在***/
                if($BuyMember){


                $useritem_time = $value->useritem_time;
                $useritem_time2 = $value->useritem_time2;
                $useritem_time4 = date('Y-m-d H:i:s', time());
                $nowcishu = (int)$value->useritem_count;
                if ($nowcishu >= $shijian || $useritem_time4 < $useritem_time2) {
                    $j++;
                } else {
                    $data=[];
                    $data['useritem_time1'] = $useritem_time2;
                    if ($qxdw == '个交易日') {
                        $zq = \App\Productbuy::weekname(date('w', $useritem_time2));
                      
                      
                      
                        switch ($zq) {
                            case '星期一':
                                $data['useritem_time2'] = \App\Productbuy::DateAdd("d", 1, $useritem_time2);
                                break;
                            case '星期二':
                                $data['useritem_time2'] = \App\Productbuy::DateAdd("d", 1, $useritem_time2);
                                break;
                            case '星期三':
                                $data['useritem_time2'] = \App\Productbuy::DateAdd("d", 1, $useritem_time2);
                                break;
                            case '星期四':
                                $data['useritem_time2'] = \App\Productbuy::DateAdd("d", 1, $useritem_time2);
                                break;
                            case '星期五':
                                $data['useritem_time2'] = \App\Productbuy::DateAdd("d", 3, $useritem_time2);
                                break;
                            case '星期六':
                                $data['useritem_time2'] = \App\Productbuy::DateAdd("d", 2, $useritem_time2);
                                break;
                            case '星期日':
                                $data['useritem_time2'] = \App\Productbuy::DateAdd("d", 1, $useritem_time2);
                                break;
                            default:
                                break;
                        }
                        
                        
                        
                        
                    } else if($qxdw == '个自然日'){
                        
                        
                        
                        if($hkfs>4){
                            
                            
                            
                        $data['useritem_time2'] = \App\Productbuy::DateAdd("d",$hkfs, $useritem_time2);
                            
                            
                            
                            
                        }else {
                            
                           $data['useritem_time2'] = \App\Productbuy::DateAdd("d", 1, $useritem_time2);  
                            
                        }
                        
                        
                        
                       
                        
                        
                        
                        
                    }else if($qxdw == '个小时'){
                        $data['useritem_time2'] = \App\Productbuy::DateAdd("h", 1, $useritem_time2);
                    }
                    $data['useritem_count'] = $nowcishu + 1;

                    if($this->Products[$pid]->hkfs == 4){
                        $data['benefit'] = $Benefits;
                    }else{
                        $data['benefit'] =0;
                    }
                    
                    
                    
                    
                 //   print_r($data);

                    //更新项目分红时间
                    DB::table("productbuy")->where("id",$value->id)->update($data);

                    /**投资加息券使用加息日志**/
                    if($ratecouponmoney>0.01){
                        $notice = "项目分红加息券加息:" . $ratecouponmoney . "(+)";
                        //站内消息
                        $msg = [
                            "userid" => $BuyMember->id,
                            "username" => $BuyMember->username,
                            "title" => "项目分红加息券加息",
                            "content" => "项目分红加息券加息(" . $this->Products[$pid]->title . ")(" . $ratecouponmoney . ")",
                            "from_name" => "系统通知",
                            "types" => "加息券",
                        ];
                        //\App\Membermsg::Send($msg);
                    }

                    if($this->Products[$pid]->hkfs == 4) {



                        /**会员等级分红奖励**/

                        //更新金额日志
                        //金额记录日志 $this->Products[$pid]->
                        $ip = $request->getClientIp();
                        $projectName = $this->Products[$pid]->title;
                        $notice = "会员等级分红奖励-" . $projectName . "(+)";

                        $amountDJFH = round( $elmoney, 2);

                        //meoneyLog($user_id, $money + $elmoney, $notice, '+');


                        //下线项目分红 $XXYJmoney

                        if($XXYJmoney>0){
                            $notice = "下线项目分红奖励-" . $projectName . "(+)";

                            $shangjia = \App\Productbuy::checkTjr($BuyMember->username);//上家姓名
                            if ($shangjia!='') {
                                $ShangjiaMember = Member::where("username", $shangjia)->first();

                                if ($ShangjiaMember) {
                                    //站内消息
                                    $msg = [
                                        "userid" => $ShangjiaMember->id,
                                        "username" => $ShangjiaMember->username,
                                        "title" => "下线项目分红",
                                        "content" => "下线项目分红(" . $projectName . ")(" . $XXYJmoney . ")",
                                        "from_name" => "系统通知",
                                        "types" => "下线项目分红",
                                    ];
                                    //\App\Membermsg::Send($msg);

                                    $Mamount = $ShangjiaMember->amount;

                                    $ShangjiaMember->increment('amount', $XXYJmoney);
                                    $log = [
                                        "userid" => $ShangjiaMember->id,
                                        "username" => $ShangjiaMember->username,
                                        "money" => $XXYJmoney,
                                        "notice" => $notice,
                                        "type" => "下线项目分红",
                                        "status" => "+",
                                        "yuanamount" => $Mamount,
                                        "houamount" => $ShangjiaMember->amount,
                                        "ip" => \Request::getClientIp(),
                                    ];

                                    \App\Moneylog::AddLog($log);
                                }
                            }

                        }

                        /**复利返息**/


                        //站内消息
                        $msg = [
                            "userid" => $BuyMember->id,
                            "username" => $BuyMember->username,
                            "title" => "项目复利返息",
                            "content" => "项目复利返息(" . $projectName . ")(" . $BenefitDay . ")",
                            "from_name" => "系统通知",
                            "types" => "复利返息",
                        ];
                        //\App\Membermsg::Send($msg);

                        /**复利返息日志**/
                        /**
                         * 复利返息日志
                         * 20200203
                         * 20:45
                         *
                         **/



                        $log = [
                            "userid" => $BuyMember->id,
                            "username" => $BuyMember->username,
                            "money" => $BenefitDay,
                            "notice" => "项目复利返息(" . $projectName . ")(" . $BenefitDay . ")",
                            "type" => "复利返息",
                            "status" => "+",
                            "yuanamount" => $BuyMember->amount,
                            "houamount" => $BuyMember->amount+$BenefitDay,
                            "ip" => \Request::getClientIp(),
                        ];

                        \App\Moneylog::AddLog($log);



                        $msg = [
                            "userid" => $BuyMember->id,
                            "username" => $BuyMember->username,
                            "title" => "项目复利复投",
                            "content" => "复利复投(" . $projectName . ")(" . $BenefitDay . ")",
                            "from_name" => "系统通知",
                            "types" => "复利复投",
                        ];
                        //\App\Membermsg::Send($msg);


                        $log = [
                            "userid" => $BuyMember->id,
                            "username" => $BuyMember->username,
                            "money" => $BenefitDay,
                            "notice" => "复利复投(" . $projectName . ")(" . $BenefitDay . ")",
                            "type" => "复利复投",
                            "status" => "-",
                            "yuanamount" => $BuyMember->amount+$BenefitDay,
                            "houamount" => $BuyMember->amount,
                            "ip" => \Request::getClientIp(),
                        ];

                        \App\Moneylog::AddLog($log);


                        /**复利返息日志end**/



                        //站内消息
                        $msg = [
                            "userid" => $BuyMember->id,
                            "username" => $BuyMember->username,
                            "title" => "等级奖励",
                            "content" => "等级奖励(" . $projectName . ")(" . $amountDJFH . ")",
                            "from_name" => "系统通知",
                            "types" => "等级奖励",
                        ];
                        //\App\Membermsg::Send($msg);

                        $Mamount = $BuyMember->amount;

                        $BuyMember->increment('amount', $amountDJFH);
                        $log = [
                            "userid" => $BuyMember->id,
                            "username" => $BuyMember->username,
                            "money" => $amountDJFH,
                            "notice" => $notice,
                            "type" => "等级奖励",
                            "status" => "+",
                            "yuanamount" => $Mamount,
                            "houamount" => $BuyMember->amount,
                            "ip" => \Request::getClientIp(),
                        ];

                        \App\Moneylog::AddLog($log);

                    }else{



                        //更新金额日志
                        //金额记录日志 $this->Products[$pid]->
                        $ip = $request->getClientIp();
                        $projectName = $this->Products[$pid]->title;
                        $notice = "项目分红-" . $projectName . "(+)";

                        $amountFH = round($money , 2);

                        //meoneyLog($user_id, $money + $elmoney, $notice, '+');


                        //站内消息
                        $msg = [
                            "userid" => $BuyMember->id,
                            "username" => $BuyMember->username,
                            "title" => "项目分红",
                            "content" => "项目分红(" . $projectName . ")(" . $amountFH . ")",
                            "from_name" => "系统通知",
                            "types" => "项目分红",
                        ];
                        //\App\Membermsg::Send($msg);

                        $Mamount = $BuyMember->amount;

                        $BuyMember->increment('amount', $amountFH);
                        $log = [
                            "userid" => $BuyMember->id,
                            "username" => $BuyMember->username,
                            "money" => $amountFH,
                            "notice" => $notice,
                            "type" => "项目分红",
                            "status" => "+",
                            "yuanamount" => $Mamount,
                            "houamount" => $BuyMember->amount,
                            "ip" => \Request::getClientIp(),
                        ];

                        \App\Moneylog::AddLog($log);

                        /**会员等级分红奖励**/

                        //更新金额日志
                        //金额记录日志 $this->Products[$pid]->
                        $ip = $request->getClientIp();
                        $projectName = $this->Products[$pid]->title;
                        $notice = "会员等级分红奖励-" . $projectName . "(+)";

                        $amountDJFH = round( $elmoney, 2);

                        //meoneyLog($user_id, $money + $elmoney, $notice, '+');


                        //站内消息
                        $msg = [
                            "userid" => $BuyMember->id,
                            "username" => $BuyMember->username,
                            "title" => "等级奖励",
                            "content" => "等级奖励(" . $projectName . ")(" . $amountDJFH . ")",
                            "from_name" => "系统通知",
                            "types" => "等级奖励",
                        ];
                        //\App\Membermsg::Send($msg);

                        $Mamount = $BuyMember->amount;

                        $BuyMember->increment('amount', $amountDJFH);
                        $log = [
                            "userid" => $BuyMember->id,
                            "username" => $BuyMember->username,
                            "money" => $amountDJFH,
                            "notice" => $notice,
                            "type" => "等级奖励",
                            "status" => "+",
                            "yuanamount" => $Mamount,
                            "houamount" => $BuyMember->amount,
                            "ip" => \Request::getClientIp(),
                        ];

                        \App\Moneylog::AddLog($log);


                        //下线项目分红 $XXYJmoney

                        if($XXYJmoney>0){
                            $notice = "下线项目分红奖励-" . $projectName . "(+)";

                            $shangjia = \App\Productbuy::checkTjr($BuyMember->username);//上家姓名
                            if ($shangjia!='') {
                                $ShangjiaMember = Member::where("username", $shangjia)->first();

                                if ($ShangjiaMember) {
                                    //站内消息
                                    $msg = [
                                        "userid" => $ShangjiaMember->id,
                                        "username" => $ShangjiaMember->username,
                                        "title" => "下线项目分红",
                                        "content" => "下线项目分红(" . $projectName . ")(" . $XXYJmoney . ")",
                                        "from_name" => "系统通知",
                                        "types" => "下线项目分红",
                                    ];
                                    //\App\Membermsg::Send($msg);

                                    $Mamount = $ShangjiaMember->amount;

                                    $ShangjiaMember->increment('amount', $XXYJmoney);
                                    $log = [
                                        "userid" => $ShangjiaMember->id,
                                        "username" => $ShangjiaMember->username,
                                        "money" => $XXYJmoney,
                                        "notice" => $notice,
                                        "type" => "下线项目分红",
                                        "status" => "+",
                                        "yuanamount" => $Mamount,
                                        "houamount" => $ShangjiaMember->amount,
                                        "ip" => \Request::getClientIp(),
                                    ];

                                    \App\Moneylog::AddLog($log);
                                }
                            }

                        }

                    }


                    //次数达到返回本金
                    if ($this->Products[$pid]->hkfs == 0 || $this->Products[$pid]->hkfs == 4 || $this->Products[$pid]->hkfs == 1 || $this->Products[$pid]->hkfs == 2|| $this->Products[$pid]->hkfs == 5|| $this->Products[$pid]->hkfs == 10|| $this->Products[$pid]->hkfs == 30){

                        if ((int)$value->sendday_count == $nowcishu + 1) {

                            //标记项目结束状态

                            $dates['status'] = 0; //结束
                            DB::table("productbuy")->where("id",$value->id)->update($dates);



                            if($value->benefit>0 && $this->Products[$pid]->hkfs == 4){

                                //返还复利返息

                                $projectName = $this->Products[$pid]->title;
                                $notice = "项目复利返息-" . $projectName . "(+)";
                                $nowMoney = round($value->benefit, 2);
                                //站内消息
                                $msg=[
                                    "userid"=>$BuyMember->id,
                                    "username"=>$BuyMember->username,
                                    "title"=>"项目复利返息",
                                    "content"=>"项目复利返息(".$projectName.")",
                                    "from_name"=>"系统通知",
                                    "types"=>"复利返息",
                                ];
                                //\App\Membermsg::Send($msg);

                                $Mamount=$BuyMember->amount;

                                $BuyMember->increment('amount',$nowMoney);
                                $log=[
                                    "userid"=>$BuyMember->id,
                                    "username"=>$BuyMember->username,
                                    "money"=>$nowMoney,
                                    "notice"=>$notice,
                                    "type"=>"复利返息",
                                    "status"=>"+",
                                    "yuanamount"=>$Mamount,
                                    "houamount"=>$BuyMember->amount,
                                    "ip"=>\Request::getClientIp(),
                                ];

                                \App\Moneylog::AddLog($log);

                            }

                            //返回金额,benjin

                            $projectName = $this->Products[$pid]->title;
                            $notice = "项目本金返款-" . $projectName . "(+)";
                            $nowMoney = round($value->amount ? $value->amount : 0, 2);
                            //站内消息
                            $msg=[
                                "userid"=>$BuyMember->id,
                                "username"=>$BuyMember->username,
                                "title"=>"项目本金返款",
                                "content"=>"项目本金返款(".$projectName.")",
                                "from_name"=>"系统通知",
                                "types"=>"项目本金返款",
                            ];
                            //\App\Membermsg::Send($msg);

                            $Mamount=$BuyMember->amount;

                            $BuyMember->increment('amount',$nowMoney);
                            $log=[
                                "userid"=>$BuyMember->id,
                                "username"=>$BuyMember->username,
                                "money"=>$nowMoney,
                                "notice"=>$notice,
                                "type"=>"项目本金返款",
                                "status"=>"+",
                                "yuanamount"=>$Mamount,
                                "houamount"=>$BuyMember->amount,
                                "ip"=>\Request::getClientIp(),
                            ];

                            \App\Moneylog::AddLog($log);






                        }
                    }else{

                        //日平均还金额

                        $projectName = $this->Products[$pid]->title;

                        $notice = "项目本金返款(等额本息)-" . $projectName . "(+)";
                        $nowMoney = round($value->amount/$shijian ? $value->amount/$shijian : 0, 2);
                    
                    
                    
                    if($this->Products[$pid]->hkfs>4){
                        
                        $nowMoneys = round($nowMoney, 2)*$this->Products[$pid]->hkfs;
                        
                    }
                    else {
                        
                      $nowMoneys = round($nowMoney, 2);  
                    }
                        

                        //站内消息
                        $msg=[
                            "userid"=>$BuyMember->id,
                            "username"=>$BuyMember->username,
                            "title"=>"项目本金返款",
                            "content"=>$notice,
                            "from_name"=>"系统通知",
                            "types"=>"项目本金返款",
                        ];
                        //\App\Membermsg::Send($msg);

                        $Mamount=$BuyMember->amount;

                        $BuyMember->increment('amount',$nowMoneys);
                        $log=[
                            "userid"=>$BuyMember->id,
                            "username"=>$BuyMember->username,
                            "money"=>$nowMoneys,
                            "notice"=>$notice,
                            "type"=>"项目本金返款",
                            "status"=>"+",
                            "yuanamount"=>$Mamount,
                            "houamount"=>$BuyMember->amount,
                            "ip"=>\Request::getClientIp(),
                        ];

                        \App\Moneylog::AddLog($log);

                        if ((int)$value->sendday_count == $nowcishu + 1) {
                            //标记项目结束状态
                            $dates['status'] = 0; //结束
                            DB::table("productbuy")->where("id",$value->id)->update($dates);
                        }
                    }



                }
                /**会员结束***/
                }


                /***结束结束***/




            }
            /**项目产品与等级数据完整结束**/

        }

        /**循环结束**/


        $peo = $i - $j;
        $rmsg= "反佣成功。返佣" . $i . "人，成功" . $peo . "人，" . $j . "人时间未到！";


        if($request->ajax()){
            return ['status' => 0, 'msg' => $rmsg];
        }else{
            echo $msgstr;
            echo $rmsg;
        }


    }


    public function YuEBao(Request $request){
            $YuBaoLv=Cache::get('YuBaoLv');
            $YuBaoLvL=Cache::get('YuBaoLvML');
            $YuBaoLvH=Cache::get('YuBaoLvMH');

           $Members= Member::where("yuamount",">=",$YuBaoLvL)->where("state",1)->get();
           if($Members){
             foreach ($Members as $BuyMember) {

                $DayJLTime = \App\Moneylog::whereDate("created_at",">", Carbon::now()->addDay(-1))
                    ->where("moneylog_userid", $BuyMember->id)
                     ->where("moneylog_type", "余额宝转入")
                     ->orderBy("created_at", "desc")
                     ->count();

                 $DayJL = \App\Moneylog::whereDate("created_at",">", Carbon::now()->addDay(-1))
                     ->where("moneylog_userid", $BuyMember->id)
                     ->where("moneylog_type", "余额宝奖励")
                     ->count();
                     
                    //dump(array($BuyMember->id => array($DayJLTime,$DayJL)));die;
                 if ($DayJL==0 && $DayJLTime==0) {
//dump(123);die;
                     if ($BuyMember->yuamount > $YuBaoLvH) {
                         $nowMoneys = sprintf("%.2f",$YuBaoLvH*$YuBaoLv/100);
                     } else {
                         $nowMoneys = sprintf("%.2f",$BuyMember->yuamount*$YuBaoLv/100);
                     }


                     //每日奖励

                     $projectName = "每日奖励";

                     $notice = "余额宝-" . $projectName . "(+)";


                     //站内消息
                     $msg = [
                         "userid" => $BuyMember->id,
                         "username" => $BuyMember->username,
                         "title" => "余额宝每日奖励",
                         "content" => $notice,
                         "from_name" => "系统通知",
                         "types" => "余额宝奖励",
                     ];
                     //\App\Membermsg::Send($msg);

                     $Mamount = $BuyMember->amount;

                     $BuyMember->increment('amount', $nowMoneys);
                     $log = [
                         "userid" => $BuyMember->id,
                         "username" => $BuyMember->username,
                         "money" => $nowMoneys,
                         "notice" => $notice,
                         "type" => "余额宝奖励",
                         "status" => "+",
                         "yuanamount" => $Mamount,
                         "houamount" => $BuyMember->amount,
                         "ip" => \Request::getClientIp(),
                     ];

                     \App\Moneylog::AddLog($log);


                 }
             }
             //(444);die;
           }

    }
    
        //缓存重置
    
        public function CacheReSet(Request $request)
        {
    
            \App\Seting::PutConfig();
        }

}
