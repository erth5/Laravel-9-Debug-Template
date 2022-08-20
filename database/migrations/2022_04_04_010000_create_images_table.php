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
            $table->bigIncrements('id');

            /** rel to images
             *  $table->bigInteger('image_id');
             *  foreign...
             */
            $table->string('path')->nullable();
            $table->string('name')->default('imageNameError');
            $table->string('extension')->nullable();

            $table->foreignId('person_id')->nullable()
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

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
