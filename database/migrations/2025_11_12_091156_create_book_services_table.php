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
            Schema::create('book_services', function (Blueprint $table) {
                $table->id();
                $table->foreignId('client_id')->constrained('users')->onDelete('cascade'); //client
                $table->foreignId('deceased_id')->constrained('deceaseds')->unique()->onDelete('cascade');
                $table->foreignId('package_id')->constrained('packages')->onDelete('cascade'); //package
                $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('cascade'); // admin who approved
                $table->enum('status',['Pending', 'Confirmed', 'Dispatch','InCare','Viewing','Released','Declined'])->default('Pending'); 
                $table->timestamps();
               
                
            });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_services');
    }
};
