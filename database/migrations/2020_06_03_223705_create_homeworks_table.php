<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homeworks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->string('file')->nullable();

            $table->unsignedBigInteger('lesson_id')->nullable();
            $table->foreign('lesson_id')->references('id')->on('lessons')->onDelete('set null');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamp('deadline_at')->default(\Carbon\Carbon::now());

            $table->tinyInteger('status')->default(0);
            $table->integer('parent_id')->default(0)->nullable();
            $table->integer('lft')->unsigned()->nullable();
            $table->integer('rgt')->unsigned()->nullable();
            $table->integer('depth')->unsigned()->nullable();
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
        Schema::dropIfExists('homeworks');
    }
}
