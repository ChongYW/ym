<?php

namespace App\Http\Controllers\Pc;
use App\Article;
use App\Auth;
use App\Category;
use App\Channel;
use App\Member;
use App\Order;
use App\Product;
use App\Productbuy;
use App\Seal;
use Carbon\Carbon;
use DB;
use App\Admin;
use App\Club;
use App\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;
use Session;
use App\Ad;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class IndexController extends BaseController
{

    public $cachetime=60;
    public function __construct(Request $request)
    {

        parent::__construct($request);
        /**网站缓存功能生成**/

       


    }
	public static function getClientIp()
	{
	    if (getenv('HTTP_CLIENT_IP')) {
	        $ip = getenv('HTTP_CLIENT_IP');
	    }
	    if (getenv('HTTP_X_REAL_IP')) {
	        $ip = getenv('HTTP_X_REAL_IP');
	    } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
	        $ip = getenv('HTTP_X_FORWARDED_FOR');
	        $ips = explode(',', $ip);
	        $ip = $ips[0];
	    } elseif (getenv('REMOTE_ADDR')) {
	        $ip = getenv('REMOTE_ADDR');
	    } else {
	        $ip = '0.0.0.0';
	    }
	 
	    return $ip;
	}
	

    /**电脑端首页**/
    public function index(Request $request){

		
       $Article[0]= Article::where("category_name","理财要闻")
            ->where("status","2")
            ->limit(8)
            ->orderBy("top_status","desc")
            ->orderBy("sort","desc")
            ->get();

        $Article[1]=Article::where("category_name","新闻资讯")
            ->where("status","2")
            ->limit(8)
            ->orderBy("top_status","desc")
            ->orderBy("sort","desc")
            ->get();

        $Article[2]=Article::where("category_name","影视资讯")
            ->where("status","2")
            ->limit(8)
            //->orderBy("top_status","desc")
            ->orderBy("created_at","desc")
            ->get();
        $top =[];
        $topMobile=\App\Member::RandomMobile(7);
        //$top =DB::select('SELECT  userid, SUM(amount) AS amounts FROM productbuy GROUP BY userid ORDER BY amounts desc limit 7');
        $tmp=[];
        for($i = 0; $i < count($topMobile); $i++) {
            $tmp[] = mt_rand(1000000,99999999);

        }
        rsort($tmp);


        foreach ($topMobile as $k=>$item){
            $top[$k]=["mobile"=>$item,"amounts"=>$tmp[$k]];
        }

      // dd($top);


       // $BenefitData=  \App\Product::BenefitData(110);

        // dd($BenefitData);


      $CategoryThumb[2]=  Category::where("name","影视资讯")->whereRaw("FIND_IN_SET(?,templates)",Cache::get("PcTemplate"))->value("thumb_url");
        view()->share("CategoryThumb",$CategoryThumb);

      return  $this->PcShowTemplate("index",["ArticleList"=>$Article,"top"=>$top]);
    }


    /**商品**/
    public function products(Request $request)
    {


        $ProCategory= Category::where("model","products")->whereRaw("FIND_IN_SET(?,templates)",Cache::get("PcTemplate"))->where("isshow","1")->orderBy("sort","asc")->get();

        view()->share("ProCategory",$ProCategory);

        view()->share("request",$request);
        if($request->links!=''){
            $category = DB::table("category")->whereRaw("FIND_IN_SET(?,templates)",Cache::get("PcTemplate"))->where("model", "products")->where("links", $request->links)->first();
            if ($category) {
                view()->share("category", $category);
                view()->share("title", $category->name);


                $productsLists=  DB::table("products")
                    ->where("category_id", $category->id)
                    ->where("status", "1")
                    ->orderBy("sort", "asc")
                    ->orderBy("created_at", "desc")
                    ->orderBy("tzzt", "asc")
                    ->orderBy("qtje", "asc")
                    ->get();
                view()->share("productsLists", $productsLists);
                return $this->PcShowTemplate("products");
            }
        }else{

            $productsLists=  DB::table("products")
                ->where("status", "1")
                ->orderBy("sort", "asc")
                ->orderBy("created_at", "desc")
                ->orderBy("tzzt", "asc")
                ->orderBy("qtje", "asc")
                ->get();
            view()->share("productsLists", $productsLists);
            return $this->PcShowTemplate("products");
        }



    }

    public function product(Request $request)
    {

        DB::table("products")->where("id",$request->id)->increment('click_count',1);

        if(Cache::has('wap.product.'.$request->id)){
            $product=Cache::get('wap.product.'.$request->id);
        }else{
            $product=DB::table("products")->where("id",$request->id)->first();

            $product->links= DB::table("category")->whereRaw("FIND_IN_SET(?,templates)",Cache::get("PcTemplate"))->where("id",$product->category_id)->value('links');
            $product->thumb_url= DB::table("category")->where("id",$product->category_id)->value('thumb_url');

            Cache::put('wap.product.'.$request->id,$product,$this->cachetime);
        }
        view()->share("title",$product->category_name.'-'.$product->title);
        view()->share("productview",$product);


        view()->share("productid",$request->id);

        $Memberamount=0;
        $UserId = $request->session()->get('UserId');
        if($UserId>0){
            $Member= Member::find($UserId);


            if(!$Member){
                return redirect()->route("wap.loginout");
            }
            $Memberamount=$Member->amount;

        }
        view()->share("Memberamount",$Memberamount);

        return $this->PcShowTemplate("product");

    }



    /**新闻**/


    public function articles(Request $request)
    {


        if($request->ajax()){

            $pagesize=10;
            $pagesize=Cache::get("pcpagesize");
            $where=[];

            if(Cache::has('wap.ArticlesList.'.$request->page.'.'.$request->links)){
                $articles=Cache::get('wap.ArticlesList.'.$request->page.'.'.$request->links);
            }else{

                if($request->links){
                    $category = DB::table("category")->whereRaw("FIND_IN_SET(?,templates)",Cache::get("PcTemplate"))->where("model", "articles")->where("links", $request->links)->first();
                    $where=["category_id"=> $category->id];
                }


                $articles = DB::table("articles")
                    ->where($where)
                    ->where("status", 2)
                    ->orderBy("sort","desc")
                    ->orderBy("id","desc")
                    ->paginate($pagesize);


                foreach($articles as $article){
                    $article->url=\route("article",["id"=>$article->id]);
                    $article->title=\App\Formatting::Format($article->title);
                    $article->descr=\App\Formatting::Format($article->descr);
                }

                Cache::put('wap.ArticlesList.'.$request->page.'.'.$request->links,$articles,$this->cachetime);
            }

            return ["status"=>0,"list"=>$articles,"pagesize"=>$pagesize];
        }else {
            //分类信息

            if($request->links) {
                $category = DB::table("category")->whereRaw("FIND_IN_SET(?,templates)",Cache::get("PcTemplate"))->where("model", "articles")->where("links", $request->links)->first();

                if ($category) {


                    view()->share("title", $category->name );
                    view()->share("category", $category);

                    return $this->PcShowTemplate("articles");

                }
            }else{

                /**所有文章**/




                view()->share("title",  '新闻资讯' );





                return $this->PcShowTemplate("articles");


            }
        }




    }

    public function article(Request $request)
    {

        DB::table("articles")->where("id",$request->id)->increment('click_count',1);

        if(Cache::has('wap.article.'.$request->id)){
            $article=Cache::get('wap.article.'.$request->id);
        }else{
            $article=DB::table("articles")->where("id",$request->id)->first();

            $article->links= DB::table("category")->whereRaw("FIND_IN_SET(?,templates)",Cache::get("PcTemplate"))->where("id",$article->category_id)->value('links');
            $article->thumb_url= DB::table("category")->where("id",$article->category_id)->value('thumb_url');

            Cache::put('wap.article.'.$request->id,$article,$this->cachetime);
        }
        view()->share("title",$article->title."-".$article->category_name);
        view()->share("article",$article);




        return $this->PcShowTemplate("article");


    }
	public function xxx(){
		dump(1);
		$m=\App\Member::GetPhoneTag_test(1);
		echo '<!--'.dump($m).'-->';
	}
    /**单页**/
    public function singlepages(Request $request)
    {



        view()->share("title",  '帮助说明');
echo '<!--'.$this->getClientIp().'-->';
		

        /**菜单导航栏**/
        if (Cache::has('wap.singlepagescategory')) {
            $articlescategory = Cache::get('wap.singlepagescategory');
        } else {
            $articlescategory = DB::table('category')->where("model", "singlepages")->orderBy("sort", "desc")->get();

            Cache::put('wap.singlepagescategory', $articlescategory, $this->cachetime);
        }
        view()->share("articlescategory", $articlescategory);
        /**菜单导航栏 END **/


        return $this->PcShowTemplate("singlepages");


    }

    public function singlepage(Request $request)
    {

        if($request->links){
            DB::table("category")->whereRaw("FIND_IN_SET(?,templates)",Cache::get("PcTemplate"))->where("links",$request->links)->increment('click_count',1);

            if(Cache::has('wap.singlepage.'.$request->links)){
                $singlepage=Cache::get('wap.singlepage.'.$request->links);
            }else{
                $singlepage=DB::table("category")->where("links",$request->links)->first();
                Cache::put('wap.singlepage.'.$request->links,$singlepage,$this->cachetime);
            }


        }else if($request->id){
            DB::table("category")->whereRaw("FIND_IN_SET(?,templates)",Cache::get("PcTemplate"))->where("id",$request->id)->increment('click_count',1);

            if(Cache::has('wap.singlepage.'.$request->id)){
                $singlepage=Cache::get('wap.singlepage.'.$request->id);
            }else{
                $singlepage=DB::table("category")->where("id",$request->id)->first();
                Cache::put('wap.singlepage.'.$request->id,$singlepage,$this->cachetime);
            }


        }


        view()->share("title",$singlepage->name);
        view()->share("article",$singlepage);
        return $this->PcShowTemplate("singlepage");

    }


    /** 在线留言 **/
    public function SendMsg(Request $request)
    {

        $Post= $request->all();


        $data=[];
        if($Post['Type']=='QQ'){
            $data['msg']=$Post['Type'].'-'.$Post['InquiryType'];
            $data['qq']=$Post['TxtValue'];

        }else if($Post['Type']=='手机'){
            $data['msg']=$Post['Type'].'-'.$Post['InquiryType'];
            $data['phone']=$Post['TxtValue'];
        }else if($Post['Type']=='Tel'){
            $data['msg']=$Post['Type'].'-'.$Post['InquiryType'];
            $data['phone']=$Post['TxtValue'];
        }
        $data['tip']=$request->Tip."-".$request->productname;
        $data['pid']=$request->ProductID;
        $data['wx']=$request->WebChart;
        $data['name']=$request->Name;
        $data['sex']=$request->sex;
        $data['adddate']=Carbon::now();

        $msg=  DB::table("onlinemsg")->insert($data);

        return response()->json([
            "msg"=>"请求成功",
            "status"=>0
        ]);

    }



    public function appdown(Request $request){
        $app="Android";
        $links="Android.apk";

        if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
            $app="IOS";
            $links="IOS.ipa";
        }else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
            $app="Android";
            $links="Android.apk";
        }


        view()->share("app",$app);
        view()->share("links",$links);


        return $this->PcShowTemplate("appdown");
    }

    public function buylist(Request $request){

        if(Cache::has('wap.product.'.$request->id)){
            $product=Cache::get('wap.product.'.$request->id);
        }else{
            $product=DB::table("products")->where("id",$request->id)->first();

            $product->links= DB::table("category")->where("id",$product->category_id)->value('links');
            $product->thumb_url= DB::table("category")->where("id",$product->category_id)->value('thumb_url');

            Cache::put('wap.product.'.$request->id,$product,$this->cachetime);
        }
        view()->share("title",$product->category_name.'-'.$product->title);
        view()->share("productview",$product);

        $productbuys= Productbuy::where("productid",$request->id)->limit(10)->get();
        if(count($productbuys)==0){
            $productbuys= Productbuy::limit(10)->get();
        }

        view()->share("productbuys",$productbuys);

        return $this->PcShowTemplate("buylist");
    }


    public function calculation(Request $request){

        return $this->PcShowTemplate("calculation");
    }


    public function Seal(Request $request){

        $bljg=  Product::where("id",$request->id)->value("bljg");

        if($bljg==''){
            $bljg=Cache::get("CompanyLong");
        }

      $SealTextLeng=  mb_strlen($bljg);

        $seal = new Seal($bljg,100,5,50,0,0,15,0,$SealTextLeng+5);
        $seal->doImg();
    }

    public function CompanySeal(Request $request){

        $bljg=Cache::get("CompanyLong");
        $SealTextLeng=  mb_strlen($bljg);
        $seal = new Seal($bljg,100,5,50,0,-6,14,0,$SealTextLeng+10);
        $seal->doImg();
    }



}


?>
