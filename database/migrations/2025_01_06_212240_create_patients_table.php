<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('rm');
            $table->string('episode');
            $table->string('name');
            $table->string('guarantor_code');
            $table->boolean('status')->default(false);
            $table->string('notes')->default("-");
            $table->string('ip_address')->nullable();
            $table->timestamps();

            $table->foreign('guarantor_code')->references('code')->on('guarantors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
