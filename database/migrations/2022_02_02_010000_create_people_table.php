<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            /** 
             * Never touch the "ID" like
             * $table->foreignId('id')->constrained('users');
             * 
             **/
            $table->id();

            $table->integer('user_id')
                ->unsigned()
                ->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // $table->unsignedInteger('lang_id')->nullable();
            // $table->foreign('lang_id')
            //     ->references('id')
            //     ->on('langs')
            //     ->onDelete('cascade')
            //     ->onUpdate('cascade');

            $table->string('surname')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username')->nullable();
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
        Schema::dropIfExists('people');
    }
};
