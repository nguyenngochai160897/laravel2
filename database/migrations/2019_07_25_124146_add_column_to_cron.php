<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToCron extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crons', function (Blueprint $table) {
            $table->string("resource");
            $table->string("name");
            $table->string("num_employees");
            $table->string("market");
            $table->string("address");
            $table->string("address_detail");
            $table->string("jobs");
            $table->string("salary");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crons', function (Blueprint $table) {
            //
        });
    }
}
