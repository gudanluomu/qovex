<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->string('promotion_id', 60)->index()->nullable();
            $table->string('product_id', 60)->index()->nullable();
            $table->string('title')->nullable();
            $table->integer('market_price')->default(0);
            $table->integer('price')->default(0);
            $table->text('detail_url')->nullable();
            $table->integer('sales')->default(0);
            $table->string('images')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->tinyInteger('promotion_source')->nullable();
            $table->integer('cos_fee')->default(0);
            $table->string('goods_source', 20)->nullable();
            $table->tinyInteger('goods_type')->index()->nullable()->comment('1小店2淘宝');
            $table->unsignedTinyInteger('rate_type')->default(1)->comment('1普通,2线下,3全投');
            $table->unsignedTinyInteger('custom_rate')->nullable()->comment('自定义佣金比例');
            $table->unsignedInteger('group_id')->nullable()->index()->comment('团队id');
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
        Schema::dropIfExists('products');
    }
}
