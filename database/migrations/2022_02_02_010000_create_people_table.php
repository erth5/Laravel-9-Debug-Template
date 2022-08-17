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

            /** TODO
             * Du könntest auch das schreiben, dann wird der Typ automatisch gesetzt:
             * $table->foreignId('user_id')->constrained()->cascadeOnDelete();
             */
            $table->bigIncrements('id');

            $table->integer('user_id')
                ->unsigned()
                ->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('surname')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username')->nullable()->unique();
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
