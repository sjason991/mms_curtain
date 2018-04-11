<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('buy_id')->unsigned()->comment('购买人ID');
            $table->string('address')->comment('地址');
            $table->decimal('total_price', 10, 2)->nullable()->default(0.00)->comment('商品总价格');
            $table->decimal('down_price', 10, 2)->nullable()->default(0.00)->comment('商品定金');
            $table->string('remark')->nullable()->comment('备注');
            $table->tinyInteger('status')->default(1)->comment('订单状态 已取消0 未付款1 已收定金2 已全款3 已制作4 已安装未收尾款5 已完结6');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
