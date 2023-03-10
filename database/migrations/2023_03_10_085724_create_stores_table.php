<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('store_name',100)->comment('商店名稱')->index('index_store_name');
            $table->string('store_phone',25)->comment('商店電話')->index('index_store_phone');
            $table->time('store_business_start_time')->nullable()->comment('起始營業時間');
            $table->time('store_business_end_time')->nullable()->comment('結束營業時間');
            $table->decimal('store_longitude',20,6)->comment('經度')->nullable();
            $table->decimal('store_latitude',20,6)->comment('緯度')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
}
