<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('phoneNo');
            $table->string('age');
            $table->enum('gender', ['0', '1', '2'])->comment('0 for male, 1 for female, 2 for others');
            $table->string('location');
            $table->text('securityQuestion');
            $table->string('securityAnswer');
            $table->text('imgPath');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
