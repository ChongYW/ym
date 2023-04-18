<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupons extends Model
{
    /**优惠券**/
    protected $table="coupons";
    protected $primaryKey="id";
    public $timestamps=true;
    protected $guarded=[];
    protected $fillable = [
        'name',
        'expdata',
        'money',
        'type',
        'status',
        'sort',
        'remark'
    ];
}
