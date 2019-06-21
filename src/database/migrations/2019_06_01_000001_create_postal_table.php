<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostalTable extends Migration
{
    public function up()
    {
        Schema::create('postal', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_active')
                ->default(1);
            $table->string('name');
            $table->string('to');
            $table->string('to_name');
            $table->string('subject');
            $table->text('cc')
                ->nullable();
            $table->text('bcc')
                ->nullable();
            $table->string('slug', 150)
                ->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('postal');
    }
}
