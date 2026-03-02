<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('temp_products', function (Blueprint $table) {
            $table->bigIncrements('id_temp');
            $table->unsignedBigInteger('id_users')->nullable();
            $table->unsignedBigInteger('id_emprendimiento')->nullable();
            $table->unsignedBigInteger('id_producto')->nullable(); // referencia futura
            $table->string('nombreproducto');
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 10, 2)->default(0);
            $table->json('fotosproduct')->nullable();
            $table->string('estado')->default('pendiente');
            $table->timestamps();

            $table->foreign('id_users')->references('id')->on('users')->onDelete('set null');
            $table->foreign('id_emprendimiento')->references('id')->on('emprendimientos')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('temp_products');
    }
};
