<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gmodel_name',20)->comment('型号规格');
            $table->decimal('gmodel_price', 10, 2)->nullable()->default(0.00)->comment('各型号单价');
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
        Schema::dropIfExists('goods_models');
    }
}
