<?php


namespace App\Http\Controllers\Admin;
    use App\Member;
    use App\Memberlevel;
    use App\Memberwithdrawal;
    use Carbon\Carbon;
    use DB;
    use Illuminate\Http\Request;
    use Session;
    use Cache;


class MemberwithdrawalController extends BaseController
{

    private $table="memberwithdrawal";


    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->Model=new Memberwithdrawal();


/*        if(Cache::has("admin.payment")){
            $this->payment =Cache::get("admin.payment");
        }else {
            $payments = DB::table("payment")->get();
            $payment = [];
            foreach ($payments as $pay) {
                $payment[$pay->id] = $pay->pay_name;
            }
            $this->payment =$payment;
            Cache::put("admin.payment",$payment,Cache::get("cachetime"));
        }

        view()->share("payment",$this->payment);*/

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
                if(isset($_REQUEST['s_status']) && $_REQUEST['s_status']!=''){
                    $s_status[]=[$this->table.".status","=",$_REQUEST['s_status']];
                }

                $query->where($s_status);
            })
                ->where(function ($query) {
                    $date_s=[];
                    if(isset($_REQUEST['day']) && $_REQUEST['day']!=''){
                        $query->whereDate("created_at",Carbon::now()->format("Y-m-d"));
                    }
                });

            $list=$listDB->orderBy($this->table.".id","desc")
                ->paginate($pagesize);

            $pageamounts=0;

            if($list){

                foreach ($list as $item){

                    $Member=  Member::find($item->userid);
                    if($Member){
                        $item->userBank =  $Member->username;
                        $item->bankName =  $Member->bankname;
                        $item->bankrealname =  $Member->bankrealname;
                        $item->bankcode =  $Member->bankcode;
                        $item->bankaddress =  $Member->bankaddress;
                    }else{
                        $item->userBank =  '';
                        $item->bankName =  '';
                        $item->bankrealname =  '';
                        $item->bankcode =  '';
                        $item->bankaddress =  '';
                    }


                    $item->mtype=\App\Member::where("id",$item->userid)->value("mtype");

                    if($item->status==1){
                        $pageamounts+=$item->amount;
                    }

                }

                $amounts= $listDB->where('status','1')->sum('amount');

                return ["status"=>0,"list"=>$list,"pagesize"=>$pagesize,"pageamounts"=>sprintf("%.2f",$pageamounts),"amounts"=>sprintf("%.2f",$amounts)];
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
                   $data= \App\Memberwithdrawal::ConfirmWithdrawal($Model->id);
                }else if($request->status=='-1'){
                    $data= \App\Memberwithdrawal::CancelWithdrawal($Model->id);
                }

                if($request->ajax()){
                    return response()->json($data);
                }

            }




        }else{


            $Model = $this->Model::find($request->get('id'));

            return $this->ShowTemplate(["edit"=>$Model,"status"=>0]);
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



            if($request->contents!=''){
                \App\Sendmobile::SendUContent($Model->userid,$request->contents);//短信通知


                $msg=[
                    "userid"=>$Model->userid,
                    "username"=>$Model->username,
                    "title"=>"提现通知",
                    "content"=>$request->contents,
                    "from_name"=>"系统审核",
                    "types"=>"提款",
                ];
                \App\Membermsg::Send($msg);

            }else{
                \App\Sendmobile::SendUid($Model->userid,'txcg',$Model->amount);//短信通知
            }


            if($request->ajax()){
                return response()->json([
                    "msg"=>"操作成功","status"=>0
                ]);
            }


        }

    }





    public function soundignore(Request $request){
        $Model = $this->Model::find($request->get('id'));

        if($Model->sound_ignore==0){
            $Model->sound_ignore=1;
            $Model->save();
        }

        if($request->ajax()){
            return response()->json([
                "msg"=>"操作成功","status"=>0
            ]);
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
