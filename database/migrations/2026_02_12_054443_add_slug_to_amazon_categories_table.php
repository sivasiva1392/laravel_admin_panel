<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AddSlugToAmazonCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('amazon_categories', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('category_name');
        });
        
        // Update existing records with unique slugs
        DB::table('amazon_categories')->get()->each(function ($category) {
            $slug = Str::slug($category->category_name);
            $originalSlug = $slug;
            $counter = 1;
            
            // Ensure slug is unique
            while (DB::table('amazon_categories')->where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            DB::table('amazon_categories')
                ->where('id', $category->id)
                ->update(['slug' => $slug]);
        });
        
        // Add unique constraint
        Schema::table('amazon_categories', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->change();
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('amazon_categories', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
