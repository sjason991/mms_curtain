<?php

namespace App\Http\Controllers\api;

use App\Orders;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PayController extends Controller
{

    public function pay()
    {
        $ord = \request('id');
        $down_price = \request('down_price');
        $total_price = \request('total_price');
        $payway = \request('payway');

        //全额 or 全额定金
        if($payway == 0 || $down_price == $total_price){
            $res = Orders::where('id',$ord)->update(['status'=>3]);
            if(!$res){
                return successResponseData(404,'支付失败!');
            }
            return successResponseData(200,'支付成功啦！');
        }

        //定金
        if($down_price > $total_price){
            return successResponseData(404,'定金大于金额了哦！');
        }

        if($down_price < $total_price){
            $res = Orders::where('id',$ord)->update(['status'=>2,'down_price'=>$down_price]);
            if(!$res){
                return successResponseData(404,'支付失败!');
            }
            return successResponseData(200,'定金支付成功！');
        }
    }
}
