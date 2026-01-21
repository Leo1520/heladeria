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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('estado', ['pendiente', 'en_preparacion', 'entregado', 'cancelado'])->default('pendiente');
            $table->decimal('total', 10, 2);
            $table->text('direccion_entrega');
            $table->string('referencia_direccion')->nullable();
            $table->string('telefono_contacto', 20);
            $table->text('notas')->nullable()->comment('Notas o instrucciones especiales del cliente');
            $table->timestamp('fecha_entrega')->nullable();
            $table->string('metodo_pago', 50)->default('efectivo')->comment('efectivo, transferencia, tarjeta');
            $table->timestamps();
            $table->softDeletes();
            
            // Índices para consultas frecuentes
            $table->index('user_id');
            $table->index('estado');
            $table->index(['estado', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
