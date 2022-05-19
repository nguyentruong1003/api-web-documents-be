<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnUnsignTextSearch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function (Blueprint $table) {
            $table->string('unsign_text', 1000)->nullable()->comment('luu tim kiem khong dau');
            $table->index(['unsign_text']);
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->string('unsign_text', 1000)->nullable()->comment('luu tim kiem khong dau');
            $table->index(['unsign_text']);
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->string('unsign_text', 1000)->nullable()->comment('luu tim kiem khong dau');
            $table->index(['unsign_text']);
        });

        Schema::table('post_report', function (Blueprint $table) {
            $table->string('unsign_text', 1000)->nullable()->comment('luu tim kiem khong dau');
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
        //
    }
}
