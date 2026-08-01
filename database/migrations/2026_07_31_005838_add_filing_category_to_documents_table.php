<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {

            $table->foreignId('filing_category_id')
                ->nullable()
                ->after('receiver_office_id')
                ->constrained('electronic_filing_categories')
                ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {

            $table->dropConstrainedForeignId('filing_category_id');

        });
    }
};