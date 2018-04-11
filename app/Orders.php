<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable=['buy_id','total_price','down_price','remark','status','address'];

    public function order_list()
    {
        return $this->hasMany('App\Order_list','ord_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','buy_id');
    }
}
