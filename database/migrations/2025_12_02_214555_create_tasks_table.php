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
        Schema::create('tasks', function (Blueprint $table) {
             $table->id();
                $table->foreignId('book_service_id')->constrained('book_services')->onDelete('cascade');
                $table->foreignId('staff_id')->nullable()->constrained('users')->onDelete('set null');
                $table->enum('task_type', ['Retrieval', 'Embalming', 'Dressing', 'Viewing']);
                $table->enum('status', ['Pending', 'In Progress', 'Completed'])->default('Pending');
                $table->text('notes')->nullable();
                $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
