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
        Schema::create('migrations', function (Blueprint $table) {
            $table->id(); // This will create an auto-incrementing primary key column
        
            // Define category_id column
            $table->unsignedBigInteger('category_id');
            // Define foreign key constraint for category_id
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        
            $table->string('material_name');
            // Define appropriate data type for opening_balance
            $table->decimal('opening_balance', 10, 2); // Example: decimal with precision 10 and scale 2
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('migrations');
    }
};
