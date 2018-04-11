<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ord_id')->unsigned()->comment('订单id');
            $table->string('cate_id')->nullable()->comment('商品id');
            $table->string('model_id')->nullable()->comment('型号id');
            $table->string('room_name')->nullable()->comment('房间名');
            $table->integer('goods_num')->default(0)->nullable()->comment('商品数量');
            $table->decimal('goods_price', 8, 2)->nullable()->default(0.00)->comment('商品单价');
            $table->decimal('subtotal', 8, 2)->nullable()->default(0.00)->comment('小计');
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
        Schema::dropIfExists('order_lists');
    }
}
