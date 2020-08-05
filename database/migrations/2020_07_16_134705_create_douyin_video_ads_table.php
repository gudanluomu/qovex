<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDouyinVideoAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('douyin_video_ads', function (Blueprint $table) {
            $table->engine = "MyIsam";

            $table->id();
            $table->string('aweme_id', 60)->index()->comment('视频id');
            $table->string('aweme_author_id', 60)->index()->comment('视频作者id');
            $table->string('pay_user_id', 60)->index()->comment('付款抖音号id');

            $table->integer('add_cart_clicks')->default(0)->comment('添加购物车点击');
            $table->integer('applet_click')->default(0)->comment('小程序点击');
            $table->integer('budget')->default(0)->comment('预算');
            $table->integer('business_tab_show')->default(0)->comment('业务标签显示');
            $table->integer('click_want_count')->default(0)->comment('点击想要');
            $table->integer('comments')->default(0)->comment('评论');
            $table->integer('consult_clicks')->default(0)->comment('咨询点击');
            $table->double('cost', 8, 2)->default(0)->comment('消耗');
            $table->integer('fans')->default(0)->comment('粉丝');
            $table->integer('go_shop_clicks')->default(0)->comment('商品点击');
            $table->integer('home_page_clicks')->default(0)->comment('主页');
            $table->integer('homepage_applet_click')->default(0)->comment('主页小程序');
            $table->integer('homepage_down_click')->default(0)->comment('主页');
            $table->integer('homepage_link_click')->default(0)->comment('主页链接');
            $table->integer('homepage_message_click')->default(0)->comment('主页消息');
            $table->integer('homepage_phone_click')->default(0)->comment('');
            $table->integer('likes')->default(0)->comment('喜欢');
            $table->integer('live_click')->default(0)->comment('实时点击');
            $table->integer('order_type')->default(0)->comment('');
            $table->integer('plays')->default(0)->comment('播放');
            $table->integer('poi_clicks')->default(0)->comment('点击');
            $table->integer('product_real_amount')->default(0)->comment('商品实际金额');
            $table->integer('product_real_orders')->default(0)->comment('商品实际订单');
            $table->integer('product_toal_amount')->default(0)->comment('商品总金额');
            $table->integer('product_total_orders')->default(0)->comment('商品总订单');
            $table->integer('serve_tab_click')->default(0)->comment('服务标签点击');
            $table->integer('shares')->default(0)->comment('分享');
            $table->integer('shop_visit_count')->default(0)->comment('店铺访问次数');
            $table->integer('shop_window_click')->default(0)->comment('橱窗点击');
            $table->integer('shopping_clicks')->default(0)->comment('购物车点击');
            $table->integer('vote_clicks')->default(0)->comment('投票点击');
            $table->unsignedInteger('num')->default(0)->comment('投放次数');
            $table->unsignedInteger('group_id')->nullable()->index()->comment('团队id');
            $table->unsignedInteger('user_id')->nullable()->index()->comment('视频当时运营人id');
            $table->unsignedInteger('department_id')->nullable()->index()->comment('视频当时部门id');
            $table->timestamps();

            $table->unique(['aweme_id', 'pay_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('douyin_video_ads');
    }
}
