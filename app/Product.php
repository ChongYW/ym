<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table="products";
    protected $primaryKey="id";
    public $timestamps=true;
    protected $guarded=[];
    protected $fillable = ['category_id', 'category_name', 'title','shorttitle', 'bljg', 'xmgm','xmjd', 'qtje', 'content', 'zgje', 'tzrs', 'ktje', 'jyrsy', 'tqsyyj','pic','shijian','qxdw','hkfs','cishu','tzzt','isft','level','issy','sort','click_count','xxtc','xxtcbl','isaouttm','endingtime',
        'rise','frequency','rise_time','interval_time','ketouinfo',
        'wzone','wztwo','wzthree','coupon',
        'insuranceseal','tagcolor','buydata'];


    /** 2019 11 15
     * ALTER TABLE `products` ADD `xxtc` INT(1) NULL DEFAULT '0' COMMENT '下线提成设置' AFTER `sort`;
     * ALTER TABLE `products` ADD `xxtcbl` TEXT NULL COMMENT '提成比例配置' AFTER `xxtc`;
     * */
    protected function GetTitle($Id)
    {
        return $title=Product::where("id",$Id)->value("title");

    }

    protected function GetShouYi($Id)
    {
        return $jyrsy=Product::where("id",$Id)->value("jyrsy");

    }



    // \App\Product::Benefit($Id)
    protected function Benefit($Id,$moneys,$rate=0)
    {

         $Pro= Product::where("id",$Id)->first();
         if($Pro->hkfs==4) {
             $jyrsy = ($Pro->jyrsy+$rate)/ 100;
             $shijian = $Pro->shijian;
             $Benefit = sprintf("%.2f", $moneys * $jyrsy);
             $Benefits = $Benefit;
             for ($i = 1; $i < $shijian; $i++) {
                 $Benefit += sprintf("%.2f", $Benefit * $jyrsy);
                 $Benefits += $Benefit;
             }

             return sprintf("%.2f", $Benefits);
         }else{
             return 0;
         }

    }


    // \App\Product::BenefitData($Id)
    protected function BenefitData($Id,$moneys=0)
    {

         $Pro= Product::where("id",$Id)->first();
         if($moneys<1){
             $moneys=$Pro->qtje;
         }

         $Data=[];
         if($Pro->hkfs==4) {
             $jyrsy = $Pro->jyrsy / 100;

             $shijian = $Pro->shijian;
             $Benefit = sprintf("%.2f", $moneys * $jyrsy);
             $Data['data'][0]['Moneys']=sprintf("%.2f",$moneys);
             $Data['data'][0]['HMoneys']=sprintf("%.2f",0);
             $Benefits = $Benefit;
             $Data['data'][0]['Benefit']=sprintf("%.2f",$Benefit);
             $Data['data'][0]['Benefits']=sprintf("%.2f",$Benefits);


             for ($i = 1; $i < $shijian; $i++) {
                 if($i == ($shijian-1)){
                     $Data['data'][$i]['Benefits'] = sprintf("%.2f", $moneys + $Benefits);
                     $Benefit += sprintf("%.2f", $Benefit * $jyrsy);


                     $Data['data'][$i]['Moneys'] = sprintf("%.2f",0);
                     $Data['data'][$i]['HMoneys'] = sprintf("%.2f", $moneys + $Benefits);

                     $Data['data'][$i]['Benefit'] = sprintf("%.2f",$Benefit);
                     $Benefits += $Benefit;

                 }else {
                     $Data['data'][$i]['Moneys'] = sprintf("%.2f", $moneys + $Benefits);
                     $Benefit += sprintf("%.2f", $Benefit * $jyrsy);
                     $Benefits += $Benefit;
                     $Data['data'][$i]['Benefit'] = sprintf("%.2f",$Benefit);
                     $Data['data'][$i]['Benefits'] = sprintf("%.2f",$Benefits);
                     $Data['data'][$i]['HMoneys']=sprintf("%.2f",0);
                 }

             }
                //sprintf("%.2f", $Benefits);

             $Data['Benefits']=sprintf("%.2f", $Benefits);
             $Data['Moneys']=sprintf("%.2f", $moneys);
             $Data['HMoneys']=sprintf("%.2f", $moneys+$Benefits);
             return $Data;
         }else{
             return [];
         }

    }

}
