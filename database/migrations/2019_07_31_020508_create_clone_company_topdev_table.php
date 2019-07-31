<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCloneCompanyTopdevTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clone_company_topdev', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name")->collation('utf8mb4_unicode_ci')->nullable();
            $table->string("logo")->collation('utf8mb4_unicode_ci')->nullable();
            $table->string("cover_image")->collation('utf8mb4_unicode_ci')->nullable();
            $table->string("tax_code", 45)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string("activity")->collation('utf8mb4_unicode_ci')->nullable();
            $table->string("address")->collation('utf8mb4_unicode_ci')->nullable();
            $table->string("phone_number")->collation('utf8mb4_unicode_ci')->nullable();
            $table->string("email", 64)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string("website")->collation('utf8mb4_unicode_ci')->nullable();
            $table->string("facebook")->collation('utf8mb4_unicode_ci')->nullable();
            $table->string("member_scale")->collation('utf8mb4_unicode_ci')->nullable();
            $table->text("reject_reason")->collation('utf8mb4_unicode_ci')->nullable();
            $table->tinyInteger("status")->collation('utf8mb4_unicode_ci')->nullable();
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
        Schema::dropIfExists('clone_company_topdev');
    }
}
