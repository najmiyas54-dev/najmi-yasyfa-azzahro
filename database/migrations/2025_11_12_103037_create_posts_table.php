<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('image_path');
            $table->string('category');
            $table->enum('type', ['blog', 'destination', 'story', 'gallery']);
            $table->integer('comments_count')->default(0);
            $table->integer('views_count')->default(0);
            $table->string('location')->nullable();
            $table->date('posted_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
};