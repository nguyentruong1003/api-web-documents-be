<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToPostTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('post_type', function (Blueprint $table) {
            //
            $table->bigInteger('parent_id')->after('name')->nullable()->comment('Danh muc cha neu co');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_type', function (Blueprint $table) {
            //
            $table->dropColumn('parent_id');
        });
    }
}
