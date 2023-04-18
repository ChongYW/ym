<?php


namespace App\Http\Controllers\Admin;
    use App\Member;
    use App\Site;
    use Carbon\Carbon;
    use DB;
    use App\Coupons;
    use Illuminate\Http\Request;
    use Session;
    use Cache;

class CouponsController extends BaseController
{

    private $table="coupons";


    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->Model=new Coupons();
    }


    public function index(Request $request){

        return redirect("admin/".$this->RouteController."/lists");

    }




    public function lists(Request $request){

        $pagesize=10;//默认分页数
        if(Cache::has('pagesize')){
            $pagesize=Cache::get('pagesize');
        }


        $list = DB::table($this->table)
            ->select($this->table.'.*')
           ->where(function ($query) {
                $s_key_name=[];
                if(isset($_REQUEST['s_key'])){
                    $s_key_name[]=[$this->table.".name","like","%".$_REQUEST['s_key']."%"];
                }

                $query->orwhere($s_key_name);
            })
            ->where(function ($query) {
                $s_key_name=[];
                if(isset($_REQUEST['s_status']) && $_REQUEST['s_status']!=''){
                    $s_key_name[]=[$this->table.".status","=",$_REQUEST['s_status']];
                }

                $query->where($s_key_name);
            })
            ->where(function ($query) {
                $s_key_name=[];
                if(isset($_REQUEST['s_type']) && $_REQUEST['s_type']!=''){
                    $s_key_name[]=[$this->table.".type","=",$_REQUEST['s_type']];
                }

                $query->where($s_key_name);
            })
            ->orderBy($this->table.".sort","desc")
            ->paginate($pagesize);


        if($request->ajax()){
            if($list){
                return ["status"=>0,"list"=>$list,"pagesize"=>$pagesize];
            }
        }else{
            return $this->ShowTemplate(["list"=>$list,"pagesize"=>$pagesize]);
        }

    }

    public function store(Request $request){

        if($request->isMethod("post")){
            $messages = [
                'name.required' => '名称不能为空!',
                'money.required' => '金额/加息不能为空!',
            ];

            $result = $this->validate($request, [
                "name"=>"required",
                "money"=>"required",
            ], $messages);




            $Model = $this->Model;
            $Model->name = $request->get('name');
            $Model->sort = $request->input('sort');
            $Model->expdata = $request->input('expdata');
            $Model->type = $request->input('type');
            $Model->money = $request->input('money');
            $Model->status = $request->input('status');
            $Model->remark = $request->input('remark');

            $Model->save();


            if($request->ajax()){
                return response()->json([
                    "msg"=>"添加成功","status"=>0
                ]);
            }else{
                return redirect(route($this->RouteController.'.store'))->with(["msg"=>"添加成功","status"=>0]);
            }



        }else{
            return $this->ShowTemplate([]);
        }

    }






    public function update(Request $request)
    {
        if($request->isMethod("post")){

            $messages = [
                'name.required' => '名称不能为空!',
                'money.required' => '金额/加息不能为空!',
            ];

            $result = $this->validate($request, [
                "name"=>"required",
                "money"=>"required",
            ], $messages);


            $Model = $this->Model::find($request->input('id'));
            $Model->name = $request->get('name');
            $Model->sort = $request->input('sort');
            $Model->expdata = $request->input('expdata');
            $Model->type = $request->input('type');
            $Model->money = $request->input('money');
            $Model->status = $request->input('status');
            $Model->remark = $request->input('remark');
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

            return $this->ShowTemplate(["edit"=>$Model,"status"=>0]);
        }

    }



    public function delete(Request $request){


        if($request->ajax()) {

            if(count($request->input("ids"))>0){



                $delete = DB::table($this->table)->whereIn('id', $request->input("ids"))->delete();
                if ($delete) {
                    DB::table("couponsgrantlist")->whereIn('couponsid', $request->input("ids"))->delete();
                    return ["status" => 0, "msg" => "批量删除成功"];
                } else {
                    return ["status" => 1, "msg" => "批量删除失败"];
                }
            }

            if($request->input("id")){

                $admin = DB::table($this->table)
                    ->where(['id' => $request->input("id")])
                    ->first();
                if($admin){

                    $delete = DB::table($this->table)->where('id', '=', $request->input("id"))->delete();
                    if ($delete) {
                        DB::table("couponsgrantlist")->where('couponsid', '=', $request->input("id"))->delete();
                        return ["status" => 0, "msg" => "删除成功"];
                    } else {
                        return ["status" => 1, "msg" => "删除失败"];
                    }


                }


            }

            return ["status"=>1,"msg"=>"非法操作"];
        }else{
            return ["status"=>1,"msg"=>"非法操作"];
        }

    }

    /***  优惠券发放  ***/
    public function grant(Request $request){


        if($request->isMethod("post")){


            if($request->ajax()) {
                $pagesize = 10;//默认分页数
                if (\Illuminate\Support\Facades\Cache::has('pagesize')) {
                    $pagesize = Cache::get('pagesize');
                }
                if(isset($_REQUEST['s_key']) && $_REQUEST['s_key']!='') {



                    $list = DB::table("member")
                        ->where(function ($query) {
                            $s_key_username = [];

                            if (isset($_REQUEST['s_key']) && $_REQUEST['s_key'] != '') {
                                $s_key_username[] = ["username", "like", "%" . $_REQUEST['s_key'] . "%"];
                            }

                            $query->where($s_key_username);
                        })
                        ->orderBy("id", "desc")
                        ->paginate($pagesize);

                    return ["status" => 0, "list" => $list, "pagesize" => $pagesize];
                }else{

                    return ["status" => 0, "list" => [], "pagesize" => $pagesize];
                }

            }else{

            }

        }else{

            if(\Illuminate\Support\Facades\Cache::has('memberlevel.list')){
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

            view()->share("memberlevel",$memberlevelName);


                $coupons = DB::table($this->table)

                ->where("status","1")

                ->orderBy($this->table.".sort","desc")
                ->get();

            view()->share("coupons",$coupons);
            return $this->ShowTemplate([]);
        }
    }
    /***  优惠券发放  ***/
    public function grantqf(Request $request){

        if($request->isMethod("get")){

            if($request->input('s_type')<1) {
                return redirect(route($this->RouteController . '.grant', ["msg" => "请选择会员等级"]));
            }

            if($request->input('cid')>0) {
                $meberids = Member::where("level", $request->input('s_type'))->pluck("id");

                if (count($meberids) > 0) {

                    foreach ($meberids as $mid) {
                        \App\Couponsgrant::PushCoupon($request->input('cid'), $mid, 1);
                    }

                }


                return redirect(route($this->RouteController . '.grant', ["msg" => "群发成功"]));
            }else{
                return redirect(route($this->RouteController . '.grant', ["msg" => "请选择优惠券"]));
            }



        }else if($request->isMethod("post")){


            if(\App\Couponsgrant::PushCoupon($request->input('cid'),$request->input('uid'),1)){
                return ["status"=>0,"msg"=>"发放成功"];
            }else{
                return ["status"=>1,"msg"=>"发放失败"];
            }

        }
    }


}
