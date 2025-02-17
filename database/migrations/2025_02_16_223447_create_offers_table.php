<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cpf_query_id')->constrained()->onDelete('cascade');
            $table->foreignId('modality_id')->constrained()->onDelete('cascade');
            $table->decimal('interest_rate', 5, 4);
            $table->integer('min_installments');
            $table->integer('max_installments');
            $table->decimal('min_amount', 10, 2);
            $table->decimal('max_amount', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};