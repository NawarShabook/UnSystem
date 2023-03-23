<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_reqs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->string('firstName');
            $table->string('lastName');
            $table->string('fatherName');
            $table->string('motherName');
            $table->date('birthDay');
            $table->string('gender');
            $table->string('college');
            $table->string('section');
            $table->string('level');
            $table->string('city');
            $table->string('phoneNumber');
            $table->string('email');
            $table->string('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_reqs');
    }
};
