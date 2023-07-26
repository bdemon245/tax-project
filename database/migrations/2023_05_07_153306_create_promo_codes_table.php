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
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('user_type', ['all', 'individual', 'user', 'partner'])->nullable();
            $table->string('code');
            $table->boolean('status')->default(1);
            $table->integer('limit')->default(1);
            $table->string('expired_at')->default('112.2232.322');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_codes');
    }
};
