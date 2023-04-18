<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Moneylog extends Model
{
    protected $table="moneylog";
    protected $primaryKey="id";
    public $timestamps=true;
    protected $guarded=[];
    protected $fillable = [
        'moneylog_userid',
        'moneylog_user',
        'moneylog_money',
        'moneylog_ip',
        'moneylog_status',
        'moneylog_type',
        'moneylog_notice',
        'moneylog_houamount',
        'moneylog_yuanamount'

    ];


    protected function AddLog($data){

        $Model = new Moneylog();
        $Model->moneylog_userid=$data['userid'];
        $Model->moneylog_user=$data['username'];
        $Model->moneylog_money=$data['money'];
        $Model->moneylog_ip=$data['ip'];
        $Model->moneylog_status=$data['status'];
        $Model->moneylog_type=$data['type'];
        $Model->moneylog_notice=$data['notice'];
        $Model->moneylog_yuanamount=$data['yuanamount'];
        $Model->moneylog_houamount=$data['houamount'];
        $Model->save();
        return ["status"=>0];

    }
}
