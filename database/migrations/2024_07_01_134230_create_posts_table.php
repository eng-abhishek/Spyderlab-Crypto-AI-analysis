<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->id();
            $table->unsignedBigInteger('blog_category_id');
            $table->foreign('blog_category_id')->references('id')->on('blog_categories');
            $table->string('title');
            $table->string('slug');
            $table->longText('content');
            $table->enum('is_faq',['N','Y'])->default('N');
            $table->mediumText('faq')->nullable();
            $table->string('image');
            $table->string('image_alt', 100)->nullable();
            $table->string('image_title', 100)->nullable();
            $table->enum('status', ['Pending', 'Draft', 'Publish'])->default('Pending');
            $table->string('meta_title');
            $table->string('meta_description');
            $table->datetime('publish_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->datetime('deleted_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
