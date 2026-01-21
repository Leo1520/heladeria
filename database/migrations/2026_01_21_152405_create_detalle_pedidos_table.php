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
        Schema::create('detalle_pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->onDelete('cascade');
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2)->comment('Precio al momento de la compra');
            $table->decimal('subtotal', 10, 2);
            $table->text('notas_producto')->nullable()->comment('Ej: Sin azúcar, extra cremoso');
            $table->timestamps();
            
            // Índices para joins frecuentes
            $table->index('pedido_id');
            $table->index('producto_id');
            
            // Índice compuesto para reportes
            $table->index(['pedido_id', 'producto_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_pedidos');
    }
};
