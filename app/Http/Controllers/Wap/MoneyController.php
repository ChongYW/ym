<?php

namespace App\Http\Controllers\Wap;
use App\Auth;
use App\Category;
use App\Channel;
use App\Couponsgrant;
use App\Http\Controllers\Controller;
use App\Member;
use App\Memberlevel;
use App\Membermsg;
use App\Memberticheng;
use App\Order;
use App\Paycode;
use App\Payment;
use App\Product;
use App\Productbuy;
use Carbon\Carbon;
use DB;
use App\Admin;
use App\Ad;
use App\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Session;

class MoneyController extends BaseController
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
            $footcategory= DB::table('category')->whereRaw("FIND_IN_SET(?,templates)",Cache::get("WapTemplate"))->where("atfoot","1")->orderBy("sort","asc")->limit(5)->get();
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

        $Memberlevels= Memberlevel::get();

        foreach ($Memberlevels as $Memberlevel){
            $this->Memberlevels[$Memberlevel->id]=$Memberlevel;
        }


        if(Cache::has("admin.payment")){
            $this->payment =Cache::get("admin.payment");
        }else {
            $payments = DB::table("payment")->orderBy("id","desc")->get();
            $payment = [];
            foreach ($payments as $pay) {
                $payment[$pay->id] = $pay->pay_name;
            }
            $this->payment =$payment;
            Cache::put("admin.payment",$payment,Cache::get("cachetime"));
        }




    }

    /***会员中心***/
    public function index(Request $request){


        $UserId =$request->session()->get('UserId');

           return $this->WapShowTemplate("user.index");


    }




    /***收益列表 shouyi***/
    public function shouyi(Request $request){
        $UserId =$request->session()->get('UserId');

        $type=[
            "1"=>["项目分红","每日签到","复利返息"],
            "2"=>["加入项目","复利复投"],
            "3"=>["项目本金返款"],
        ];

        $id=1;
        if($request->id>0){
            $id=$request->id;

        }

        $pagesize=6;
        $pagesize=Cache::get("pcpagesize");
        $where=[];

        if($request->id=='all'){
            $list = DB::table("moneylog")
                ->where("moneylog_userid",$UserId)
                //->whereIn("moneylog_type",$type[$id])
                ->orderBy("id","desc")
                ->paginate($pagesize);
        }else if(isset($type[$id])){
            $list = DB::table("moneylog")
                ->where("moneylog_userid",$UserId)
                ->whereIn("moneylog_type",$type[$id])
                ->orderBy("id","desc")
                ->paginate($pagesize);
        }

        foreach ($list as $item){
            $item->date=date("m-d H:i",strtotime($item->created_at));
        }

        if($request->ajax()){


            return ["status"=>0,"list"=>$list,"pagesize"=>$pagesize];
        }else {

            return $this->WapShowTemplate("user.shouyi",["id"=>$request->id,"list"=>$list,"pagesize"=>$pagesize]);
        }

    }


    /***收益列表 tender***/
    public function tender(Request $request){

        $UserId =$request->session()->get('UserId');
        $products=Product::get();
        $productData=[];
        foreach ($products as $product){
            $productData[$product->id]=$product;
        }


        $pagesize=6;
        $pagesize=Cache::get("pcpagesize");
        $where=[];

        $list = DB::table("productbuy")
            ->where("userid",$UserId)
            ->orderBy("id","desc")
            ->paginate($pagesize);
        foreach ($list as $item){
            if(isset($productData[$item->productid])){
                $item->title=$productData[$item->productid]->title;
                $item->jyrsy=$productData[$item->productid]->jyrsy+$item->ratecouponmoney;
                $item->shijian=$productData[$item->productid]->shijian;
                $item->qxdw=$productData[$item->productid]->qxdw;
                //$item->sendday_count=$productData[$item->productid]->sendday_count;
                $item->rate=isset($this->Memberlevels[$item->level])?$this->Memberlevels[$item->level]->rate:0;

                if($productData[$item->productid]->hkfs == 0){
                    $moneyCount = $item->jyrsy *$productData[$item->productid]->shijian* $item->amount/100;
                    $item->moneyCount= round($moneyCount,2);
                }else{
                    $moneyCount = $item->jyrsy * $item->amount/100*$productData[$item->productid]->shijian;
                    $item->moneyCount= round($moneyCount,2);
                }


                if($productData[$item->productid]->hkfs == 0){
                    $elseMoney = $item->rate * $item->amount/100;
                    $item->elseMoney= round($elseMoney,2);
                }else{
                    $elseMoney = $item->rate * $item->amount/100*$productData[$item->productid]->shijian;
                    $item->elseMoney= round($elseMoney,2);
                }

                if($productData[$item->productid]->hkfs == 4){
                    $item->shouyis=round(\App\Product::Benefit($item->productid,$item->amount,$item->ratecouponmoney)+$item->elseMoney,2);
                }else{
                    $item->shouyis=round($item->moneyCount+$item->elseMoney,2);
                }





            }
            $item->date=date("m-d H:i",strtotime($item->created_at));
            $item->url=\route("user.agreement",["sgin"=>$item->id]);
        }

        if($request->ajax()){


            return ["status"=>0,"list"=>$list,"pagesize"=>$pagesize];
        }else {


            return $this->WapShowTemplate("user.tender",["status"=>0,"list"=>$list,"pagesize"=>$pagesize]);
        }

    }




    /***资金统计***/
    public function moneylog(Request $request){

                $UserId =$request->session()->get('UserId');

               return $this->WapShowTemplate("user.moneylog",[]);

    }
    
    /***资金统计1***/
    public function mylonk(Request $request){
        //团队投资总计
        $buytotal= DB::table("moneylog")
            ->whereIn("userid",$datauserids)
            ->where("moneylog_type",'加入项目')->sum('moneylog_money');

       return $buytotal;

    }



    /***充值***/
    public function recharge(Request $request){

                $UserId =$request->session()->get('UserId');

                if($request->ajax()){

                    $amount= intval($request->amount);

                    if($amount<1){
                        return response()->json([
                            "msg"=>"充值金额错误","status"=>1
                        ]);
                    }

                    if(!isset($this->payment[$request->paymentid])){
                        return response()->json([
                            "msg"=>"充值方式错误","status"=>1
                        ]);
                    }


                    $memo= $request->memo!=''?$request->memo:$this->payment[$request->paymentid].'充值'.$request->amount;



                    \App\Memberrecharge::Recharge([
                        "userid"=>$UserId, //会员ID
                        "amount"=>$request->amount,//金额
                        "codename"=>$request->codename,//二维码名称
                        "img"=>$request->img,//备注
                        "memo"=>$memo,//备注
                        "paymentid"=>$request->paymentid,//充值方式 1支付宝,2微信,3银行卡
                        "ip"=>$request->getClientIp(),//IP
                        "type"=>"用户充值",//类型 Cache(RechargeType):系统充值|优惠活动|优惠充值|后台充值|用户充值

                    ]);

                    $msg=[
                        "userid"=>$UserId,
                        "username"=>$this->Member->username,
                        "title"=>"充值订单",
                        "content"=>"您的充值申请提交成功(".$request->amount.")",
                        "from_name"=>"系统通知",
                        "types"=>"充值",
                    ];
                    \App\Membermsg::Send($msg);

                    if($request->ajax()){
                        return response()->json([
                            "msg"=>"充值成功","status"=>0
                        ]);
                    }


                }else{

                    $Payments=  Payment::where("enabled","1")->orderBy("id","desc")->get();
                    $Paycodes= Paycode::get();

                    return $this->WapShowTemplate("user.recharge",["Payments"=>$Payments,"Paycodes"=>$Paycodes]);
                }



    }

    /***提现***/
    public function withdraw(Request $request){

                $UserId =$request->session()->get('UserId');

                if($request->ajax()){


                    if($this->Member->locking==1){
                        return response()->json([
                            "msg"=>Cache::get("MemberLockingMsg"),"status"=>1
                        ]);
                    }

                    $amount= intval($request->amount);

                    if($amount<Cache::get("withdrawalmin")){
                        return response()->json([
                            "msg"=>"最低提款金额为".Cache::get("withdrawalmin"),"status"=>1
                        ]);
                    }

//

                  if($this->Member->isbank==0 || $this->Member->bankcode==''){
                      return response()->json([
                          "msg"=>"您还未绑定银行账号","status"=>1,"url"=>\route("user.bank")
                      ]);
                  }

                  if(\App\Member::DecryptPassWord($this->Member->paypwd)!=$request->paypwd){
                      return response()->json([
                          "msg"=>"交易密码错误","status"=>1
                      ]);
                  }


                    if(Cache::get('TouziTikuai')=='收益') {


                        $yanzheng = \App\Memberwithdrawal::WithdrawalAmount($UserId, $amount);

                        if (isset($yanzheng)) {

                            if ($yanzheng['status'] == 1) {
                                return response()->json($yanzheng);
                            }

                            $data = \App\Memberwithdrawal::AddWithdrawal($UserId, $amount);


                            if ($request->ajax()) {
                                return response()->json($data);
                            }

                        } else {

                            return response()->json([
                                "msg" => "系统错误", "status" => 1
                            ]);
                        }

                    }else {

                    $data= \App\Memberwithdrawal::AddWithdrawal($UserId,$amount);



                          if($request->ajax()){
                              return response()->json($data);
                           }
                    }


                }else{

                    return $this->WapShowTemplate("user.withdraw",[]);
                }



    }

    /***充值***/
    public function payconfig(Request $request){

                $UserId =$request->session()->get('UserId');

                $Payment=  Payment::find($request->payid);

                if($Payment->pay_pic_auto=='1') {
                    if (Cache::has('PaycodePic_' . $UserId . '_' . $request->payid)) {
                        $Paycodes = Cache::get('PaycodePic_' . $UserId . '_' . $request->payid);
                    } else {

                         $Paycodes = Paycode::where("pay_pid", $request->payid)->where("pay_status", 1)->orderByRaw("RAND()")->get();


                        Cache::put('PaycodePic_' . $UserId . '_' . $request->payid, $Paycodes, 7200);
                    }
                }else if($Payment->pay_pic_auto=='2'){
                    $Paycode= Paycode::where("pay_pid", $request->payid)->where("pay_status", 1)->orderByRaw("RAND()")->first();
                    if($Paycode){
                        $Paycode->decrement("pay_number");
                        if($Paycode->pay_number<=0){
                            $Paycode->pay_status=0;
                            $Paycode->save();
                        }
                    }else{
                        $Payment->enabled=0;
                        $Payment->save();

                    }

                }else{
                    if (Cache::has('PaycodePic_' . $UserId . '_' . $request->payid)) {
                        $Paycodes = Cache::get('PaycodePic_' . $UserId . '_' . $request->payid);
                    } else {
                        $Paycodes = Paycode::where("pay_pid", $request->payid)->where("pay_status", 1)->orderBy("id", "asc")->get();
                        Cache::put('PaycodePic_' . $UserId . '_' . $request->payid, $Paycodes, 7200);
                    }

                }





            if($Payment){
                $html='';
                if($Payment->enabled==0) {
                    $html .= '<script>';
                    $html .= 'alert("请选择其他收款方式");';
                    $html .= 'location.reload(true);';
                    $html .= '</script>';
                }
                if(isset($Paycodes) && $Paycodes){
                    $html.='<script>';
                    $html .= 'picList=new Array();';
                    $html .= 'picNameList=new Array();';


                    if($Payment->pay_pic_auto=='1'){
                        $Pics=count($Paycodes);
                        $order_number = DB::table("memberrecharge")
                            ->where("userid",$UserId)
                            ->where("paymentid",$Payment->id)
                            ->whereDate("created_at",Carbon::now()->format("Y-m-d"))
                            ->count();

                        $pay_order_number =$Payment->pay_order_number>0?$Payment->pay_order_number:1;

                        $IndexNum=intval($order_number/$pay_order_number);

                        if($IndexNum>=$Pics){
                            $IndexNum=$IndexNum%$Pics;
                        }

                        $html .= 'IndexNum='.$IndexNum.';';

                    }

                    foreach ($Paycodes as $paycode) {
                        $html .= 'picList.push("'.$paycode->pay_pic.'");';
                        $html .= 'picNameList.push("'.$paycode->pay_name.'");';
                    }


                    if($Payment->pay_pic_auto=='1') {
                        $html .= 'setImg();';
                    }

                    $html.='</script>';
                }

                  $html.='<table border="0" width="100%" cellspacing="0" cellpadding="0"  class="tb_class4"  height="90" >
                    <tbody>
                    <tr>
                        <td bgcolor="#f5f5f5" height="34"  class="tb_class3"  colspan="2">'.$Payment->pay_name.'</td>
                    </tr>
                    <tr height="40">
                        <td width="197" align="right"  class="tb_class1">会员账号：</td>
                        <td width="528" class="tb_class1" style="border-top:#e6e6e6 solid 1px;">'.$this->Member->username.'</td>
                    </tr>
                    <tr height="40">
                        <td width="197" align="right" class="tb_class1">总资产：</td>
                        <td width="528"  class="tb_class2" >'. $this->Member->amount.'</td>
                    </tr>';

    if($Payment->recipient_bank!=''){
                  $html.=' <tr height="60">
                    <td class="tb_class1" align="right">开户银行：</td>
                    <td class="tb_class1" >'.$Payment->recipient_bank.'</td>
                </tr>';
              }

              if($Payment->recipient_payee!=''){
                  $html.=' <tr height="60">
                    <td class="tb_class1" align="right">收款人：</td>
                    <td class="tb_class1" >'.$Payment->recipient_payee.'
                    <div class="layui-form-item"><a href="javascript:void(0)"  class="layui-btn layui-inline btn" style="width: 100%;margin: 0 auto; " >复制收款人</a></div>
                    <span style="display: none;" id="recipient_payee">'.$Payment->recipient_payee.'</span>
                    </td>
                </tr>';
              }

              if($Payment->recipient_account!=''){
                  $html.=' <tr height="60">
                    <td class="tb_class1" align="right">收款帐号：</td>
                    <td class="tb_class1" >'.$Payment->recipient_account.'
                    <div class="layui-form-item"><a href="javascript:void(0)"  class="layui-btn layui-inline btn2" style="width: 100%;margin: 0 auto; " >复制收款帐</a></div>
                    <span style="display: none;" id="recipient_account">'.$Payment->recipient_account.'</span></td>
                </tr>';
              }

              if($Payment->pay_bank!=''){
                  $html.=' <tr height="60">
                    <td class="tb_class1" align="right">收款信息：</td>
                    <td class="tb_class1" >'.$Payment->pay_bank.'</td>
                </tr>';
              }

              if($Payment->pay_pic!=''){

                  if($Payment->pay_code=='ChinaPay'){
                      $html .= ' <tr height="60">
                    <td class="tb_class1" align="right">银行名称：</td>
                    <td class="tb_class1" style="text-align: center;">
                    <div class="layui-form-item">
                    <img src="' . $Payment->pay_pic . '" class="codepic" />
                    </div>';

                      $html .= ' </td>
                </tr>';
                  }else {
                      $html .= ' <tr height="60">
                    <td class="tb_class1" align="right">扫码支付：</td>
                    <td class="tb_class1" style="text-align: center;">
                    <div class="layui-form-item">';
                    if(isset($Paycode) && $Paycode && $Payment->pay_pic_auto=='2'){
                        $html .='<img src="' . $Paycode->pay_pic . '" class="codepic" />';
                    }else{
                        $html .='<img src="' . $Payment->pay_pic . '" class="codepic" />';
                    }
                      $html .='
                    </div>
                                <div class="layui-form-item">

                <a class="layui-btn layui-inline codepica" style="width: 80%;margin: 0 auto;" href="' . $Payment->pay_pic . '" >存为图片</a>

             </div>';

                      if ($Payment->pay_pic_on == "1") {
                          $html .= '<div class="layui-form-item"><a href="javascript:void(0)"  class="layui-btn layui-inline fnTab" style="width: 80%;margin: 0 auto; color: #ff4b5b;" >更换收款二维码</a></div>';
                      }

                      $html .= ' </td>
                </tr>';
                  }
              }



            //       if($Payment->recipient_bank!=''){
            //           $html.=' <tr height="60">
            //             <td class="tb_class1" align="right">开户银行：</td>
            //             <td class="tb_class1" >'.$Payment->recipient_bank.'</td>
            //         </tr>';
            //       }

            //       if($Payment->recipient_payee!=''){
            //           $html.=' <tr height="60">
            //             <td class="tb_class1" align="right">收款人：</td>
            //             <td class="tb_class1" >'.$Payment->recipient_payee.'
            //             <div class="layui-form-item"><a href="javascript:void(0)"  class="layui-btn layui-inline btn" style="width: 100%;margin: 0 auto; " >复制收款人</a></div>
            //             <span style="display: none;" id="recipient_payee">'.$Payment->recipient_payee.'</span>
            //             </td>
            //         </tr>';
            //       }

            //       if($Payment->recipient_account!=''){
            //           $html.=' <tr height="60">
            //             <td class="tb_class1" align="right">收款帐号：</td>
            //             <td class="tb_class1" >'.$Payment->recipient_account.'
            //             <div class="layui-form-item"><a href="javascript:void(0)"  class="layui-btn layui-inline btn2" style="width: 100%;margin: 0 auto; " >复制收款帐</a></div>
            //             <span style="display: none;" id="recipient_account">'.$Payment->recipient_account.'</span></td>
            //         </tr>';
            //       }

            //       if($Payment->pay_bank!=''){
            //           $html.=' <tr height="60">
            //             <td class="tb_class1" align="right">收款信息：</td>
            //             <td class="tb_class1" >'.$Payment->pay_bank.'</td>
            //         </tr>';
            //       }

            //       if($Payment->pay_pic!=''){

            //           if($Payment->pay_code=='ChinaPay'){
            //               $html .= ' <tr height="60">
            //             <td class="tb_class1" align="right">银行名称：</td>
            //             <td class="tb_class1" style="text-align: center;">
            //             <div class="layui-form-item">
            //             <img src="' . $Payment->pay_pic . '" class="codepic" />
            //             </div>';

            //               $html .= ' </td>
            //         </tr>';
            //           }else {
            //               $html .= ' <tr height="60">
            //             <td class="tb_class1" align="right">扫码支付：</td>
            //             <td class="tb_class1" style="text-align: center;">
            //             <div class="layui-form-item">';
            //             if(isset($Paycode) && $Paycode && $Payment->pay_pic_auto=='2'){
            //                 $html .='<img src="' . $Paycode->pay_pic . '" class="codepic" />';
            //             }else{
            //                 $html .='<img src="' . $Payment->pay_pic . '" class="codepic" />';
            //             }
            //               $html .='
            //             </div>
            //                         <div class="layui-form-item">

            //         <a class="layui-btn layui-inline codepica" style="width: 80%;margin: 0 auto;" href="' . $Payment->pay_pic . '" >存为图片</a>

            // </div>';

            //               if ($Payment->pay_pic_on == "1") {
            //                   $html .= '<div class="layui-form-item"><a href="javascript:void(0)"  class="layui-btn layui-inline fnTab" style="width: 80%;margin: 0 auto; color: #ff4b5b;" >更换收款二维码</a></div>';
            //               }

            //               $html .= ' </td>
            //         </tr>';
            //           }
            //       }

                  if($Payment->pay_desc!='') {
                    $html .= '  <tr height="60">
                        <td class="tb_class1" align="right">温馨提示：</td>
                        <td class="tb_class2" >' . $Payment->pay_desc . '</td>
                    </tr>';
}
                  $html.=' <tr height="60">
                        <td class="tb_class1" align="right">充值金额：</td>
                        <td class="tb_class2" ><input type="text" name="amount" style="width:130px; height:30px; line-height:30px;  border-radius: 15px; border:#CCCCCC solid 1px; padding:0px 8px;"> </td>
                    </tr>
                    <!--<tr height="60">
                        <td class="tb_class1" align="right">汇款说明：</td>
                        <td class="tb_class2" >
                            <input type="text" name="memo" style="width:130px; height:30px; line-height:30px;  border-radius: 15px; border:#CCCCCC solid 1px; padding:0px 8px;">
                        </td>
                    </tr>-->
                    
                    
                      <tr height="60">
                        <td class="tb_class1" align="right">汇款证明：</td>
                        <td class="tb_class2" >
                        
                        <div class="head-pic fl imgshow">
                                    <img src="/pc/finance/css/user/img/touxiang.jpg" alt="" id="thumb_url" width="100">

                                </div>
                        
                            <input type="hidden" name="img" id="img" style="width:130px; height:30px; line-height:30px;  border-radius: 15px; border:#CCCCCC solid 1px; padding:0px 8px;">
                        </td>
                    </tr>
                    
                    <tr height="60">
                        <td class="tb_class1" align="right">汇款说明：</td>
                        <td class="tb_class2" >
                            <input type="text" name="memo" style="width:130px; height:30px; line-height:30px;  border-radius: 15px; border:#CCCCCC solid 1px; padding:0px 8px;">
                        </td>
                    </tr>
                    
                    <tr height="60">
                        <td class="tb_class1" align="right">汇款/转账时间：</td>
                        <td class="tb_class2" ><input type="text" name="date" value="'.Carbon::now()->format("Y-m-d H:i:s").'" style="width:138px; height:30px; line-height:30px; border-radius: 15px; border:#CCCCCC solid 1px; padding:0px 8px;"></td>
                    </tr>
                    <tr height="50">
                        <td class="tb_class1" align="right"></td>
                        <td style="border-right:#e6e6e6 solid 1px;border-bottom:#e6e6e6 solid 1px; color:#ff9600; padding-left:3px;">
                            
                            <input style="background:#3579f7; height:30px; line-height:30px; width:100px; border:0px; color:#FFFFFF; font-size:14px;" type="button" value="确认提交" onclick="SubForm()"> <input type="button" value="&nbsp;&nbsp;取消&nbsp;&nbsp;" class="btncancel" onClick="location.href=location.href;"></td>
                    </tr>
                    </tbody>
                <input type="hidden" name="paymentid" value="' . $Payment->id . '">';
                

                if(isset($Paycode) && $Paycode && $Payment->pay_pic_auto=='2'){
                    $html .='<input type="hidden" name="codename" value="' . $Paycode->pay_name . '" class="codename">';
                }else{
                    $html .='<input type="hidden" name="codename" value="' . $Payment->pay_codename . '" class="codename">';
                }

                $html .='<input type="hidden" name="_token" value="' . csrf_token() . '">
                </table>
                <script type="text/javascript">

    var content = $("#recipient_payee").text();
    var content2 = $("#recipient_account").text();
    var clipboard = new Clipboard(\'.btn\', {
        text: function() {
            return content;
        }
    });
    clipboard.on(\'success\', function(e) {
        layer.msg("收款人复制成功！");
    });

    clipboard.on(\'error\', function(e) {
        console.log(e);
    });
    var clipboard2 = new Clipboard(\'.btn2\', {
    
        text: function() {
            return content2;
        }
    });
    clipboard2.on(\'success\', function(e) {
        layer.msg("收款账号复制成功！");
    });

    clipboard2.on(\'error\', function(e) {
        console.log(e);
    });
</script>



<script>

            layui.use(\'upload\', function(){


                var upload = layui.upload;

                //执行实例
                var uploadInst = upload.render({
                    elem: \'#thumb_url\' //绑定元素
                    ,url: \''.route("uploads.uploadimg").'?_token='. csrf_token() .'\' //上传接口
                    , field:\'thumb\'
                    ,done: function(src){
                        //上传完毕回调

                        console.log(src);
                        if(src.status==0){
                            layer.msg(src.msg,{time:500},function(){

                                $(".imgshow").html(\'<img src="\'+src.src+\'?t=\'+new Date()+\'" width="100" style="float:left;"/>\');

      $("#img").val(src.src);

                            });
                        }

                    }
                    ,error: function(){
                        //请求异常回调
                    }
                });

            });



        </script>

                ';


                  return ["status"=>0,"html"=>$html];
              }

    }













    /***协议***/
    public function agreement(Request $request){

            $UserId =$request->session()->get('UserId');

            $ProBuy=  Productbuy::where("id",$request->sgin)->where("userid",$UserId)->first();



            if($ProBuy){
                $Pro=  Product::where("id",$ProBuy->productid)->first();
                if(!$Pro){
                    return view("hui.error",["icon"=>"layui-icon-404","msg"=>"协议未找到"]);
                }
                $Mb=  Member::where("id",$UserId)->first();

                return $this->WapShowTemplate("user.agreement",["Mb"=>$Mb,"Pro"=>$Pro,"ProBuy"=>$ProBuy]);
            }else{
                return view("hui.error",["icon"=>"layui-icon-404","msg"=>"协议未找到"]);
            }





    }





    /***我的充值记录***/
    public function recharges(Request $request){
        $UserId =$request->session()->get('UserId');

        $pagesize=6;
        $pagesize=Cache::get("pcpagesize");
        $where=[];

        $list = DB::table("memberrecharge")
            ->where("userid",$UserId)
            ->orderBy("id","desc")
            ->paginate($pagesize);
        foreach ($list as $item){
            $item->date=date("m-d H:i",strtotime($item->created_at));
        }

        if($request->ajax()){




            return ["status"=>0,"list"=>$list,"pagesize"=>$pagesize];
        }else {

            /**充值成功**/
           $chenggong= DB::table("memberrecharge")
                ->where("userid",$UserId)
                ->where("status","1")
                ->sum('amount');

            /**充值等待**/
          $dendai=  DB::table("memberrecharge")
                ->where("userid",$UserId)
                ->where("status","0")
                ->sum('amount');

            /**充值失败**/
         $shibai=   DB::table("memberrecharge")
                ->where("userid",$UserId)
                ->where("status","-1")
                ->sum('amount');
            return $this->WapShowTemplate("user.recharges",[
                "chenggong"=>$chenggong,
                "dendai"=>$dendai,
                "shibai"=>$shibai,
                "list"=>$list,"pagesize"=>$pagesize
            ]);
        }


    }

    /***我的提款记录***/
    public function withdraws(Request $request){
        $UserId =$request->session()->get('UserId');

        $pagesize=6;
        $pagesize=Cache::get("pcpagesize");
        $where=[];

        $list = DB::table("memberwithdrawal")
            ->where("userid",$UserId)
            ->orderBy("id","desc")
            ->paginate($pagesize);
        foreach ($list as $item){
            $item->date=date("m-d H:i",strtotime($item->created_at));
        }

        if($request->ajax()){




            return ["status"=>0,"list"=>$list,"pagesize"=>$pagesize];
        }else {

            /**充值成功**/
           $chenggong= DB::table("memberwithdrawal")
                ->where("userid",$UserId)
                ->where("status","1")
                ->sum('amount');

            /**充值等待**/
          $dendai=  DB::table("memberwithdrawal")
                ->where("userid",$UserId)
                ->where("status","0")
                ->sum('amount');

            /**充值失败**/
         $shibai=   DB::table("memberwithdrawal")
                ->where("userid",$UserId)
                ->where("status","-1")
                ->sum('amount');
            return $this->WapShowTemplate("user.withdraws",[
                "chenggong"=>$chenggong,
                "dendai"=>$dendai,
                "shibai"=>$shibai,"list"=>$list,"pagesize"=>$pagesize
            ]);
        }


    }

    /***我的下线记录***/
    public function offline(Request $request){

        $UserId =$request->session()->get('UserId');

        $pagesize=6;
        $pagesize=Cache::get("pcpagesize");
        $where=[];

        $list = DB::table("membercashback")
            ->where("userid",$UserId)
            ->orderBy("id","desc")
            ->paginate($pagesize);
        foreach ($list as $item){
            $item->date=date("m-d H:i",strtotime($item->created_at));
        }

        if($request->ajax()){




            return ["status"=>0,"list"=>$list,"pagesize"=>$pagesize];
        }else {

            /**抽成金额**/
            $chenggong= DB::table("membercashback")
                ->where("userid",$UserId)
                ->where("status","1")
                ->sum('preamount');


            return $this->WapShowTemplate("user.offline",[
"chenggong"=>$chenggong,"list"=>$list,"pagesize"=>$pagesize
            ]);
        }



    }


    /***我的下线收支***/
    public function budget(Request $request){

        $UserId =$request->session()->get('UserId');
        $datauserids=  \App\Member::treeuid($this->Member->invicode);
        $datalvs=  \App\Member::treelv($this->Member->invicode,1);

        $pagesize=6;
        $pagesize=Cache::get("pcpagesize");
        $where=[];

        $list = DB::table("member")
            ->whereIn("id",$datauserids)
            ->orderBy("id","desc")
            ->paginate($pagesize);
        foreach ($list as $item){
            $item->date=date("m-d H:i",strtotime($item->created_at));
            $item->cenji=$datalvs[$item->id];


            $recharges= DB::table("memberrecharge")
                ->where("userid",$item->id)
                ->whereNotIn("type",['优惠活动','优惠充值'])
                ->where("status","1")
                ->sum('amount');

            $withdrawals= DB::table("memberwithdrawal")
                ->where("userid",$item->id)
                ->where("status","1")
                ->sum('amount');
            $item->recharge= sprintf("%.2f",$recharges);
            $item->withdrawal= sprintf("%.2f",$withdrawals);

        }
        if($request->ajax()){




            return ["status"=>0,"list"=>$list,"pagesize"=>$pagesize];
        }else {

            $datauserids=  \App\Member::treeuid($this->Member->invicode);



            $recharge= DB::table("memberrecharge")
                ->whereIn("userid",$datauserids)
                ->where("status","1")
                ->whereNotIn("type",['优惠活动','优惠充值'])
                ->sum('amount');

            $withdrawal= DB::table("memberwithdrawal")
                ->whereIn("userid",$datauserids)
                ->where("status","1")
                ->sum('amount');


            return $this->WapShowTemplate("user.budget",[
                "recharge"=>sprintf("%.2f",$recharge),
                "withdrawal"=>sprintf("%.2f",$withdrawal),
                "list"=>$list,"pagesize"=>$pagesize
            ]);
        }



    }



    /***我的推广记录***/
    public function record(Request $request){

        $UserId =$request->session()->get('UserId');
        $datauserids=  \App\Member::treeuid($this->Member->invicode);
        $datalvs=  \App\Member::treelv($this->Member->invicode,1);

        $pagesize=6;
        $pagesize=Cache::get("pcpagesize");
        $where=[];

        $list = DB::table("member")
            ->whereIn("id",$datauserids)
            ->orderBy("id","desc")
            ->paginate($pagesize);
        foreach ($list as $item){
            $item->date=date("m-d H:i",strtotime($item->created_at));
            $item->cenji=$datalvs[$item->id];
        }
        if($request->ajax()){




            return ["status"=>0,"list"=>$list,"pagesize"=>$pagesize];
        }else {




            return $this->WapShowTemplate("user.record",["list"=>$list,"pagesize"=>$pagesize

            ]);
        }



    }


    /***我的推广链接 ***/
    public function mylink(Request $request){

        $UserId =$request->session()->get('UserId');


        $datauserids=  \App\Member::treeuid($this->Member->invicode);
        $datalvs=  \App\Member::treelv($this->Member->invicode,1);

        $pagesize=6;
        $pagesize=Cache::get("pcpagesize");
        $where=[];

        $list = DB::table("member")
            ->whereIn("id",$datauserids)
            ->orderBy("id","desc")
            ->paginate($pagesize);
        foreach ($list as $item){
            $item->date=date("m-d H:i",strtotime($item->created_at));
            $item->cenji=$datalvs[$item->id];
        }

            return $this->WapShowTemplate("user.mylink",[
                "list"=>$list,"pagesize"=>$pagesize
            ]);




    }

    /***我的余额宝 ***/
    public function yuamount(Request $request){

            $UserId =$request->session()->get('UserId');
        $type=[
            "余额宝奖励",
            "余额宝转入",
            "余额宝转出"
        ];



        $pagesize=6;
        $pagesize=Cache::get("pcpagesize");
        $where=[];

        $list = DB::table("moneylog")
            ->where("moneylog_userid",$UserId)
            ->whereIn("moneylog_type",$type)
            ->orderBy("id","desc")
            ->paginate($pagesize);
        foreach ($list as $item){
            $item->date=date("m-d H:i",strtotime($item->created_at));
        }
     if($request->ajax()){




          return ["status"=>0,"list"=>$list,"pagesize"=>$pagesize];
        }else {

      return $this->WapShowTemplate("user.yuamount", [
          "list"=>$list,"pagesize"=>$pagesize
      ]);
         }




    }


    /***我的余额宝操作 ***/
    public function yuamountAct(Request $request){

            $UserId =$request->session()->get('UserId');

            if($request->ajax()){

                if($request->session()->get('yuamountActUTime')>time()-10){
                    return [
                        "msg"=>"请稍等一下,服务器正在处理","status"=>0
                    ];
                }

                $request->session()->put('yuamountActUTime', time(), 120);


                $Moneylogs= \App\Moneylog::where("moneylog_userid" , $UserId)
                    ->where("created_at",">",Carbon::now()->addSecond(-10)->format("Y-m-d H:i:s"))
                    ->count();

                if($Moneylogs>0){
                    return [
                        "msg"=>"您的操作频繁,请稍后再试","status"=>0
                    ];
                }

                $Mem=  Member::where("id",$UserId)->first();

                if($request->act=='+'){
                    if($request->amount<1){
                        return ["status"=>1,"msg"=>"余额宝金额错误"];
                    }
                  if($Mem->amount<$request->amount){
                      return ["status"=>1,"msg"=>"帐户余额不足"];
                  }else{


                      $nowMoneys=$request->amount;

                      //余额宝转出

                      $projectName = "余额宝转入";

                      $notice = "余额宝-" . $projectName . "(-)";


                      //站内消息
                      $msg = [
                          "userid" => $Mem->id,
                          "username" => $Mem->username,
                          "title" => "余额宝转入",
                          "content" => $notice,
                          "from_name" => "系统通知",
                          "types" => "余额宝转入",
                      ];
                      \App\Membermsg::Send($msg);

                      $Mamount = $Mem->amount;

                      $Mem->decrement('amount', $nowMoneys);
                      $Mem->increment('yuamount', $nowMoneys);
                      $log = [
                          "userid" => $Mem->id,
                          "username" => $Mem->username,
                          "money" => $nowMoneys,
                          "notice" => $notice,
                          "type" => "余额宝转入",
                          "status" => "-",
                          "yuanamount" => $Mamount,
                          "houamount" => $Mem->amount,
                          "ip" => \Request::getClientIp(),
                      ];

                      \App\Moneylog::AddLog($log);
                      return ["status"=>0,"msg"=>"余额宝转入成功"];

                  }

                }else if($request->act=='-'){
                    if($request->amount<1){
                        return ["status"=>1,"msg"=>"余额宝金额错误"];
                    }
                    if($Mem->yuamount<$request->amount){
                        return ["status"=>1,"msg"=>"余额宝金额不足"];
                    }else{
                        $nowMoneys=$request->amount;

                        //余额宝转出

                        $projectName = "余额宝转出";

                        $notice = "余额宝-" . $projectName . "(+)";


                        //站内消息
                        $msg = [
                            "userid" => $Mem->id,
                            "username" => $Mem->username,
                            "title" => "余额宝转出",
                            "content" => $notice,
                            "from_name" => "系统通知",
                            "types" => "余额宝转出",
                        ];
                        \App\Membermsg::Send($msg);

                        $Mamount = $Mem->amount;

                        $Mem->increment('amount', $nowMoneys);
                        $Mem->decrement('yuamount', $nowMoneys);

                        $log = [
                            "userid" => $Mem->id,
                            "username" => $Mem->username,
                            "money" => $nowMoneys,
                            "notice" => $notice,
                            "type" => "余额宝转出",
                            "status" => "+",
                            "yuanamount" => $Mamount,
                            "houamount" => $Mem->amount,
                            "ip" => \Request::getClientIp(),
                        ];

                        \App\Moneylog::AddLog($log);

                        return ["status"=>0,"msg"=>"余额宝转出成功"];
                    }

                }

            }
        }

    /***我的优惠券 ***/
    public function Coupon(Request $request){
        $UserId =$request->session()->get('UserId');

        $list[1]= Couponsgrant::where("uid",$UserId)->where("status",1)->get();
        $list[2]= Couponsgrant::where("uid",$UserId)->where("status",2)->get();
        $list[3]= Couponsgrant::where("uid",$UserId)->where("status",3)->get();
        return $this->WapShowTemplate("user.coupon", [
            "list"=>$list
        ]);
    }

}


?>
