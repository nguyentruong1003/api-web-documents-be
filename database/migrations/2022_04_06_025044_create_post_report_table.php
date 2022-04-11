<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_report', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('post_id')->nullable()->comment('Map voi posts')->constrained('posts');
            $table->foreignId('user_id')->nullable()->comment('Map voi users')->constrained('users');
            $table->string('description')->nullable();
            $table->tinyInteger('resolve')->default(1)->comment('1 => open, 2 => close');
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
        Schema::dropIfExists('post_report');
    }
}
