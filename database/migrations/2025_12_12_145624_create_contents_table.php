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
    {Schema::create('contents', function (Blueprint $table) {
    $table->id();

    $table->string('type')->nullable();

    $table->unsignedBigInteger('parent_id')->nullable();
    $table->foreign('parent_id')
          ->references('id')
          ->on('contents')
          ->onDelete('cascade');

    $table->string('name')->nullable();
    $table->string('title')->nullable();

    $table->longText('body')->nullable();
    $table->longText('body_2')->nullable();
    $table->longText('body_3')->nullable();
    $table->longText('body_4')->nullable();

    $table->string('meta_title')->nullable();
    $table->longText('meta_description')->nullable();
    $table->string('meta_keywords')->nullable();

    $table->text('img_path')->nullable();          // single image
    $table->json('img_paths')->nullable();         // multiple images (JSON)
    $table->text('video_path')->nullable();          // single video
    $table->json('video_paths')->nullable();         // multiple videos (JSON)

    $table->string('url')->nullable();

    $table->dateTime('start_date')->nullable();
    $table->dateTime('end_date')->nullable();

    $table->text('short')->nullable();              // short description
    $table->text('location')->nullable();

    $table->json('extra')->nullable();              // extra data (JSON)

    $table->tinyInteger('status')->default(0);      // 0 = inactive, 1 = active

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
