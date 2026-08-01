<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['office_id']);
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->foreignId('office_id')->nullable()->change();
            $table->foreign('office_id')->references('id')->on('offices')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['office_id']);
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->foreignId('office_id')->nullable(false)->change();
            $table->foreign('office_id')->references('id')->on('offices')->restrictOnDelete();
        });
    }
};