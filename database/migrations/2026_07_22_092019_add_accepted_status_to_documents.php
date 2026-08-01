<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
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