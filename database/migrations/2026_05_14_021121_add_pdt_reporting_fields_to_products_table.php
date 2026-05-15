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
        Schema::table('products', function (Blueprint $table) {
            $table->string('product_number')->nullable()->after('id'); //product number 
            $table->string('supplier')->nullable()->after('name'); // supplier
            $table->date('purchase_date')->nullable()->after('supplier'); //purchase date
            $table->decimal('price', 10, 2)->default(0)->after('purchase_date'); //price
        });
   }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
