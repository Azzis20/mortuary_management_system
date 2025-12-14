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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_id')->constrained('bills')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade'); //client who paid
            $table->foreignId('processed_by')->constrained('users')->onDelete('cascade'); //prceesed by staff
            $table->decimal('amount', 10, 2); //amount paid
            $table->dateTime('payment_date');

            // $table->string('receipt_number')->unique();
            $table->timestamps(); 
        });
    }


    
    //   PAYMENT {
    //     int payment_id PK
    //     int bill_id FK
    //     int client_id FK
    //     int booking_id FK
    //     decimal amount
    //     string payment_method
    //     string payment_status
    //     datetime payment_date
    //     string receipt_number
    //     int processed_by_admin FK
    //     text notes
    //     datetime created_at
    // }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
