<?php


namespace App\Http\Controllers\Admin;
    use App\Paycode;
    use App\Payment;
    use DB;
    use Illuminate\Http\Request;
    use Session;
    use Cache;


class PaymentController extends BaseController
{

    private $table="payment";


    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->Model=new Payment();



    }



    public function index(Request $request){

        return redirect(route($this->RouteController.".lists"));

    }




    public function lists(Request $request){


        $adminAuthID =$request->session()->get('adminAuthID');
        $adminID =$request->session()->get('adminID');



        $pagesize=10;//默认分页数
        if(Cache::has('pagesize')){
            $pagesize=Cache::get('pagesize');
        }



        if($request->ajax()){
            $listDB = DB::table($this->table)
                ->select($this->table.'.*');

            $list=$listDB->orderBy($this->table.".id","asc")
                ->paginate($pagesize);

            if($list){
                return ["status"=>0,"list"=>$list,"pagesize"=>$pagesize];
            }
        }else{



            return $this->ShowTemplate([]);
        }

    }

    public function store(Request $request){

        if($request->isMethod("post")){



            $Model = $this->Model;

            $Model->pay_code = $request->input('pay_code');
            $Model->pay_name = $request->input('pay_name');
            $Model->pay_bank = $request->input('pay_bank');
            $Model->pay_pic = $request->input('pay_pic');
            $Model->pay_desc = $request->input('pay_desc');
            $Model->enabled = $request->input('enabled');
            $Model->pay_pic_on = $request->input('pay_pic_on');
            $Model->pay_codename = $request->input('pay_codename');
            $Model->pay_pic_auto = $request->input('pay_pic_auto');
            $Model->pay_order_number = $request->input('pay_order_number');
            $Model->recipient_bank = $request->input('recipient_bank');
            $Model->recipient_payee = $request->input('recipient_payee');
            $Model->recipient_account = $request->input('recipient_account');
            $Model->save();


            if($request->ajax()){
                return response()->json([
                    "msg"=>"添加成功","status"=>0
                ]);
            }else{
                return redirect(route($this->RouteController.'.store'))->with(["msg"=>"添加成功","status"=>0]);
            }



        }else{



            return $this->ShowTemplate();
        }

    }






    public function update(Request $request)
    {
        if($request->isMethod("post")){



            $Model = $this->Model::find($request->input('id'));
            $Model->pay_code = $request->input('pay_code');
            $Model->pay_name = $request->input('pay_name');
            $Model->pay_bank = $request->input('pay_bank');
            $Model->pay_pic = $request->input('pay_pic');
            $Model->pay_desc = $request->input('pay_desc');
            $Model->enabled = $request->input('enabled');
            $Model->pay_codename = $request->input('pay_codename');
            $Model->pay_pic_on = $request->input('pay_pic_on');
            $Model->pay_pic_auto = $request->input('pay_pic_auto');
            $Model->pay_order_number = $request->input('pay_order_number');

            $Model->recipient_bank = $request->input('recipient_bank');
            $Model->recipient_payee = $request->input('recipient_payee');
            $Model->recipient_account = $request->input('recipient_account');

            $Model->save();



            if($request->ajax()){
                return response()->json([
                    "msg"=>"修改成功","status"=>0
                ]);
            }else{
                return redirect(route($this->RouteController.'.update',["id"=>$request->input("id")]))->with(["msg"=>"修改成功","status"=>0]);
            }


        }else{


            $Model = $this->Model::find($request->get('id'));
            $Codes = \App\Paycode::where("pay_pid",$request->get('id'))->orderBy("pay_status","desc")->get();



            return $this->ShowTemplate(["edit"=>$Model,"codes"=>$Codes,"status"=>0]);
        }

    }

    public function upcode(Request $request)
    {
        if($request->isMethod("post") && $request->action=='add'){

            $Model = new Paycode();
            $Model->pay_pid = $request->input('pay_pid');
            $Model->pay_pic = $request->input('pay_pic');
            $Model->pay_name = $request->input('pay_name');
            $Model->pay_status = $request->input('pay_status');
            $Model->pay_number = $request->input('pay_number');

            $Model->save();



            if($request->ajax()){
                return response()->json([
                    "msg"=>"添加成功","status"=>0
                ]);
            }else{
                return redirect(route($this->RouteController.'.upcode',["id"=>$request->input("id")]))->with(["msg"=>"添加成功","status"=>0]);
            }


        }else if($request->isMethod("post") && $request->action=='edit'){

        $Paycode = new Paycode();
        $Model=$Paycode::find($request->cid);
        $Model->pay_pid = $request->input('pay_pid');
        $Model->pay_pic = $request->input('pay_pic');
        $Model->pay_name = $request->input('pay_name');
        $Model->pay_status = $request->input('pay_status');
        $Model->pay_number = $request->input('pay_number');

        $Model->save();



        if($request->ajax()){
            return response()->json([
                "msg"=>"操作成功","status"=>0
            ]);
        }else{
            $action='add';
            if($request->action!=''){
                $action =$request->action;
            }
            return redirect(route($this->RouteController.'.upcode',["cid"=>$request->input("cid")]))->with(["msg"=>"操作成功","status"=>0,"action"=>$action]);
        }


    }else{
            $action='add';
            if($request->action!=''){
                $action =$request->action;
            }

            $Model = $this->Model::find($request->get('id'));

            $Paycode = new Paycode();
            $CModel=$Paycode::find($request->cid);

            return $this->ShowTemplate(["edit"=>$Model,"cedit"=>$CModel,"pid"=>$request->get('id'),"cid"=>$request->get('cid'),"status"=>0,"action"=>$action]);
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
    public function codedelete(Request $request){

          if($request->ajax()) {
            if($request->input("id")){

                $member = DB::table("paycode")
                    ->where(['id' => $request->input("id")])
                    ->first();
                if($member){

                       $delete = DB::table("paycode")->where('id', '=', $request->input("id"))->delete();
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
