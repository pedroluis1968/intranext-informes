<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('emails_box', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // A quien pertenece este correo
            $table->string('message_id')->nullable(); // ID original del servidor
            $table->string('folder')->default('inbox'); // inbox, sent, trash, draft

            $table->string('from_email')->nullable();
            $table->string('from_name')->nullable();
            $table->text('to')->nullable(); // JSON o coma separados
            $table->text('cc')->nullable();
            $table->text('bcc')->nullable();

            $table->string('subject')->nullable();
            $table->longText('body_text')->nullable();
            $table->longText('body_html')->nullable();

            $table->boolean('is_read')->default(false);
            $table->boolean('is_starred')->default(false);
            $table->boolean('has_attachments')->default(false);

            $table->timestamp('received_at')->nullable(); // Fecha de envío original

            $table->timestamps();

            // Índices para búsquedas rápidas
            $table->index('user_id');
            $table->index('folder');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emails_box');
    }
};
