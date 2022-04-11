<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('luu tru dia chi file');
            $table->string('url', 255)->nullable()->comment('luu tru dia chi file');
            $table->string('file_name', 255)->nullable()->comment('Ten file');
            $table->string('model_name')->nullable()->comment();
            $table->bigInteger('model_id')->nullable()->comment('map voi id bang');
            $table->string('size_file', 255)->nullable();
            $table->bigInteger('admin_id')->nullable()->comment('Nguoi tao');
            $table->softDeletes();
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
        Schema::dropIfExists('files');
    }
}
