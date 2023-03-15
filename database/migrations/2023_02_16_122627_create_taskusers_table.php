<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taskusers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uid')->nullable();
            $table->foreign('uid')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('tid')->nullable();
            $table->foreign('tid')->references('id')->on('tasks')->onDelete('cascade');
            $table->boolean('status');
            $table->unsignedBigInteger('invoice_id');
            $table->boolean('payment');
            $table->json('files');
            $table->string('link')->nullable();
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
        Schema::dropIfExists('taskusers');
    }
};
