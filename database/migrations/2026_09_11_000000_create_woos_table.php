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
        Schema::create('woos', function (Blueprint $table) {
            $table->id()->primary();
            $table->unsignedInteger('post_id')->index();
            $table->bigInteger('parent_post_id')->nullable()->default(null);
            $table->string('name');
            $table->string('sku')->nullable()->default(null);
            $table->integer('stock')->nullable()->default(null);
            $table->float('price')->nullable()->default(null);
            $table->longText('tag')->nullable()->default(null);
            $table->longText('imgs')->nullable()->default(null);
            $table->longText('brand')->nullable()->default(null);
            $table->longText('varianti')->nullable()->default(null);
            $table->longText('descri_short')->nullable()->default(null);
            $table->longText('descri')->nullable()->default(null);
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('woos');
    }
};

