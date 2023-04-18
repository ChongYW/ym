<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Session\Session;
use Cache;
use DB;


class Paycode extends Model
{
    protected $table="paycode";
    protected $primaryKey="id";
    public $timestamps=true;
    protected $guarded=[];
    protected $fillable = [
        'pay_name',
        'pay_pid',
        'pay_pic',
        'pay_status',
        'pay_number'

        ];












}
