<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * uploader can be guest -> nullable
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('error');
            $table->string('path')->default('error');

            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // TODO person verknüpfen
            $table->integer('person_id')->unsigned()->nullable();
            // $table->foreign('person_id')
            //     ->references('id')
            //     ->on('people')
            //     ->onDelete('cascade')
            //     ->onUpdate('cascade');

            $table->timestamp('upload_time', 0)->nullable();
            $table->timestamp('update_time', 0)->nullable();
            $table->softDeletes('remove_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('images', function (Blueprint $table) {
            if (Schema::hasColumns('images', ['name', 'path', 'person_id', 'user_id'])) {
                $table->dropColumn('name');
                $table->dropColumn('path');
                $table->dropColumn('person_id');
                $table->dropColumn('user_id');
            }
            $table->dropSoftDeletes();
        }));
        Schema::dropIfExists('images');
    }
};
