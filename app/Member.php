<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Session;
use Illuminate\Support\Facades\Crypt;

class Member extends Model
{
    protected $table="member";
    protected $primaryKey="id";
    public $timestamps=true;
    protected $guarded=[];
    protected $fillable = ['username','password','paypwd','mobile','email','logintime','lognum','state','inviter','ip','amount','yuamount','realname','level','address','qq','question','answer','ismobile','card','isquestion','isbank','bankname','bankrealname','bankcode','bankaddress','is_dongjie','invicode','picImg','reg_from','lastqiandao','mtype','remarks','sourcedomain'];
    protected $dates = ['created_at', 'updated_at'];
    protected $treeuid=[];
    protected $treelv=[];

    //加密密码串
    protected function EncryptPassWord($password){


        return Crypt::encrypt($password);


    }

    //解密密码串
    protected function DecryptPassWord($password){

	
       return Crypt::decrypt($password);
    }


    //替代*号
    protected  function half_replace($str){
        $len = strlen($str)/2;
        return substr_replace($str,str_repeat('*',4),3,4);
    }



    protected function treelv($invicode='',$lv=1)
    {



            $MemberD = Member::where('inviter', $invicode);
            $XiaXianMember = $MemberD->get();

            $arr = array();
            if (sizeof($XiaXianMember) != 0) {
                foreach ($XiaXianMember as $k => $datum) {
                    if($lv<20) {
                        $this->treelv($datum['invicode'], $lv + 1);
                    }
                    $this->treelv[$datum['id']] = $lv . "层下级";
                }
            }
            return $this->treelv;


    }

    protected function treeuid($invicode='',$lv=1)
    {

            $MemberD = Member::where('inviter', $invicode);
            $XiaXianMember = $MemberD->get();
            $arr = array();
            if (sizeof($XiaXianMember) != 0) {
                foreach ($XiaXianMember as $k => $datum) {
                    if($lv<3&&count($this->treeuid)<999) {
                        $this->treeuid($datum['invicode']);
                    }
                    $this->treeuid[] = $datum['id'];
                    
                 //   print_r( $this->treeuid);
                    
                }
            }
            return $this->treeuid;


    }

    protected function GetIpInfo($ip)
    {

        return $this->getIPLocation($ip);

    }

    protected function OnLineSet($Id)
    {

        Member::where('id', $Id)->update(["updated_at"=>Carbon::now()]);

    }

    protected function GetPhoneTag($Id)
    {
        $Membermobile=Member::where("id",$Id)->value("mobile");
		if($Membermobile){
			return \App\Member::half_replace(\App\Member::DecryptPassWord($Membermobile),'****',3,4);
		}else{
			return '****';
		}
		//return '<!--'.\App\Member::DecryptPassWord($Membermobile).' -->';
       //return \App\Member::half_replace(\App\Member::DecryptPassWord($Membermobile),'****',3,4);

    }
	protected function GetPhoneTag_test($Id)
	{
	    $Membermobile=Member::where("id",$Id)->value("mobile");
		return $Membermobile;
		//return '<!--'.\App\Member::DecryptPassWord($Membermobile).' -->';
	   //return \App\Member::half_replace(\App\Member::DecryptPassWord($Membermobile),'****',3,4);
	
	}
	

    protected function UserRegFrom($Id)
    {
        $UserRegFrom=Member::where("id",$Id)->value("reg_from");


        if($UserRegFrom=='wap/register'){
            return 'wap';
        }else{
            return 'pc';
        }



    }


    function getIPLocation($queryIP){
        $url = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$queryIP;

        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_ENCODING ,'gb2312');
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
        $result = curl_exec($ch);

        $ipdata=json_decode($result,true);
        curl_close($ch);

        if(isset($ipdata['code']) && isset($ipdata['data'])){

            return   $ipdata['data']['region'].$ipdata['data']['city'].$ipdata['data']['isp'];
        }else{
            return '';
        }

    }


    //随机生成n条手机号
    protected function RandomMobile($n)
    {
        $tel_arr = array(
            '130','131','132','133','134','135','136','137','138','139','144','147','150','151','152','153','155','156','157','158','159','176','177','178','180','181','182','183','184','185','186','187','188','189',
        );
        for($i = 0; $i < $n; $i++) {
            $tmp[] = $tel_arr[array_rand($tel_arr)].'****'.mt_rand(1000,9999);

        }
        return array_unique($tmp);
    }

    /** 真实姓名唯一 **/
    protected function RealNameOnly($RealName)
    {
        $RealNameCount=Member::where("realname",$RealName)->count();
        return $RealNameCount;
    }

    protected function IdCard($name,$idCard)
    {
        $host = "https://idcert.market.alicloudapi.com";
        $path = "/idcard";
        $method = "GET";
        $appcode = Cache::get('IdCardAppCode');
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $querys = "idCard=".$idCard."&name=".$name;
        $bodys = "";
        $url = $host . $path . "?" . $querys;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        //curl_setopt($curl, CURLOPT_HEADER, true); //如不输出json, 请打开这行代码，打印调试头部状态码。
        //状态码: 200 正常；400 URL无效；401 appCode错误； 403 次数用完； 500 API网管错误
        if (1 == strpos("$".$host, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        $out_put = curl_exec($curl);


        return $data= json_decode($out_put,true) ;

    }

    /****

{
"status": "01",                          *状态码:详见状态码说明 01 通过，02不通过  *
"msg": "实名认证通过！",                   *提示信息*
"idCard": "5111261995****1111",          *身份证号*
"name": "张三",                          *姓名*
"sex": "男",                             *性别*
"area": "四川省乐山市夹江县",                *身份证所在地(参考)*
"province": "四川省",                    *省*
"city": "乐山市",                        *市*
"prefecture": "夹江县",                  *区县*
"birthday": "1995-11-11",                *出生年月*
"addrCode": "511126",                    *地区代码*
"lastCode": "1"                          *身份证校验码*
}

     *
     *
{
"status": "02",                      /*状态码:详见状态码说明 01 通过，02不通过  *
"msg": "实名认证不通过！",              /*提示信息*
"idCard": "5107031976****0052",      /*身份证号*
"name": "张三",                       /*姓名*
"sex": "",                           /*实名认证不通过时以下都为空*
"area": "",
"province": "",
"city": "",
"prefecture": "",
"birthday": "",
"addrCode": "",
"lastCode": ""
}

****/



}
