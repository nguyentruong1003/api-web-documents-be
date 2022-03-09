<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_data', function (Blueprint $table) {
            $table->id(); 
            $table->string('v_key', 255)->nullable();
            $table->string('v_value')->nullable();
            $table->integer('order_number')->nullable();
            $table->tinyInteger('type');
            $table->bigInteger('parent_id')->nullable()->comment('Danh muc cha neu co');
            $table->longText('v_content', 1000)->nullable()->comment('Noi dung');
            $table->longText('note', 1000)->nullable()->comment('Ghi chu');
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
        Schema::dropIfExists('master_data');
    }
}
