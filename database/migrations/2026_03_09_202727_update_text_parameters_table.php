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
        Schema::table('text_parameters', function (Blueprint $table) {
            $table->json('type_is')->nullable();
            $table->dropColumn('is_category');
            $table->dropColumn('is_product');
            $table->dropColumn('is_group');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('text_parameters', function (Blueprint $table) {
            $table->dropColumn('type_is');
            $table->boolean('is_category')->default(true);
            $table->boolean('is_product')->default(false);
            $table->boolean('is_group')->default(false);
        });
    }
};
