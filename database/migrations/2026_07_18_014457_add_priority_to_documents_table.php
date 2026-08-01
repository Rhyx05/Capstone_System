<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {

            $table->enum('priority', [
                'Low',
                'Normal',
                'High',
                'Urgent'
            ])->default('Normal')->after('category');

        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {

            $table->dropColumn('priority');

        });
    }
};