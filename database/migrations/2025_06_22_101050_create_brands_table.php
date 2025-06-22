<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();

            $table->string('brand_name');
            $table->string('brand_image')->nullable(); 
            $table->char('country_code', 2);
            $table->foreign('country_code')
                  ->references('iso_alpha_2')
                  ->on('countries')
                  ->onDelete('restrict'); 
            $table->integer('rating')->default(0); 

            $table->foreignId('admin_id')
                  ->constrained('users') 
                  ->onDelete('cascade'); 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};