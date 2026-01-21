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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 10, 2);
            $table->string('imagen')->nullable()->comment('Ruta de la imagen del producto');
            $table->integer('stock')->default(0);
            $table->boolean('disponible')->default(true);
            $table->string('categoria', 50)->nullable()->comment('Ej: Cremosos, Frutales, Premium');
            $table->string('sabor', 100)->nullable();
            $table->string('tamano', 50)->nullable()->comment('Ej: 1L, 500ml, Individual');
            $table->timestamps();
            $table->softDeletes();
            
            // Índices para optimizar consultas
            $table->index('disponible');
            $table->index('categoria');
            $table->index(['disponible', 'stock']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
