<?php

namespace App;

use App\Member;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Couponsgrant extends Model
{
    /**优惠券记录**/
    protected $table="couponsgrantlist";
    protected $primaryKey="id";
    public $timestamps=true;
    protected $guarded=[];
    protected $fillable = [
        'uid',
        'channel',
        'couponsid',
        'name',
        'type',
        'money',
        'usebuyid',
        'time',
        'exptime',
        'status'
    ];


    /*** \App\Couponsgrant::PushCoupon($cid,$uid,$channel=1)**/
    protected function PushCoupon($cid,$uid,$channel=1){


        if($cid>0 && $uid>0) {
            $Coupon = DB::table("coupons")->where("id", $cid)->where("status", 1)->first();
            if ($Coupon) {
                $Member = Member::find($uid);
                $Couponsgrant = new Couponsgrant();
                $Couponsgrant->uid = $uid;
                $Couponsgrant->uname = $Member->username;
                $Couponsgrant->couponsid = $cid;
                $Couponsgrant->channel = $channel;
                $Couponsgrant->name = $Coupon->name;
                $Couponsgrant->type = $Coupon->type;
                $Couponsgrant->money = $Coupon->money;
                $Couponsgrant->status = 1;
                $Couponsgrant->time = Carbon::now();
                $Couponsgrant->exptime = Carbon::now()->addDay($Coupon->expdata);
                $Couponsgrant->save();


                $couponstype = config("coupons.type");
                $couponschannel = config("coupons.channel");

                $title = isset($couponstype[$Coupon->type]) ? $couponstype[$Coupon->type] : '现金券';
                $channelN = isset($couponschannel[$channel]) ? $couponschannel[$channel] : '推送';

                $msg = [
                    "userid" => $uid,
                    "username" => $Member->username,
                    "title" => $title,
                    "content" => "赠送" . $Coupon->name . "(" . $channelN . ")",
                    "from_name" => "系统发送",
                    "types" => $title,
                ];
                //\App\Membermsg::Send($msg);


                if ($title == '现金券') {
                    $log = [
                        "userid" => $Member->id,
                        "username" => $Member->username,
                        "money" => $Coupon->money,
                        "notice" => "赠送" . $Coupon->name . "(" . $channelN . ")",
                        "type" => $title,
                        "status" => "+",
                        "yuanamount" => $Member->amount,
                        "houamount" => $Member->amount,
                        "ip" => \Request::getClientIp(),
                    ];

                    \App\Moneylog::AddLog($log);
                } else if ($title == '加息券') {

                    $log = [
                        "userid" => $Member->id,
                        "username" => $Member->username,
                        "money" => 0,
                        "notice" => "赠送" . $Coupon->name . "(" . $channelN . ")",
                        "type" => $title,
                        "status" => "+",
                        "yuanamount" => $Member->amount,
                        "houamount" => $Member->amount,
                        "ip" => \Request::getClientIp(),
                    ];

                    \App\Moneylog::AddLog($log);
                }

                return true;
            } else {
                return false;
            }
        }else{
            return false;
        }

    }


    protected function GetUserCoupon($pid,$uid,$type){
      /**处理已过期的券**/
      Couponsgrant::where("exptime","<",Carbon::now())->where("status",1)->update(["status"=>3]);

      $Product=  Product::find($pid);

      if($Product){

          return  $Couponsgrants= Couponsgrant::whereIn("couponsid",explode(",",$Product->coupon))
              ->where("type",$type)
              ->where("uid",$uid)
              ->where("status",1)
              ->where("exptime",">",Carbon::now())
              ->get();

      }else{
          return [];
      }

    }
}
