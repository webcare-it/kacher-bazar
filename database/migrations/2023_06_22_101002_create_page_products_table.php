<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_products', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->unsignedBigInteger('cat_id')->nullable();
            $table->unsignedBigInteger('sub_cat_id')->nullable();
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->integer('qty')->nullable();
            $table->float('regular_price', 8, 2)->nullable();
            $table->float('discount_price', 8, 2)->nullable();
            $table->float('buy_price', 8, 2)->nullable();
            $table->float('inside_dhaka', 8, 2)->nullable();
            $table->float('outside_dhaka', 8, 2)->nullable();
            $table->string('sku')->unique()->nullable();
            $table->string('stock')->nullable();
            $table->text('short_description')->nullable();
            $table->text('long_description')->nullable();
            $table->float('vat_tax', 8, 2)->nullable();
            $table->string('image')->nullable();
            $table->string('product_type')->nullable();
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('page_products');
    }
}
