<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Crypt;
use DB;

class Memberrecharge extends Model
{
    protected $table="memberrecharge";
    protected $primaryKey="id";
    public $timestamps=true;
    protected $guarded=[];
    protected $fillable = [
        'ordernumber',
        'userid',
        'username',
        'amount',
        'memo',
        'paymentid',
        'status',
        'paytime',
        'ip',
        'bank','img',
        'accNo',
        'sendsms',
        'type'
        ];
    protected $dates = ['created_at', 'updated_at'];


    protected function Recharge($Data){


if(!isset($Data['img'])){
    
    $Data['img']='';
}



      $Rec=  new Memberrecharge();
      $Rec->ordernumber=Carbon::now()->format("YmdHis").rand(10000000,99999999);
      $Rec->userid=$Data['userid'];
      $Rec->username=isset($Data['username'])?$Data['username']:DB::table("member")->where("id",$Data['userid'])->value("username");
      $Rec->sendsms=isset($Data['sendsms'])?$Data['sendsms']:0;
      $Rec->amount=$Data['amount'];
        $Rec->img=$Data['img'];
      $Rec->ip=$Data['ip'];
      $Rec->type=$Data['type'];
      $Rec->paymentid=$Data['paymentid'];
      $Rec->memo=$Data['memo'];
      $Rec->pay_codename=isset($Data['codename'])?$Data['codename']:DB::table("payment")->where("id",$Data['paymentid'])->value("pay_codename");
      $Rec->status=isset($Data['status'])?$Data['status']:0;
      if(isset($Data['paytime'])){
          $Rec->paytime=$Data['paytime'];
      }
      //$Rec->sendsms=0;
      $Rec->save();
      
      if(isset($Data['status']) && $Data['status']==1) {
          /**积分奖励**/
          $Member = Member::find($Data['userid']);
          $integral = floor($Data['amount'] / intval(Cache::get("integralratio")));

          if ($integral >= 1) {

              $yuanintegral = $Member->integral;
              $Member->increment('integral', $integral);
              $Member->activation=1;//激活帐号
              $Member->save();
              $msg = [
                  "userid" => $Data['userid'],
                  "username" => $Data['amount'],
                  "title" => "积分奖励",
                  "content" => "积分奖励(" . $integral . ")",
                  "from_name" => "系统审核",
                  "types" => "积分奖励",
              ];
              \App\Membermsg::Send($msg);


              $log = [
                  "userid" => $Member->id,
                  "username" => $Member->username,
                  "money" => $integral,
                  "notice" => "积分奖励(+)",
                  "type" => "积分奖励",
                  "status" => "+",
                  "yuanamount" => $yuanintegral,
                  "houamount" => $Member->integral,
                  "ip" => \Request::getClientIp(),
              ];

              \App\Moneylog::AddLog($log);


          }
      }
      return ["status"=>0,"data"=>$Rec];

    }
    
    

    protected function ConfirmRecharge($id,$status){


        $Model = Memberrecharge::find($id);

        if($Model->status==0){
            $Model->status=$status;
            $Model->paytime=Carbon::now();
            $Model->save();
            if($status==1){
               $Member= Member::find($Model->userid);
               $amount=  $Member->amount;
               $Member->increment('amount',$Model->amount);

                $msg=[
                    "userid"=>$Model->userid,
                    "username"=>$Model->username,
                    "title"=>"充值成功",
                    "content"=>"您的充值成功(".$Model->amount.")",
                    "from_name"=>"系统审核",
                    "types"=>"充值",
                ];
                \App\Membermsg::Send($msg);



                 $log=[
                            "userid"=>$Model->userid,
                            "username"=>$Model->username,
                            "money"=>$Model->amount,
                            "notice"=>"充值成功(+)",
                            "type"=>"充值",
                            "status"=>"+",
                            "yuanamount"=>$amount,
                            "houamount"=>$Member->amount,
                            "ip"=>\Request::getClientIp(),
                 ];

                \App\Moneylog::AddLog($log);
                
                
                /**积分奖励**/

               $integral= floor($Model->amount/intval(Cache::get("integralratio")));

               if($integral>=1) {

                   $yuanintegral = $Member->integral;
                   $Member->increment('integral', $integral);

                   $msg = [
                       "userid" => $Model->userid,
                       "username" => $Model->username,
                       "title" => "积分奖励",
                       "content" => "积分奖励(" . $integral . ")",
                       "from_name" => "系统审核",
                       "types" => "积分奖励",
                   ];
                   \App\Membermsg::Send($msg);


                   $log = [
                       "userid" => $Model->userid,
                       "username" => $Model->username,
                       "money" => $integral,
                       "notice" => "积分奖励(+)",
                       "type" => "积分奖励",
                       "status" => "+",
                       "yuanamount" => $yuanintegral,
                       "houamount" => $Member->integral,
                       "ip" => \Request::getClientIp(),
                   ];

                   \App\Moneylog::AddLog($log);

               }

                if(Cache::get('AutoSendMsg')=='自动') {
                    \App\Sendmobile::SendUid($Model->userid, 'rechargeok', $Model->amount);//成功短信通知
                    $Model->sendsms=1;
                    $Model->save();
                }
            }else{

                //失败通知
                $msg=[
                    "userid"=>$Model->userid,
                    "username"=>$Model->username,
                    "title"=>"充值失败",
                    "content"=>"您的充值失败(".$Model->amount.")",
                    "from_name"=>"系统审核",
                    "types"=>"充值",
                ];
                \App\Membermsg::Send($msg);

                if(Cache::get('AutoSendMsg')=='自动') {
                    \App\Sendmobile::SendUid($Model->userid, 'rechargesb', $Model->amount);//短信通知
                    $Model->sendsms=1;
                    $Model->save();
                }


            }


        }




      return ["status"=>0];

    }





}
