<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->text('details')->nullable()->after('amount'); // or after a suitable column
            $table->enum('type', ['credit', 'debit'])->default('credit')->after('details');
        });
    }

    public function down(): void
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropColumn(['details', 'type']);
        });
    }
};

