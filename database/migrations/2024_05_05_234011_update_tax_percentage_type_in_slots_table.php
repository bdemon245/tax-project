<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('slots', function (Blueprint $table) {
            $table->double(column: 'tax_percentage', places: 6)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('slots', function (Blueprint $table) {
            $table->integer('tax_percentage')->default(0)->change();
        });
    }
};
