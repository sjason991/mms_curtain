<?php

namespace App\Http\Controllers\api;

use App\Goods_cate;
use App\Goods_model;
use App\Order_list;
use App\Orders;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('orders as o')->leftJoin('users as u','u.id','=','buy_id')->select('o.id','name','phone','address','total_price','down_price','o.remark','status','o.created_at')->orderBy('o.updated_at','desc')->where('status','!=',0)->where('status','!=',6)->get();
        return successResponseData(200, $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $info = request('info');
        //UserInfo
        if(!preg_match("/^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$/",$info['phone'])){
            return successResponseData(404, '请输入正确的手机格式!');
        };
        $user = User::where(['phone' => $info['phone']])->first();
        if($user){
            $user1 = User::where('id',$user->id)->update(['name' => $info['name']]);
            if(!$user1){
                return successResponseData(404, '用户数据更新失败!');
            }
        }else{
            $user = User::create([
                'name'   => $info['name'],
                'password'  => bcrypt('123123'),
                'api_token' => str_random(64),
                'avatar' => '/public/avatar',
                'phone'      => $info['phone'],
            ]);
            if(!$user){
                return successResponseData(404, '用户数据存储失败!');
            }
            //分配权限
            $user->assignRole('用户');
        }

        //order
        $order = Orders::create([
            'buy_id' => $user->id,
            'address' => $info['address'],
            'total_price' => $info['tolprice'],
            'down_price' => 0,
            'remark' => $info['remark'],
        ]);
        if(!$order){
            return successResponseData(404, '订单数据存储失败!');
        }

        //order_list
        $array = $info['items'];
        foreach ($array as $v){
            if($v['status']==1){
                $order_list = Order_list::create([
                    'ord_id'=>$order->id,
                    'cate_id'=>$v['cate'],
                    'model_id'=>$v['model_value'],
                    'room_name'=>$v['room'],
                    'goods_num'=>$v['count'],
                    'goods_price'=>$v['price'],
                    'subtotal'=>$v['sum'],
                ]);
                if(!$order_list){
                    return successResponseData(404, '订单数据存储失败!');
                }
            }
        }

        return successResponseData(200, $order->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Orders::find($id)->user()->first();
        $order = Orders::where('id',$id)->first();
        $order_list = Order_list::where('ord_id',$id)->get();
        $data['user'] = $user;
        $data['order'] = $order;
        $data['order_list'] = $order_list;
        if(!$user || !$order || !$order_list){
            return successResponseData(404, 'Data is error!');
        }
        return successResponseData(200, $data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $info = request('info');
        //UserInfo
        if(!preg_match("/^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$/",$info['phone'])){
            return successResponseData(404, '请输入正确的手机格式!');
        };
        $u_id = Orders::find($id)->user()->select('id')->first()->id;
        $user = User::where(['phone' => $info['phone']])->first();
        if($user){
            if($user->id != $u_id){
                return successResponseData(404, '用户已注册，请修改手机号!');
            }
        }
        $userinfo = User::where('id',$u_id)->update(['name' => $info['name'],'phone' => $info['phone']]);
        if(!$userinfo){
            return successResponseData(404, '数据修改失败！');
        }
        $sta = Orders::select('status')->where('id',$id)->first()->status;
        if($sta==1){
            //order
            $order = Orders::where('id',$id)->update([
                'buy_id' => $u_id,
                'address' => $info['address'],
                'total_price' => $info['tolprice'],
                'down_price' => 0,
                'remark' => $info['remark'],
            ]);
            if(!$order){
                return successResponseData(404, '订单数据存储失败!');
            }

            //order_list
            $del = Order_list::where('ord_id',$id)->delete();
            $array = $info['items'];
            foreach ($array as $v){
                if($v['status']==1){
                    $order_list = Order_list::create([
                        'ord_id'=>$id,
                        'cate_id'=>$v['cate'],
                        'model_id'=>$v['model_value'],
                        'room_name'=>$v['room'],
                        'goods_num'=>$v['count'],
                        'goods_price'=>$v['price'],
                        'subtotal'=>$v['sum'],
                    ]);
                    if(!$order_list){
                        return successResponseData(404, '订单数据更新失败!');
                    }
                }
            }
        }

        $res['id'] = $id;
        $res['st'] = $sta;
        return successResponseData(200, $res);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function orderinfobybill()
    {
        $ord_id = \request('ord');
        $info = DB::table('orders as o')->leftJoin('users as u','u.id','=','buy_id')->select('name','phone','total_price','status')->where('o.id',$ord_id)->first();
        if(!$info){
            return successResponseData(404, '暂无数据！');
        }
        return successResponseData(200, $info);
    }

}
