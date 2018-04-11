<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goods_model extends Model
{
    protected $fillable = ['gmodel_name','gmodel_price','goods_cates_id'];
    public function Goods_cate()
    {
        return $this->belongsTo('App\Goods_cate');
    }
}
