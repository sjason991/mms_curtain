<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_list extends Model
{
    protected $fillable=['ord_id','cate_id','model_id','room_name','goods_num','goods_price','subtotal'];

    public function order()
    {
        return $this->belongsTo('App\Order','ord_id');
    }
}
