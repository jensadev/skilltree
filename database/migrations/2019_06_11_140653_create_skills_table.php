<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('skilltree_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('icon', 30)->nullable();
            $table->string('course_id', 20)->nullable();
            $table->string('topic_id', 20)->nullable();
            $table->timestamps();

            //$table->index(['skilltree_id']); //, 'category_id']);
            $table->foreign('skilltree_id')->references('id')->on('skilltrees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skills');
    }
}
