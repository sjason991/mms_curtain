<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goods_cate extends Model
{
    protected $fillable = ['gcate_name'];

    public function Goods_model()
    {
        return $this->hasMany('App\Goods_model');
    }
}
