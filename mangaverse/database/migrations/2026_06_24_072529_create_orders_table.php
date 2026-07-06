<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('invoice_number')->unique();
            
            // Info Pengiriman
            $table->string('recipient_name');
            $table->string('phone_number');
            $table->text('shipping_address');
            $table->string('courier');
            $table->decimal('shipping_cost', 10, 2)->default(0);
            
            // Info Pembayaran & Status
            $table->string('payment_method');
            $table->enum('payment_status', ['Unpaid', 'Paid', 'Failed'])->default('Unpaid');
            $table->enum('order_status', ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'])->default('Pending');
            
            // Total Harga
            $table->decimal('subtotal', 12, 2);
            $table->decimal('total_amount', 12, 2);
            $table->string('tracking_number')->nullable(); // Nomor Resi
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};