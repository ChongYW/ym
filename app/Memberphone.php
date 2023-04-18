<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cache;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Crypt;

class Memberphone extends Model
{


    //用户手机号查找UserName号
    protected function PhoneUserName($PHONE){


        $Members= Member::get();


        foreach($Members as $member){
            if(Crypt::decrypt($member->mobile)==$PHONE){
                return $member->username;
            }
        }

        return '';
    }


    protected function IsMobilePhone ($mobile_phone)

    {



        $chars = "/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|16[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|19[0-9]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$/";

        if(preg_match($chars, $mobile_phone))

        {

            return true;

        }



        return false;

    }


    //用户手机号是否注册
    protected function IsReg($PHONE){


        $Members= Member::get();
// dump($Members);die;

        foreach($Members as $member){
            if(Crypt::decrypt($member->mobile)==$PHONE){
                return true;
            }
        }

        return false;
    }

    //用户手机号是否注册
    protected function IsUpdate($PHONE,$Mid){


        $Members= Member::get();


        foreach($Members as $member){
            if(Crypt::decrypt($member->mobile)==$PHONE && $member->id!=$Mid){
                return true;
            }
        }


        return false;
    }


}
