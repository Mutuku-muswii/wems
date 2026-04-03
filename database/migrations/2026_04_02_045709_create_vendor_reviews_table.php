<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendor_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained()->onDelete('cascade');
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('reviewer_id')->constrained('users');
            $table->enum('reviewer_role', ['manager', 'staff', 'client']);
            $table->tinyInteger('punctuality')->unsigned()->default(3);
            $table->tinyInteger('quality')->unsigned()->default(3);
            $table->tinyInteger('communication')->unsigned()->default(3);
            $table->tinyInteger('value')->unsigned()->default(3);
            $table->tinyInteger('professionalism')->unsigned()->default(3);
            $table->decimal('overall_rating', 2, 1)->nullable();
            $table->text('comment')->nullable();
            $table->boolean('is_anonymous')->default(true);
            $table->timestamp('locked_at')->nullable();
            $table->timestamps();
            
            $table->unique(['vendor_id', 'event_id', 'reviewer_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendor_reviews');
    }
};