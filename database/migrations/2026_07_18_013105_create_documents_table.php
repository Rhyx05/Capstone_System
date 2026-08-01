<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {

            $table->id();

            $table->string('tracking_code')->unique();

            $table->string('title');

            $table->string('category');

            $table->text('description')->nullable();

            $table->string('file_name');

            $table->string('file_path');

            $table->string('file_type');

            $table->unsignedBigInteger('file_size');

            $table->foreignId('submitted_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('office_id')
                ->constrained('offices')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->enum('status', [
                'for_review',
                'received',
                'routed',
                'completed',
                'archived'
            ])->default('for_review');

            $table->timestamp('submission_date');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};