<?php

namespace App\Http\Controllers\Api;

use App\Goods_cate;
use App\Goods_model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsCateController extends Controller
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
        //
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
    public function update(Request $request, $id)
    {
        //
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

    public function getAllCates()
    {
        $data = Goods_cate::select('id','gcate_name')->orderBy('id','asc')->get();
        if($data == '[]'){
            return successResponseData(404,'清先添加商品分类！');
        }else{
            return successResponseData(200,$data);
        }
    }

    public function updateCates()
    {
        $data = trim(request('cate'));
        $id = request('id');
        if($data == null || $id ==null){
            return successResponseData(404,'请填写类名！');
        }
        $res = Goods_cate::where('id',$id)->update(['gcate_name' => $data]);
        if($res == 1){
            return successResponseData(200,$data);
        }
    }

    public function delCates()
    {
        $id = request('id');
        $res = Goods_cate::destroy($id);
        $ress = Goods_model::where('goods_cates_id',$id)->delete();
        if($res != 0 && $ress != 0){
            return successResponseData(200,'删除成功！');
        }
    }

    public function addCates()
    {
        $cate = trim(request('cate'));
        if($cate == null){
            return successResponseData(404,'请填写类名！');
        }
        $res = Goods_cate::create(['gcate_name' => $cate]);
        if($res){
            return successResponseData(200,'添加成功！');
        }else{
            return successResponseData(404,'添加失败！');
        }
    }
}
