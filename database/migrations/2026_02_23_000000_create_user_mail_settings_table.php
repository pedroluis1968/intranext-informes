<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_mail_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->boolean('is_enabled')->default(false);

            $table->string('email_address')->nullable();

            // POP3 Settings
            $table->string('pop3_host')->nullable();
            $table->integer('pop3_port')->default(110);
            $table->string('pop3_username')->nullable();
            $table->text('pop3_password')->nullable(); // Guardado encriptado
            $table->string('pop3_encryption')->nullable(); // null, ssl, tls

            // SMTP Settings
            $table->string('smtp_host')->nullable();
            $table->integer('smtp_port')->default(587);
            $table->string('smtp_username')->nullable();
            $table->text('smtp_password')->nullable(); // Guardado encriptado
            $table->string('smtp_encryption')->nullable(); // null, ssl, tls

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_mail_settings');
    }
};
