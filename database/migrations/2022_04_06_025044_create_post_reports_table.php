<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('post_id')->nullable()->comment('Map voi posts')->constrained('posts')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->comment('Map voi users')->constrained('users')->onDelete('set null');
            $table->longText('content')->nullable();
            $table->tinyInteger('resolve')->default(1)->comment('1 => open, 2 => close');
            $table->timestamps();
            $table->softDeletes();

            $table->string('unsign_text')->nullable()->comment('luu tim kiem khong dau');
            $table->index(['unsign_text']);
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
