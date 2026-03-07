<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {

            $table->id();

            $table->string('title');

            $table->date('event_date');

            $table->string('location');

            $table->decimal('budget', 10, 2)->nullable();

            $table->text('description')->nullable();

            $table->enum('status', ['planned','ongoing','completed'])->default('planned');

            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};