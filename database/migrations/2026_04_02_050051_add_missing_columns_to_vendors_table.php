<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            if (!Schema::hasColumn('vendors', 'service_type')) {
                $table->string('service_type')->nullable()->after('name');
            }
            if (!Schema::hasColumn('vendors', 'contact')) {
                $table->string('contact')->nullable()->after('service_type');
            }
            if (!Schema::hasColumn('vendors', 'email')) {
                $table->string('email')->nullable()->after('contact');
            }
            if (!Schema::hasColumn('vendors', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (!Schema::hasColumn('vendors', 'address')) {
                $table->text('address')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('vendors', 'rating')) {
                $table->decimal('rating', 2, 1)->nullable()->after('address');
            }
        });
    }

    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn(['service_type', 'contact', 'email', 'phone', 'address', 'rating']);
        });
    }
};