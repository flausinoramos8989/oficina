<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['fixed', 'single'])->default('single');
            $table->decimal('amount', 10, 2);
            $table->integer('due_day')->nullable()->comment('Dia do vencimento para contas fixas');
            $table->date('due_date')->nullable()->comment('Data de vencimento para contas avulsas');
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending');
            $table->date('paid_at')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('bill_occurrences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_id')->constrained()->cascadeOnDelete();
            $table->date('due_date');
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending');
            $table->date('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bill_occurrences');
        Schema::dropIfExists('bills');
    }
};
