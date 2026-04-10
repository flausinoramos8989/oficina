<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->boolean('variable')->default(false)->after('due_day')
                  ->comment('Conta fixa com valor variável (ex: água, luz)');
        });

        Schema::table('bill_occurrences', function (Blueprint $table) {
            $table->string('receipt')->nullable()->after('paid_at')
                  ->comment('Comprovante de pagamento');
        });
    }

    public function down(): void
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->dropColumn('variable');
        });
        Schema::table('bill_occurrences', function (Blueprint $table) {
            $table->dropColumn('receipt');
        });
    }
};
