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
    {
        // 1. Add parent_id & slug to categories for Category Tree
        Schema::table('categories', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->after('id')->constrained('categories')->onDelete('cascade');
            $table->string('slug')->nullable()->after('name');
            $table->string('icon')->nullable()->after('slug');
        });

        // 2. Create Brands Table
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('logo')->nullable();
            $table->timestamps();
        });

        // 3. Enhance Products table
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('brand_id')->nullable()->after('category_id')->constrained('brands')->nullOnDelete();
            $table->string('color_code')->nullable()->after('color'); // hex color e.g. #000000
            $table->decimal('rating', 3, 2)->default(4.5)->after('price'); // 1.00 to 5.00
            $table->integer('reviews_count')->default(0)->after('rating');
            $table->integer('stock_quantity')->default(15)->after('reviews_count');
            $table->decimal('discount_percent', 5, 2)->default(0)->after('stock_quantity'); // e.g. 15 for 15%
            $table->decimal('original_price', 10, 2)->nullable()->after('discount_percent');
            $table->string('badge')->nullable()->after('original_price'); // 'best_seller', 'limited_deal', 'new_arrival'
            $table->string('image')->nullable()->after('badge');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['brand_id']);
            $table->dropColumn([
                'brand_id',
                'color_code',
                'rating',
                'reviews_count',
                'stock_quantity',
                'discount_percent',
                'original_price',
                'badge',
                'image',
            ]);
        });

        Schema::dropIfExists('brands');

        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['parent_id', 'slug', 'icon']);
        });
    }
};
