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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_service_id')->constrained('book_services')->onDelete('cascade');
            // $table->string('bill_number')->unique();
            $table->decimal('total_amount', 10, 2);
            $table->decimal('paid_amount', 10, 2);
            $table->decimal('balance_amount', 10, 2);
            $table->enum('payment_status',['unpaid', 'partial', 'fully paid'])->default('unpaid'); // e.g., 'paid', 'unpaid', 'overdue'
            $table->dateTime('due_date')->nullable();

            $table->timestamps();
        });
    }
    //     BILL {
    //     int bill_id PK
    //     int booking_id FK
    //     string bill_number
    //     decimal package_price
    //     decimal additional_charges
    //     decimal discount
    //     decimal total_amount
    //     decimal paid_amount
    //     decimal balance
    //     string payment_status
    // }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
