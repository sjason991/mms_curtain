<?php

namespace App\Http\Controllers\Api;

use App\Goods_model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GoodsModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $cate_id = request('cate_id');
        $model = trim(request('model'));
        $price = trim(request('price'));
        if($cate_id == '' || $model == '' || $price == ''){
            return successResponseData(404,'请把数据填写完整！');
        }
        if(!is_numeric($price)){
            return successResponseData(404,'请填写正确数据类型！');
        }
        $res = Goods_model::create(['gmodel_name'=>$model, 'gmodel_price'=>$price, 'goods_cates_id'=>$cate_id]);
        if($res){
            return successResponseData(200,'添加成功！');
        }else{
            return successResponseData(404,'添加失败！');
        }
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $model_id = request('id');
        $model = trim(request('model'));
        $price = trim(request('price'));
        if($model_id == '' || $model == '' || $price == ''){
            return successResponseData(404,'请把数据填写完整！');
        }
        if(!is_numeric($price)){
            return successResponseData(404,'请填写正确数据类型！');
        }
        $data = Goods_model::where('id',$model_id)->update(['gmodel_name'=>$model,'gmodel_price'=>$price]);
        if($data == 1){
            $res = [$model,$price];
            return successResponseData(200,$res);
        }else{
            return successResponseData(404,'数据修改失败！');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model_id = \request('id');
        $res = Goods_model::destroy($model_id);
        if ($res == 1){
            return successResponseData(200,'删除成功！');
        }else{
            return successResponseData(404,'删除失败！');
        }
    }

    public function modellist()
    {
        $cate_id = \request('id');
        $data = DB::table('goods_models as gm')->leftJoin('goods_cates as gc','goods_cates_id','=','gc.id')->select('gm.id','gmodel_name','gmodel_price','gcate_name')->where('goods_cates_id',$cate_id)->orderBy('id','asc')->get();
        if($data != '[]'){
            return successResponseData(200,$data);
        }
        return successResponseData(404,'该类别暂无型号！您可新增！');
    }
}
