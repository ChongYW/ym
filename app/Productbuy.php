<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Cache;

class Productbuy extends Model
{
    protected $table="productbuy";
    protected $primaryKey="id";
    public $timestamps=true;
    protected $guarded=[];
    protected $fillable = [
        'userid',
        'username',
        'productid',
        'amount',
        'benefit',
        'ip',
        'useritem_time',
        'useritem_time1',
        'useritem_time2',
        'useritem_count',
        'status',
        'sendday_count',
        'cashcouponid',
        'cashcoupontype',
        'cashcouponmoney',
        'cashcouponname',

        'ratecouponid',
        'ratecoupontype',
        'ratecouponmoney',
        'ratecouponname',
        'level'
    ];

    //查询返佣比例
    protected function checkBayong($id){

        $Product=  Product::find($id);
        return $Product->tqsyyj;
    }


    //返回今天星期几
    protected  function weekname($time){

        $weekarray=array("日","一","二","三","四","五","六");
        return "星期".$weekarray[$time];
    }



    protected function DateAdd($part, $number, $date){
        $date_array = getdate(strtotime($date));
        $hor = $date_array["hours"];
        $min = $date_array["minutes"];
        $sec = $date_array["seconds"];
        $mon = $date_array["mon"];
        $day = $date_array["mday"];
        $yar = $date_array["year"];
        switch($part){
            case "y": $yar += $number; break;
            case "q": $mon += ($number * 3); break;
            case "m": $mon += $number; break;
            case "w": $day += ($number * 7); break;
            case "d": $day += $number; break;
            case "h": $hor += $number; break;
            case "n": $min += $number; break;
            case "s": $sec += $number; break;
        }
        $FengHongDateFormat='Y-m-d H:i:s';
        if(Cache::has('FengHongDateFormat')){
            $FengHongDateFormat=Cache::get('FengHongDateFormat');
        }
        return date($FengHongDateFormat, mktime($hor, $min, $sec, $mon, $day, $yar));
    }


    //查询上家账号
    protected function checkTjr($username){

/*        global $db,$db_prefix;
//	$sql = "select * from {$db_prefix}member where username = '{$username}'";
        $sql = "SELECT username from {$db_prefix}member WHERE invicode = (SELECT inviter FROM {$db_prefix}member where username = '{$username}')";
        $rs = $db->get_one($sql);*/
       $BMeb= Member::where("username",$username)->value("inviter");
       $Shja= Member::where("invicode",$BMeb)->value("username");
        return $Shja;
    }

        //随机生成购买记录
        protected function GetBuyList($pid){




            $RegFrom = ['/pc/finance/css/images/icons1.png', '/pc/finance/css/images/icons2.png'];
            $RegTitle = ['移动端', 'PC端'];

            /**真实购买记录**/
            if(Cache::has("GetBuyREList_".$pid)){
                $Datas2= Cache::get("GetBuyREList_".$pid);
            }else {
                $Productbuys = Productbuy::where("productid", $pid)->orderBy("id", "desc")->limit(10)->get();

                $Datas2 = [];
                foreach ($Productbuys as $ki => $BUYS) {
                    $Mobile = \App\Member::half_replace($BUYS->username);

                    $REG = \App\Member::UserRegFrom($BUYS->userid) == 'pc' ? 1 : 0;
                    $Datas2[$ki]['mobile'] = $Mobile;
                    $Datas2[$ki]['amount'] = sprintf("%.2f", $BUYS->amount);
                    $Datas2[$ki]['RegFrom'] = $RegFrom[$REG];
                    $Datas2[$ki]['title'] = $RegTitle[$REG];
                    $Datas2[$ki]['DateTime'] = $BUYS->created_at;
                    $Datas2[$ki]['DateTimeM'] = date("m-d H:i", strtotime($BUYS->created_at));

                }

                Cache::put("GetBuyREList_".$pid,$Datas2,60);

            }

            /**随机购买记录**/
            if(Cache::has("GetRANDBuyList_".$pid)){
                $Datas= Cache::get("GetRANDBuyList_".$pid);
            }else {
                $Mobiles = \App\Member::RandomMobile(10);
                $Product = Product::find($pid);

                $DateTime = Carbon::now();

                if ($Product->xmjd >= 100) {
                    if($Product->endingtime!=''){
                        $DateTime->setTimestamp(strtotime($Product->endingtime));
                    }else{
                        $DateTime->setTimestamp(strtotime($Product->updated_at));
                    }


                }

                $Datas = [];
                $buydatas = [];
                if($Product->buydata!=''){
                    $buydatas= json_decode($Product->buydata,true);
                }


                foreach ($Mobiles as $k => $Mobile) {



                   if(count($buydatas)==3){
                       if(isset($buydatas[0]) && isset($buydatas[1]) && isset($buydatas[2])){
                           $Rands=rand($buydatas[0],$buydatas[1])*$buydatas[2];

                           if($Rands<1){
                               $min = $Product->qtje / 100;
                               $max = ($Product->qtje / 100)+rand(20,98);
                               $Rands = rand($min, $max) * 100;
                           }

                       }else{
                           $min = $Product->qtje / 100;
                           $max = ($Product->qtje / 100)+rand(20,98);
                           $Rands = rand($min, $max) * 100;
                       }


                   }else {

                      // $Rands = rand(1, 9) * 100 + rand(1, 9) * 100 + rand(1, 9) * 100;

                       $min = $Product->qtje / 100;
                       $max = ($Product->qtje / 100)+rand(20,98);
                       $Rands = rand($min, $max) * 100;

                       /*if ($Product->qtje > 0 && $Product->zgje > 0) {
                           //$jiage = [$Product->qtje, $Product->zgje];
                           $min = $Product->qtje / 100;
                           $max = $Product->zgje / 100;
                           $Rands = rand($min, $max) * 100;

                       } else if ($Product->zgje < 1) {
                           //$jiage = [$Product->qtje, $Product->qtje];
                           $min = $Product->qtje / 100;
                           $max = $Product->qtje / 100 * 5;
                           $Rands = rand($min, $max) * 100;
                       } else if ($Product->qtje < 1) {
                           //$jiage = [$Product->zgje+$Product->qtje, $Product->zgje+$Product->zgje];
                           $min = 1;
                           $max = $Product->zgje / 100;
                           $Rands = rand($min, $max) * 100;
                       }*/
                   }

                    $REG = rand(0, 1);
                    $Datas[$k]['mobile'] = $Mobile;
                    $Datas[$k]['amount'] = sprintf("%.2f", $Rands);
                    $Datas[$k]['RegFrom'] = $RegFrom[$REG];
                    $Datas[$k]['title'] = $RegTitle[$REG];
                    $Datas[$k]['DateTime'] = $DateTime->addSecond(-rand(60, 600))->format("Y-m-d H:i:s");
                    $Datas[$k]['DateTimeM'] = $DateTime->format("m-d H:i");
                }

                Cache::put("GetRANDBuyList_".$pid,$Datas,600);
            }

            $NewData=  array_merge($Datas2,$Datas);

            $last_names = array_column($NewData,'DateTime');
            array_multisort($last_names,SORT_DESC,$NewData);

            $NewData=array_slice($NewData,0,10);

           
            return $NewData;


        }

}
