<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGurusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gurus', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('status')->comment('0 for inactive, 1 for active');
            $table->string('phoneNo');
            $table->string('age');
            $table->enum('gender', ['0', '1', '2'])->comment('0 for male, 1 for female, 2 for others');
            $table->string('location');
            $table->text('securityQuestion');
            $table->string('securityAnswer');
            $table->text('imgPath')->nullable();
            $table->integer('dialCode');
            $table->rememberToken();
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
        Schema::dropIfExists('gurus');
    }
}
