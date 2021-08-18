<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->text('pageUrl');
            $table->text('metaTitle');
            $table->text('metaDescription');
            $table->text('bannerHeading');
            $table->text('pageHeading');
            $table->text('pageContent');
            $table->text('bannerImage');
            $table->text('pageImage');
            $table->enum('status', [0, 1])->default('1');
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
        Schema::dropIfExists('pages');
    }
}
