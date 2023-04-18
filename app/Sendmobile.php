<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Cache;
use Session;
session_start();

class Sendmobile extends Model
{
    protected $table="sendmobile";
    protected $primaryKey="id";
    public $timestamps=true;
    protected $guarded=[];
    protected $fillable = ['mobile','content','result','action','ip'];


    protected function SendUid($userid,$action,$amount=0){


        $Member=  Member::find($userid);

        if($Member) {

            $code=rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
            $content= \App\Smstmp::GetMsg(["type"=>$action,"username"=>$Member->username,"code"=>$code,"amount"=>$amount]);//rechargeok

            $mobile = \App\Member::DecryptPassWord($Member->mobile);
            $results = $this->sendMobile($mobile, $content);
            Cache::put("mobile.code.".$mobile,$code,600);//缓存短信验证码
            $Model = new Sendmobile();
            $Model->mobile = $Member->mobile;
            $Model->result = $results['status'] == 1 ? "发送成功" : "发送失败";
            //$Model->result = $results > 0 ? "发送成功" : "发送失败";
            $Model->content = $content;
            $Model->action = $action;
            $Model->ip = \Request::getClientIp();
            $Model->save();
            return ["status" => 0];
        }

    }

    protected function SendUContent($userid,$content){


        $Member=  Member::find($userid);

        if($Member) {

            $code=rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
            //$content= \App\Smstmp::GetMsg(["type"=>$action,"username"=>$Member->username,"code"=>$code]);//rechargeok

            $mobile = \App\Member::DecryptPassWord($Member->mobile);
            $results = $this->sendMobile($mobile, $content);
            //Cache::put("mobile.code.".$mobile,$code,600);//缓存短信验证码
            $Model = new Sendmobile();
            $Model->mobile = $Member->mobile;
            $Model->result = $results['status'] == 1 ? "发送成功" : "发送失败";
            //$Model->result = $results > 0 ? "发送成功" : "发送失败";
            $Model->content = $content;
            $Model->action = '';
            $Model->ip = \Request::getClientIp();
            $Model->save();
            return ["status" => 0];
        }

    }

    protected function SendPhone($mobile,$action,$code){
        $unsend = array(10,11,12);//177
		$chkmstr = substr($mobile,0,2);
		if(in_array(intval($chkmstr),$unsend)){
			return ["msg" => '暂不支持该手机段号',"status" => 1];
		}
		$time = time() - Session::get('codetime_' . $mobile);
		if ($time < 60) {
			return ["msg" => '请勿频繁发送',"status" => 1];
		}
           if($code==''){
              $code=rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
           }

            Cache::put("mobile.code.".$mobile,$code,600);//缓存短信验证码

            $content= \App\Smstmp::GetMsg(["type"=>$action,"code"=>$code]);
//dump($content);die;
            $result5 = $this->sendMobile($mobile, $content);

            $Model = new Sendmobile();
            $Model->mobile = \App\Member::EncryptPassWord($mobile);
            if($result5 == 1){
                $results['status'] = 1;
                $Model->result =$results['msg'] = '发送成功';
            }else{
                $results['status'] = 0;
                $Model->result = $results['msg'] = '发送失败';
            }
            

            //$Model->result = $results['error'] == 0 ? "发送成功" : "发送失败";
            //dump($results);die;
            // if($results['status']){
            //     return $results;
            // }
            
            //$Model->result = $results['status'] == 1 ? "发送成功" : "发送失败";
            $Model->content = $content;
            $Model->action = $action;
            $Model->ip = \Request::getClientIp();
            $Model->save();
            return $results;
            //return ["status" => 0];


    }


    //发送短信接口
    function sendMobile_old($PHONE,$CONTENT){

        return  $this->Luosimao($PHONE,$CONTENT);

    }
    
    //发送短信接口
    function sendMobile_96xun($mobile,$content){
        
        $content = '【xxx】'.$content;
        $qidian_config	= array(
            'api_send_url'			=> 'http://open.96xun.com/Api/SendSms',
            'api_balance_query_url'	=> 'http://open.96xun.com/Api/UserDetail',
            'api_account'			=> '676755908',//$username
            'api_password'			=> md5('123456')//md5($password)
        );

        $postArr = array (
            'Uname'     => $qidian_config['api_account'],
            'Upass'     => $qidian_config['api_password'],
            'Mobile'    => $mobile,
            'Content'   => $content
        );
        $result = $this->curlPost($qidian_config['api_send_url'], $postArr);
        
        $res = json_decode($result,true);
        $res['status'] = $res['Status'];
        if($res['status']){
            Session::put('codetime_' . $mobile, time());
        }
        //dump($res);die;
        return ["msg" => '短信验证码发送成功',"status" => 1];
        //return $res;

    }

    private function curlPost($url, $postFields)
    {
        $postFields = http_build_query($postFields);
        $ch         = curl_init ();

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }


    //发送短信接口
    function sendMobile($PHONE,$CONTENT){

        $appid= Cache::get('smsappid');
        $pwd= Cache::get('smspass');

        $uid = "";
        $url='http://utf8.sms.webchinese.cn/?Uid='.$appid.'&Key='.$pwd.'&smsMob='.$PHONE.'&smsText='.urlencode($CONTENT);
        return $result=$this->WebChineseSms($url);//网建短信


    }


    function Luosimao($PHONE,$CONTENT){

        //https://my.luosimao.com/
        $appid= Cache::get('smsappid');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://sms-api.luosimao.com/v1/send.json");

        curl_setopt($ch, CURLOPT_HTTP_VERSION  , CURL_HTTP_VERSION_1_0 );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 8);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPAUTH , CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD  , 'api:key-'.$appid);

        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('mobile' => $PHONE,'message' => $CONTENT));

        $res = curl_exec( $ch );
        curl_close( $ch );
        //$res  = curl_error( $ch );
       return json_decode($res,true);

    }


    //网建短信API
    function WebChineseSms($url)
    {
        $ch = curl_init();
        /** curl_init()需要php_curl.dll扩展 **/
        $timeout = 5;
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $file_contents = curl_exec($ch);
        curl_close($ch);
        return $file_contents;
    }
}
