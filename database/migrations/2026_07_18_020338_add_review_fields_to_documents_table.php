<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {

            // Administrator who reviewed the document
            $table->foreignId('reviewed_by')
                ->nullable()
                ->after('submitted_by')
                ->constrained('users')
                ->nullOnDelete();

            // Date reviewed
            $table->timestamp('reviewed_at')
                ->nullable()
                ->after('reviewed_by');

            // Administrator remarks
            $table->text('remarks')
                ->nullable()
                ->after('reviewed_at');

            // Receiving office after approval
            $table->foreignId('receiver_office_id')
                ->nullable()
                ->after('office_id')
                ->constrained('offices')
                ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {

            $table->dropForeign(['reviewed_by']);
            $table->dropForeign(['receiver_office_id']);

            $table->dropColumn([
                'reviewed_by',
                'reviewed_at',
                'remarks',
                'receiver_office_id',
            ]);

        });
    }
};