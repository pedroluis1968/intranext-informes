<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('email_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('email_id');
            $table->string('filename');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->default(0);
            $table->string('path')->nullable(); // URL local o storage path
            $table->string('content_id')->nullable(); // Para imágenes inline
            $table->timestamps();

            $table->index('email_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_attachments');
    }
};
