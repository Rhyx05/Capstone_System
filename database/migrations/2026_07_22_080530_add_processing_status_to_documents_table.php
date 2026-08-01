<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE documents
            MODIFY status ENUM(
                'for_review',
                'approved',
                'assigned',
                'returned',
                'rejected',
                'completed',
                'archived'
            )
            DEFAULT 'for_review'
        ");
    }
};