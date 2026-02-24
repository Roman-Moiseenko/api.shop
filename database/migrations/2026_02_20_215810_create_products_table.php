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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('code')->unique();
            $table->string('code_search')->default('');


            $table->text('description')->nullable();
            $table->text('short')->nullable();

            //$table->unsignedBigInteger('main_photo_id')->nullable();

            $table->json('dimensions');
            $table->integer('frequency')->default(\App\Modules\Product\Entity\Product::FREQUENCY_NOT);


            $table->boolean('published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->decimal('current_rating',2, 1, true);
            $table->decimal('count_for_sell',10, 1, true);

            $table->string('sell_method');
            $table->string('barcode')->default('');
            $table->bigInteger('series_id')->nullable();
            $table->boolean('priority')->default(false);
            $table->boolean('not_sale')->default(false);
            $table->boolean('fractional')->default(false);

            $table->foreignId('main_category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null');
            $table->foreignId('measuring_id')->nullable()->constrained('guide_measuring')->onDelete('set null');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
