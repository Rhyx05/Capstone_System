<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | New Columns
            |--------------------------------------------------------------------------
            */

            if (!Schema::hasColumn('documents', 'priority')) {
                $table->string('priority')->default('Normal')->after('category');
            }

            if (!Schema::hasColumn('documents', 'extracted_text')) {
                $table->longText('extracted_text')->nullable()->after('description');
            }

            if (!Schema::hasColumn('documents', 'receiver_office_id')) {
                $table->foreignId('receiver_office_id')
                    ->nullable()
                    ->constrained('offices')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('documents', 'assigned_to')) {
                $table->foreignId('assigned_to')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('documents', 'assigned_at')) {
                $table->timestamp('assigned_at')->nullable();
            }

            if (!Schema::hasColumn('documents', 'approved_by')) {
                $table->foreignId('approved_by')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('documents', 'approved_at')) {
                $table->timestamp('approved_at')->nullable();
            }

            if (!Schema::hasColumn('documents', 'reviewed_by')) {
                $table->foreignId('reviewed_by')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('documents', 'reviewed_at')) {
                $table->timestamp('reviewed_at')->nullable();
            }

            if (!Schema::hasColumn('documents', 'remarks')) {
                $table->text('remarks')->nullable();
            }
        });

        /*
        |--------------------------------------------------------------------------
        | Update Status ENUM
        |--------------------------------------------------------------------------
        */

        DB::statement("
            ALTER TABLE documents
            MODIFY status ENUM(
                'for_review',
                'approved',
                'assigned',
                'accepted',
                'processing',
                'returned',
                'rejected',
                'completed',
                'archived'
            )
            DEFAULT 'for_review'
        ");
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {

            if (Schema::hasColumn('documents', 'receiver_office_id')) {
                $table->dropForeign(['receiver_office_id']);
                $table->dropColumn('receiver_office_id');
            }

            if (Schema::hasColumn('documents', 'assigned_to')) {
                $table->dropForeign(['assigned_to']);
                $table->dropColumn('assigned_to');
            }

            if (Schema::hasColumn('documents', 'approved_by')) {
                $table->dropForeign(['approved_by']);
                $table->dropColumn('approved_by');
            }

            if (Schema::hasColumn('documents', 'reviewed_by')) {
                $table->dropForeign(['reviewed_by']);
                $table->dropColumn('reviewed_by');
            }

            $columns = [
                'priority',
                'extracted_text',
                'assigned_at',
                'approved_at',
                'reviewed_at',
                'remarks',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('documents', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        DB::statement("
            ALTER TABLE documents
            MODIFY status ENUM(
                'for_review',
                'approved',
                'assigned',
                'processing',
                'returned',
                'rejected',
                'completed',
                'archived'
            )
            DEFAULT 'for_review'
        ");
    }
};