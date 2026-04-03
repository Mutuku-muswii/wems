<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'manager', 'staff', 'client', 'vendor'])->default('staff')->after('email');
            }
            if (!Schema::hasColumn('users', 'client_id')) {
                $table->foreignId('client_id')->nullable()->constrained()->onDelete('set null')->after('role');
            }
            if (!Schema::hasColumn('users', 'vendor_id')) {
                $table->foreignId('vendor_id')->nullable()->constrained()->onDelete('set null')->after('client_id');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'client_id', 'vendor_id', 'phone']);
        });
    }
};