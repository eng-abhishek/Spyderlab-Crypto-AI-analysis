<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogRelatedTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_related_tags', function (Blueprint $table) {

         $table->id();
            // $table->foreignId('blog_id')->constrained('posts');
            // $table->foreignId('tag_id')->constrained('blog_tags');
            $table->unsignedBigInteger('post_id');
            $table->foreign('post_id')->references('id')->on('posts');
            $table->unsignedBigInteger('blog_tag_id');
            $table->foreign('blog_tag_id')->references('id')->on('blog_tags');
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
        Schema::dropIfExists('blog_related_tags');
    }
}
