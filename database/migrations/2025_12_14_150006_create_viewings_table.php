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
        Schema::create('viewings', function (Blueprint $table) {
            $table->id();
            
            // Foreign Key - Links to the booking
            $table->foreignId('book_service_id')->constrained('book_services')->onDelete('cascade');
            
            // Viewing Schedule Information
            $table->date('viewing_date');

            // Location Details
            $table->string('location')->nullable(); // e.g., "Chapel A", "Main Hall", "Home Address"
            $table->text('address')->nullable(); // Full address if off-site
            
            // Viewing Type
            $table->enum('viewing_type', [
                'Public', 
                'Private', 
                'Family Only'
            ])->default('Public');
            
            // Setup Details
            $table->text('special_requests')->nullable(); // e.g., "Favorite music", "Photo display"
            
            
            // Status
            $table->enum('status', [
                'Scheduled',
                'In Progress', 
                'Completed',
                'Cancelled'
            ])->default('Scheduled');
            
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('viewings');
    }
};