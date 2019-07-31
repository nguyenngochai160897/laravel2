<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCloneJobTopdevTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clone_job_topdev', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("position_name")->collation('utf8mb4_unicode_ci')->nullable();
            $table->string("slug")->collation('utf8mb4_unicode_ci')->nullable();
            $table->integer("quantity")->default("0");
            $table->integer("job_rank_id")->nullable();
            $table->text("job_description")->collation('utf8mb4_unicode_ci')->nullable();
            $table->smallInteger("job_level")->nullable();
            $table->string("experience", 5)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string("working_conditions")->collation('utf8mb4_unicode_ci')->nullable();
            $table->text("requirement_must")->collation('utf8mb4_unicode_ci')->nullable();
            $table->text("requirement_want")->collation('utf8mb4_unicode_ci')->nullable();
            $table->text("businesses_expect")->collation('utf8mb4_unicode_ci')->nullable();
            $table->json("work_location")->nullable();
            $table->json("job_types")->nullable();
            $table->json("industry")->nullable();
            $table->json("skill")->nullable();
            $table->json("salary")->nullable();
            $table->text("company_profile")->collation('utf8mb4_unicode_ci')->nullable();
            $table->smallInteger("interview_type")->nullable();
            $table->tinyInteger("is_private")->nullable();
            $table->json("target_age")->nullable();
            $table->tinyInteger("display_target_age")->nullable();
            $table->smallInteger("status")->nullable();
            $table->date("expired_date")->nullable();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clone_job_topdev');
    }
}
