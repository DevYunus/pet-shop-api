<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->uuid('category_uuid')->index();
            $table->uuid('uuid')->index();
            $table->string('title')->index();
            $table->float('price');
            $table->text('description');
            $table->json('metadata');
            $table->timestamps();

            $table->index(['category_uuid','uuid']);
            $table->index(['uuid','title']);
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
}
