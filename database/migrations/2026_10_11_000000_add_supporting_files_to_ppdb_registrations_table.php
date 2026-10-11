<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $table->string('supporting_file_kk')->nullable()->after('notes')->comment('Path to KK file');
            $table->string('supporting_file_akte')->nullable()->after('supporting_file_kk')->comment('Path to Akte Kelahiran file');
            $table->string('supporting_file_rapor')->nullable()->after('supporting_file_akte')->comment('Path to Rapor file');
        });
    }

    public function down(): void
    {
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $table->dropColumn(['supporting_file_kk', 'supporting_file_akte', 'supporting_file_rapor']);
        });
    }
};
