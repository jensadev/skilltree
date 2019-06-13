<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkilltreeMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skilltree_members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('skilltree_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->index(['skilltree_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skilltree_members');
    }
}
