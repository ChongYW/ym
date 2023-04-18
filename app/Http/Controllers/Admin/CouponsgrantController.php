<?php


namespace App\Http\Controllers\Admin;
    use App\Site;
    use Carbon\Carbon;
    use DB;
    use App\Couponsgrant;
    use Illuminate\Http\Request;
    use Session;
    use Cache;

class CouponsgrantController extends BaseController
{

    private $table="couponsgrantlist";


    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->Model=new Couponsgrant();
    }


    public function index(Request $request){

        return redirect("admin/".$this->RouteController."/lists");

    }




    public function lists(Request $request){
        /**处理已过期的券**/
        Couponsgrant::where("exptime","<",Carbon::now())->where("status",1)->update(["status"=>3]);

        $pagesize=10;//默认分页数
        if(Cache::has('pagesize')){
            $pagesize=Cache::get('pagesize');
        }


        $list = DB::table($this->table)
            ->select($this->table.'.*')
           ->where(function ($query) {
                $s_key_name=[];
                $s_key_uname=[];
                if(isset($_REQUEST['s_key'])){
                    $s_key_name[]=[$this->table.".name","like","%".$_REQUEST['s_key']."%"];
                    $s_key_uname[]=[$this->table.".uname","like","%".$_REQUEST['s_key']."%"];
                }

                $query->orwhere($s_key_name)->orwhere($s_key_uname);
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
            }) ->where(function ($query) {
                $s_key_name=[];
                if(isset($_REQUEST['s_categoryid']) && $_REQUEST['s_categoryid']!=''){
                    $s_key_name[]=[$this->table.".channel","=",$_REQUEST['s_categoryid']];
                }

                $query->where($s_key_name);
            })
            ->orderBy($this->table.".id","desc")
            ->paginate($pagesize);

        $couponschannel= config("coupons.channel");
        $grantstatus= config("coupons.grantstatus");



        if($request->ajax()){
            if($list){
                foreach($list as $item){
                    $item->channelName=isset($couponschannel[$item->channel])?$couponschannel[$item->channel]:'推送';
                    $item->statusName=isset($grantstatus[$item->status])?$grantstatus[$item->status]:'未使用';
                }
                return ["status"=>0,"list"=>$list,"pagesize"=>$pagesize];
            }
        }else{
            return $this->ShowTemplate(["list"=>$list,"pagesize"=>$pagesize]);
        }

    }

    public function store(Request $request){



    }






    public function update(Request $request)
    {


    }



    public function delete(Request $request){


        if($request->ajax()) {

            if(count($request->input("ids"))>0){



                $delete = DB::table($this->table)->whereIn('id', $request->input("ids"))->delete();
                if ($delete) {

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

            return redirect(route($this->RouteController.'.grant',["msg"=>"群发成功"]));

        }else if($request->isMethod("post")){


            if(\App\Couponsgrant::PushCoupon($request->input('cid'),$request->input('uid'),1)){
                return ["status"=>0,"msg"=>"发放成功"];
            }else{
                return ["status"=>1,"msg"=>"发放失败"];
            }

        }
    }


}
