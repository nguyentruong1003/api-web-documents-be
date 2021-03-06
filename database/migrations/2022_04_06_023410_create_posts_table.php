<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->comment('Tiêu đề');
            $table->string('description')->nullable()->comment('Mô tả');
            $table->longtext('content')->nullable()->comment('Nội dung');
            $table->foreignId('post_type_id')->nullable()->comment('Map voi post_type')->constrained('post_type')->onDelete('set null');
            $table->string('link_pdf')->nullable()->comment('File đính kèm');
            $table->tinyInteger('status')->default('1')->comment('Trạng thái: 1 = Public');
            $table->foreignId('user_id')->nullable()->comment('Người đăng')->constrained('users')->onDelete('set null');
            $table->timestamps();

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
        Schema::dropIfExists('posts');
    }
}
