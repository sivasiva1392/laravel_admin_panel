<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_category_id')->constrained()->onDelete('cascade');
            $table->foreignId('blog_sub_category_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('product_name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->string('image')->nullable();
            $table->string('image_url')->nullable();
            $table->string('link')->nullable();
            $table->string('affiliate_url')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('blog_products');
    }
}
