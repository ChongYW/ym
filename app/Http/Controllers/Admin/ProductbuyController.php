<?php


namespace App\Http\Controllers\Admin;
    use App\Member;
    use App\Memberlevel;
    use App\Product;
    use App\Productbuy;
    use Carbon\Carbon;
    use DB;
    use Illuminate\Http\Request;
    use Session;
    use Cache;


class ProductbuyController extends BaseController
{

    private $table="productbuy";


    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->Model=new Productbuy();

        $Products= Product::get();
        foreach ($Products as $Product){
            $this->Products[$Product->id]=$Product;
        }


      $Memberlevels= Memberlevel::get();

        foreach ($Memberlevels as $Memberlevel){
            $this->Memberlevels[$Memberlevel->id]=$Memberlevel;
        }
    }



    public function index(Request $request){

        return redirect(route($this->RouteController.".lists"));

    }




    public function lists(Request $request){



      //  \App\Memberwithdrawal::AddWithdrawal(1,5000);
        $pagesize=10;//默认分页数
        if(Cache::has('pagesize')){
            $pagesize=Cache::get('pagesize');
        }



        if($request->ajax()){
            $listDB = DB::table($this->table)
                ->select($this->table.'.*')
            ->where(function ($query) {
                $s_siteid=[];
                if(isset($_REQUEST['s_key']) && $_REQUEST['s_key']!=''){
                    $s_siteid[]=[$this->table.".username","=",$_REQUEST['s_key']];
                }

                $query->where($s_siteid);
            })
                ->where(function ($query) {
                $s_status=[];
                if(isset($_REQUEST['s_status']) && $_REQUEST['s_status']!='' && $_REQUEST['s_status']!='2'){
                    $s_status[]=[$this->table.".status","=",$_REQUEST['s_status']];

                    $query->where($s_status);
                }else if(isset($_REQUEST['s_status']) &&  $_REQUEST['s_status']=='2'){
                    $query->whereRaw("useritem_count+1=sendday_count")->whereDate("useritem_time2",Carbon::now()->addDay(1)->format("Y-m-d"));
                }


            })
                ->where(function ($query) {
                $s_status=[];
                if(isset($_REQUEST['s_categoryid']) && $_REQUEST['s_categoryid']>0){
                    $s_status[]=[$this->table.".productid","=",$_REQUEST['s_categoryid']];
                }

                $query->where($s_status);
            })
                ->where(function ($query) {
                    $date_s=[];
                    if(isset($_REQUEST['date_s']) && $_REQUEST['date_s']!=''){

                        $query->whereDate("created_at",">=",$_REQUEST['date_s']." 00:00:00");


                    }


                })

                ->where(function ($query) {
                    $date_s=[];
                    if(isset($_REQUEST['date_e']) && $_REQUEST['date_e']!=''){

                        $query->whereDate("created_at","<=",$_REQUEST['date_e']." 23:59:59");


                    }


                })
                ->where(function ($query) {
                    $date_s=[];
                    if(isset($_REQUEST['day']) && $_REQUEST['day']!=''){
                        $query->whereDate("created_at",Carbon::now()->format("Y-m-d"));
                    }
                });;

            $list=$listDB->orderBy($this->table.".id","desc")
                ->paginate($pagesize);

            if($list){

                foreach ($list as $item){
                    //$product=Product::where("id",$item->productid)->first();
                    $Member=  Member::find($item->userid);
                    $item->product=  isset($this->Products[$item->productid])?$this->Products[$item->productid]->title:'';
                    $item->rate=isset($this->Memberlevels[$item->level])?$this->Memberlevels[$item->level]->rate:0;

                    if(isset($this->Products[$item->productid])){


                    /*
                      if($this->Products[$item->productid]->hkfs == 1){
                            $moneyCount = $this->Products[$item->productid]->jyrsy * $item->amount/100;
                            $item->moneyCount= round($moneyCount,2);
                        }else{
                            $moneyCount = $this->Products[$item->productid]->jyrsy * $item->amount/100*$this->Products[$item->productid]->shijian;
                            $item->moneyCount= round($moneyCount,2);
                        }



                        if($this->Products[$item->productid]->hkfs == 1){
                            $elseMoney = $item->rate * $item->amount/100;
                            $item->elseMoney= round($elseMoney,2);
                        }else{
                            $elseMoney = $item->rate * $item->amount/100*$this->Products[$item->productid]->shijian;
                            $item->elseMoney= round($elseMoney,2);
                        }
                    */

                      $jyrsy=  $this->Products[$item->productid]->jyrsy+($item->ratecouponmoney);

                        $moneyCount = $jyrsy * $item->amount/100*$this->Products[$item->productid]->shijian;
                        $item->moneyCount= round($moneyCount,2);

                        $elseMoney = $item->rate * $item->amount/100*$this->Products[$item->productid]->shijian;
                        $item->elseMoney= round($elseMoney,2);


                    }else{
                        $item->moneyCount=0;
                    }


                    if($item->useritem_time2<=Carbon::now() && $item->useritem_count < $item->sendday_count){
                        $item->fh=1;
                    }else{
                        $item->fh=0;
                    }

                    $item->realname='';
                    if($Member){
                        $item->realname=$Member->realname;
                    }
                    $item->timenow=Carbon::now()->format("Y-m-d H:i:s");

                    $item->Benefits= \App\Product::Benefit($item->productid,$item->amount,$item->ratecouponmoney);

                    if($item->useritem_count==$item->sendday_count){

                        if($this->Products[$item->productid]->qxdw=='个小时'){
                            $item->useritem_time2= date("Y-m-d H:i:s",strtotime("{$item->useritem_time}+ {$this->Products[$item->productid]->shijian} hour"));
                        }else{
                            $item->useritem_time2= date("Y-m-d H:i:s",strtotime("{$item->useritem_time}+ {$this->Products[$item->productid]->shijian} day"));
                        }

                    }

                }

                return ["status"=>0,"list"=>$list,"pagesize"=>$pagesize];
            }
        }else{



            return $this->ShowTemplate([]);
        }

    }

    public function store(Request $request){

       

    }






    public function update(Request $request)
    {
        if($request->isMethod("post")){



            $Model = $this->Model::find($request->get('id'));

            if($Model->status==0){
                if($request->status=='1'){

                }else if($request->status=='-1'){

                }

                if($request->ajax()){
                   // return response()->json($data);
                }

            }




        }

    }


    public function sendsms(Request $request)
    {
        if($request->isMethod("post")){



            $Model = $this->Model::find($request->get('id'));

            if($Model->sendsms==0){
                $Model->sendsms=1;
                $Model->save();
            }

            \App\Sendmobile::SendUid($Model->userid,'txcg');//短信通知




            if($request->ajax()){
                return response()->json([
                    "msg"=>"操作成功","status"=>0
                ]);
            }


        }

    }





    public function delete(Request $request){

          if($request->ajax()) {
            if($request->input("id")){

                $member = DB::table($this->table)
                    ->where(['id' => $request->input("id")])
                    ->first();
                if($member){

                       $delete = DB::table($this->table)->where('id', '=', $request->input("id"))->delete();
                        if ($delete) {
                            return ["status" => 0, "msg" => "删除成功"];
                        } else {
                            return ["status" => 1, "msg" => "删除失败"];
                        }


                }else{
                    return ["status"=>1,"msg"=>"您没有权限删除操作"];
                }


            }


        }else{
            return ["status"=>1,"msg"=>"非法操作"];
        }

    }



}
