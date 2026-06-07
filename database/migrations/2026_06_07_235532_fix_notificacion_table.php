<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Eliminar la tabla actual (con la estructura incorrecta) y recrearla correctamente.
        // Se usa DROP + CREATE porque MySQL no permite cambiar fácilmente columnas FK.
        Schema::dropIfExists('notificacion');

        Schema::create('notificacion', function (Blueprint $table) {
            $table->id('id_notificacion');

            // Destinatario: solo UNO de estos tres tendrá valor (los demás serán null)
            $table->foreignId('id_cliente')
                  ->nullable()
                  ->constrained('cliente', 'id_cliente')
                  ->cascadeOnDelete();

            $table->foreignId('id_usuario')
                  ->nullable()
                  ->constrained('usuario', 'id_usuario')
                  ->cascadeOnDelete();

            $table->foreignId('id_tecnico')
                  ->nullable()
                  ->constrained('tecnico', 'id_tecnico')
                  ->cascadeOnDelete();

            // Ticket relacionado
            $table->foreignId('id_ticket')
                  ->constrained('ticket', 'id_ticket')
                  ->cascadeOnDelete();

            // Estado relacionado (opcional, para notificaciones de cambio de estado)
            $table->foreignId('id_estado')
                  ->nullable()
                  ->constrained('estado_ticket', 'id_estado')
                  ->nullOnDelete();

            // Tipo de notificación
            $table->string('tipo', 50)->default('nuevo_ticket');

            // Mensaje legible
            $table->string('mensaje');

            // Leído
            $table->boolean('leido')->default(false);

            $table->timestamps();

            // Índices para consultas frecuentes
            $table->index('id_cliente');
            $table->index('id_usuario');
            $table->index('id_tecnico');
            $table->index('leido');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificacion');

        Schema::create('notificacion', function (Blueprint $table) {
            $table->id('id_notificacion');
            $table->foreignId('id_cliente')
                  ->references('id_cliente')->on('cliente')
                  ->cascadeOnDelete();
            $table->foreignId('id_ticket')
                  ->references('id_ticket')->on('ticket')
                  ->cascadeOnDelete();
            $table->foreignId('id_estado')
                  ->nullable()
                  ->references('id_estado')->on('estado_ticket')
                  ->nullOnDelete();
            $table->string('mensaje');
            $table->boolean('leido')->default(false);
            $table->timestamps();
        });
    }
};
