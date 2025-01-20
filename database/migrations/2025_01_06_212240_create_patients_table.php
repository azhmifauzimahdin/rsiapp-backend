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
            $table->string('rm', 10);
            $table->string('episode', 5);
            $table->string('name', 100);
            $table->string('guarantor_code', 10);
            $table->boolean('status')->default(false);
            $table->string('notes', 100)->default("-");
            $table->string('ip_address', 15)->nullable();
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
