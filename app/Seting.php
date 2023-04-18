<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use DB;
class Seting extends Model
{
    protected $table = "setings";
    protected $primaryKey = "id";
    public $timestamps = true;
    protected $guarded = [];
    protected $fillable = ['name', 'value', 'valuelist', 'type', 'sort', 'keyname'];

    /**更新缓存和配置文件**/
        /**
          \App\Seting::PutConfig();
         **/
        protected function PutConfig(){

            Cache::flush();
            /**网站缓存配置文件**/
            $websetings_fileInfo='<?php



    return [
            ';
            $websetings_filename=  base_path()."/config/web.php";

            $setings=DB::table("setings")->get();

            if($setings){
                $seting_cachetime=DB::table("setings")->where("keyname","=","cachetime")->first();


                foreach($setings as $sv){

                    $websetings_fileInfo.='"'.$sv->keyname.'"=>"'.str_replace('"',"'",$sv->value).'",//'.$sv->name.'
                    ';
                }

            }

            $websetings_fileInfo.='

            ];';

            file_put_contents($websetings_filename,$websetings_fileInfo);
        }

}
