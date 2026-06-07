<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notificacion', function (Blueprint $table) {
            $table->foreignId('id_usuario')
                ->nullable()
                ->after('id_cliente')
                ->constrained('usuario', 'id_usuario')
                ->cascadeOnDelete();

            $table->foreignId('id_tecnico')
                ->nullable()
                ->after('id_usuario')
                ->constrained('tecnico', 'id_tecnico')
                ->cascadeOnDelete();

            $table->string('tipo', 30)->default('general')->after('id_estado');
        });
    }

    public function down(): void
    {
        Schema::table('notificacion', function (Blueprint $table) {
            $table->dropForeign(['id_usuario']);
            $table->dropForeign(['id_tecnico']);
            $table->dropColumn(['id_usuario', 'id_tecnico', 'tipo']);
        });
    }
};
