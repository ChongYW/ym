<?php

namespace App\Http\Controllers\Admin;

use App\Member;
use App\Membermsg;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Article;
use Cache;
use App\Seal;
use DB;


class IndexController extends BaseController
{
   // protected $DOM;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        //$this->DOM = new Article();
        $Members=   Member::count();
        view()->share("Members",$Members);

        $OnMembers=   Member::whereDate("updated_at",">",Carbon::now()->addSeconds(-600))->count();
        view()->share("OnMembers",$OnMembers);

        $NewMembers=   Member::whereDate("created_at",Carbon::now()->format("Y-m-d"))->count();
        view()->share("NewMembers",$NewMembers);

        $INMembers=   Member::whereNotNull("inviter")->count();
        view()->share("INMembers",$INMembers);

        $MemberQd=   Membermsg::where("types","每日签到")->whereDate("created_at",Carbon::now()->format("Y-m-d"))->count();
        view()->share("MemberQd",$MemberQd);
        $tomorrows= DB::table("productbuy")->whereRaw("useritem_count+1=sendday_count")->whereDate("useritem_time2",Carbon::now()->addDay(1)->format("Y-m-d"))->count();
        view()->share("tomorrows",$tomorrows);
    }




    //GET 首页
    public function index(Request $request){



        return $this->ShowTemplate();

    }

    //GET 欢迎页
    public function main(Request $request){

       // echo \App\Product::Benefit('69',350000);




        $laravel = app();

       $articles= DB::table("articles")->count();
       $members= DB::table("member")->count();
       $products= DB::table("products")->count();
       $onlinemsg= DB::table("onlinemsg")->count();
        $productbuys= DB::table("productbuy")->count();
        $amounts= DB::table("productbuy")->sum('amount');
        $memberrecharge= DB::table("memberrecharge")->count();
        $memberwithdrawal= DB::table("memberwithdrawal")->count();

        $memberlevel= DB::table("memberlevel")->orderBy("id","desc")->get();

        $tomorrows= DB::table("productbuy")->whereRaw("useritem_count+1=sendday_count")->whereDate("useritem_time2",Carbon::now()->addDay(1)->format("Y-m-d"))->count();

        foreach($memberlevel as $level){
            $level->merbers=DB::table("member")->where("level",$level->id)->where("state","1")->orderBy("logintime","desc")->get();
        }



       // $DayOnMembers=   Member::whereDate("created_at",Carbon::now()->format("Y-m-d"))->whereDate("updated_at",">",Carbon::now()->addSeconds(-600))->count();

        $DayOnMembers=   Member::where("updated_at",">",Carbon::now()->addSeconds(-600))->count();
        view()->share("OnMembers",$DayOnMembers);
        view()->share("DayOnMembers",$DayOnMembers);

        $Dayproductbuys= DB::table("productbuy")->whereDate("created_at",Carbon::now()->format("Y-m-d"))->count();
        view()->share("Dayproductbuys",$Dayproductbuys);


        $Daymemberrecharge= DB::table("memberrecharge")->whereDate("created_at",Carbon::now()->format("Y-m-d"))->where("type","<>",'优惠活动')->count();
        $Daymemberwithdrawal= DB::table("memberwithdrawal")->whereDate("created_at",Carbon::now()->format("Y-m-d"))->count();

        view()->share("Daymemberwithdrawal",$Daymemberwithdrawal);
        view()->share("Daymemberrecharge",$Daymemberrecharge);
        view()->share("Dayproductbuys",$Dayproductbuys);

        return $this->ShowTemplate([
            "request"=>$request,
            "articles"=>$articles,
            "members"=>$members,
            "products"=>$products,
            "onlinemsg"=>$onlinemsg,
            "productbuys"=>$productbuys,
            "memberrecharge"=>$memberrecharge,
            "memberwithdrawal"=>$memberwithdrawal,
            "amounts"=>sprintf("%.2f",$amounts),
            "laravel"=>$laravel,
            "memberlevel"=>$memberlevel,
            "tomorrows"=>$tomorrows,
            "now"=>Carbon::now()
        ]);

    }

        //清空缓存
        public function CacheFlush(){
            \App\Seting::PutConfig();
            return ["status" => 0, "msg" => "缓存清空"];
        }


    public function msgconut(Request $request){

        $msgconuts= DB::table("onlinemsg")->where("status","0")->count();
        $rechargeconuts= DB::table("memberrecharge")->where("status","0")->where("sound_ignore","0")->count();
        $withdrawalconuts= DB::table("memberwithdrawal")->where("status","0")->where("sound_ignore","0")->count();



        $Members=   Member::count();

        $OnMembers=   Member::where("updated_at",">",Carbon::now()->addSeconds(-600))->count();


        $NewMembers=   Member::whereDate("created_at",Carbon::now()->format("Y-m-d"))->count();




        $MemberQd=   Membermsg::where("types","每日签到")->whereDate("created_at",Carbon::now()->format("Y-m-d"))->count();



        $dayrechargeconuts= DB::table("memberrecharge")->whereDate("created_at",Carbon::now()->format("Y-m-d"))->where("status","1")->where("type","<>",'优惠活动')->sum("amount");
        $daywithdrawalconuts= DB::table("memberwithdrawal")->whereDate("created_at",Carbon::now()->format("Y-m-d"))->where("status","1")->sum("amount");

        return response()->json([
            "msgconuts"=>$msgconuts,
            "msginfo"=>"未读留言({$msgconuts})",

            "rs"=>$rechargeconuts,
            "rsinfo"=>"未处理充值({$rechargeconuts})",

            "ws"=>$withdrawalconuts,
            "wsinfo"=>"未处理提款({$withdrawalconuts})",
            "conuts"=>($msgconuts+$withdrawalconuts+$rechargeconuts),

            "Members"=>$Members,
            "OnMembers"=>$OnMembers,
            "NewMembers"=>$NewMembers,
            "MemberQd"=>$MemberQd,
            "dayrechargeconuts"=>sprintf("%.2f",$dayrechargeconuts),
            "daywithdrawalconuts"=>sprintf("%.2f",$daywithdrawalconuts),

            "playSound"=>Cache::get('playSound')
        ]);

    }

}
