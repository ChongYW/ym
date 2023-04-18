<?php


namespace App\Http\Controllers\Admin;
    use App\Coupons;
    use App\Product;
    use App\Site;
    use Carbon\Carbon;
    use DB;
    use App\Category;
    use DemeterChain\C;
    use Illuminate\Http\Request;
    use Session;
    use Cache;


class ProductController extends BaseController
{

    private $table="products";


    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->Model=new Product();
        $modellist= config('model');
        view()->share("modellist",$modellist);
        $this->CategoryModel=new Category();
        $category_id=$request->s_categoryid;
        view()->share("tree_option",$this->CategoryModel->tree_option(0,0,$category_id,0,$this->table));

        if(\Illuminate\Support\Facades\Cache::has('memberlevel.list')){
            $memberlevel=Cache::get('memberlevel.list');
        }else{
            $memberlevel= DB::table("memberlevel")->orderBy("id","asc")->get();
            Cache::get('memberlevel.list',$memberlevel,Cache::get("cachetime"));
        }



        view()->share("memberlevel",$memberlevel);

        $Coupons=Coupons::where("status","1")->orderBy("sort","desc")->get();
        view()->share("Coupons",$Coupons);
    }



    public function index(Request $request){

        return redirect(route($this->RouteController.".lists"));

    }




    public function lists(Request $request){




        $pagesize=10;//默认分页数
        if(Cache::has('pagesize')){
            $pagesize=Cache::get('pagesize');
        }



        isset($_REQUEST['s_categoryid'])?$s_categoryid=$_REQUEST['s_categoryid']:$s_categoryid=0;
        isset($_REQUEST['s_key'])?$s_key=$_REQUEST['s_key']:$s_key='';



        $listDB = DB::table($this->table)
            ->select($this->table.'.*')
           ->where(function ($query) {
                $s_key_name=[];
                $s_key_bljg=[];
                $s_key_content=[];
                if(isset($_REQUEST['s_key'])){
                    $s_key_name[]=[$this->table.".title","like","%".$_REQUEST['s_key']."%"];
                    $s_key_bljg[]=[$this->table.".bljg","like","%".$_REQUEST['s_key']."%"];
                    $s_key_content[]=[$this->table.".content","like","%".$_REQUEST['s_key']."%"];
                }

                $query->orwhere($s_key_name)->orwhere($s_key_bljg)->orwhere($s_key_content);
            })
            ->where(function ($query) {
                $s_siteid=[];
                if(isset($_REQUEST['s_categoryid']) && $_REQUEST['s_categoryid']>0){
                    $s_siteid[]=[$this->table.".category_id","=",$_REQUEST['s_categoryid']];
                }

                $query->where($s_siteid);
            })->where(function ($query) {
                $s_status=[];
                if(isset($_REQUEST['s_status']) && $_REQUEST['s_status']>0){
                    $s_status[]=[$this->table.".tzzt","=",$_REQUEST['s_status']];
                }

                $query->where($s_status);
            });


            $list=$listDB->orderBy($this->table.".sort","asc")
                ->orderBy($this->table.".id","desc")
                ->paginate($pagesize);





        if($request->ajax()){
            if($list){
                $model=config('model');
                $modelname=[];
                return ["status"=>0,"list"=>$list,"pagesize"=>$pagesize];
            }
        }else{



            return $this->ShowTemplate(["list"=>$list,"pagesize"=>$pagesize]);
        }

    }

    public function store(Request $request){

        if($request->isMethod("post")){


            $data=$request->all();
            
            
            
        //    print_r($data);
        
        
        if(!isset($data['content'])){
            
         $data['content']='';   
            
            
        }
        
           
        if(!isset($data['coupon'])){
            
         $data['coupon']=[];   
            
            
        }
        
    //    echo count($data['coupon']);
        
    //    print_r($data);
       //     exit;
            //$photos=isset($data['productimage'])?json_encode($data['productimage']):'';
            //$data['photos']=$photos;
            unset($data['_token']);
            unset($data['thumb']);
            unset($data['file']);
            unset($data['productimage']);
            unset($data['editormd-image-file']);
            $xxtcbl= $data['xxtcbl'];
            unset($data['xxtcbl']);

            $data['xxtcbl']=json_encode($xxtcbl);


            $buydata= $data['buydata'];
            unset($data['buydata']);
            $data['buydata']=json_encode($buydata);

            $data['title']=\App\Formatting::ToFormat($data['title']);
            $data['content']=\App\Formatting::ToFormat($data['content']);

            $data['category_name']=$this->CategoryModel->where("id",$data['category_id'])->value('name');
            if(count($data['coupon'])){
                $data['coupon'] = implode(",",$data['coupon']);
            }else{
                $data['coupon'] = '';
            }

           // $data['created_at']= coupon
            $data['updated_at']=Carbon::now();

            if(isset($data['s'])){
                unset($data['s']);
            }

            if($data['isaouttm'] =='1' && $data['endingtime']==''){
                return response()->json([
                    "msg"=>"自动投满时间不可为空","status"=>1
                ]);
            }

            if($data['futoucishu'] <1){
                return response()->json([
                    "msg"=>"复投限制次数不可小于1","status"=>1
                ]);
            }


            if($data['xmjd']>=100){
                $data['tzzt']=1;
            }


            DB::table($this->table)->insert($data);


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


            $data=$request->all();
              if(!isset($data['content'])){
            
         $data['content']='';   
            
            
        }
        
           
        if(!isset($data['coupon'])){
            
         $data['coupon']=[];   
            
            
        }
            //$photos=isset($data['productimage'])?json_encode($data['productimage']):'';
            $id= $data['id'];
            $xxtcbl= $data['xxtcbl'];
            //$data['photos']=$photos;
            unset($data['_token']);
            unset($data['id']);
            unset($data['thumb']);
            unset($data['file']);
            unset($data['productimage']);
            unset($data['editormd-image-file']);
            unset($data['xxtcbl']);
            $data['xxtcbl']=json_encode($xxtcbl);

            $buydata= $data['buydata'];
            unset($data['buydata']);
            $data['buydata']=json_encode($buydata);

            $data['title']=\App\Formatting::ToFormat($data['title']);
            $data['content']=\App\Formatting::ToFormat($data['content']);

            if(count($data['coupon'])){
                $data['coupon'] = implode(",",$data['coupon']);
            }else{
                $data['coupon'] = '';
            }
            $data['category_name']=$this->CategoryModel->where("id",$data['category_id'])->value('name');
            $data['updated_at']=Carbon::now();
            if(isset($data['s'])){
                unset($data['s']);
            }

            if($data['xmjd']>=100){
                $data['tzzt']=1;
            }

            if($data['futoucishu'] <1){
                return response()->json([
                    "msg"=>"复投限制次数不可小于1","status"=>1
                ]);
            }

            if($data['isaouttm'] =='1' && $data['endingtime']==''){
                return response()->json([
                    "msg"=>"自动投满时间不可为空","status"=>1
                ]);
            }

            DB::table($this->table)->where("id",$id)->update($data);


            if($request->ajax()){
                return response()->json([
                    "msg"=>"修改成功","status"=>0
                ]);
            }else{
                return redirect(route($this->RouteController.'.update',["id"=>$request->input("id")]))->with(["msg"=>"修改成功","status"=>0]);
            }


        }else{


            $Model = $this->Model::find($request->get('id'));

            view()->share("tree_option",$this->CategoryModel->tree_option(0,0,$Model->category_id,0,$this->table));
            view()->share("photos",json_decode($Model->photos));
            $Model->xxtcbldata=json_decode($Model->xxtcbl,true);
            $Model->buydatas=json_decode($Model->buydata,true);

            return $this->ShowTemplate(["edit"=>$Model,"status"=>0]);
        }

    }

    public function settop(Request $request)
    {
        if($request->isMethod("post")){



            $Model = $this->Model::find($request->input('id'));

            if($request->input('status')!=''){
                $Model->status = $request->input('status');
            }

            if($request->input('top_status')!=''){
                $Model->issy = $request->input('top_status');
            }



            $Model->save();


            if($request->ajax()){
                return response()->json([
                    "msg"=>"操作成功","status"=>0
                ]);
            }


        }

    }



    public function delete(Request $request){

        //DELETE FROM `productbuy` WHERE `productbuy`.`productid` not in (SELECT id FROM `products`)
          if($request->ajax()) {
            if($request->input("id")){

                $member = DB::table($this->table)
                    ->where(['id' => $request->input("id")])
                    ->first();
                if($member){

                       $delete = DB::table($this->table)->where('id', '=', $request->input("id"))->delete();
                        if ($delete) {
                           // DB::table("productbuy")->where('productid', '=', $request->input("id"))->delete();
                            DB::select("DELETE FROM `productbuy` WHERE `productbuy`.`productid` not in (SELECT `id` FROM `products`)");
                            return ["status" => 0, "msg" => "删除成功"];
                        } else {
                            return ["status" => 1, "msg" => "删除失败"];
                        }


                }else{
                    return ["status"=>1,"msg"=>"您没有权限删除操作"];
                }


            }else if($request->input("ids")){

                $delete = DB::table($this->table)->whereIn('id',  $request->input("ids"))->delete();
                if ($delete) {
                    DB::select("DELETE FROM `productbuy` WHERE `productbuy`.`productid` not in (SELECT `id` FROM `products`)");
                    return ["status" => 0, "msg" => "删除成功"];
                } else {
                    return ["status" => 1, "msg" => "删除失败"];
                }
            }


        }else{
            return ["status"=>1,"msg"=>"非法操作"];
        }

    }



}
