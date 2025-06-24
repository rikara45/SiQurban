<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('order_number')->unique();
            $table->decimal('total_amount', 10, 2);

            // KOLOM BARU UNTUK METODE PENGIRIMAN
            $table->enum('delivery_method', ['diantar', 'diambil', 'disalurkan']);

            // STATUS BARU YANG LEBIH DETAIL
            $table->enum('status', [
                'pending_confirmation', // Menunggu konfirmasi penjual
                'rejected',             // Ditolak penjual
                'processing',           // Diterima, sedang diproses
                'shipping',             // Sedang diantar
                'ready_for_pickup',     // Siap diambil
                'completed',            // Selesai
                'cancelled'             // Dibatalkan pembeli (opsional)
            ])->default('pending_confirmation');

            $table->text('rejection_reason')->nullable(); // Alasan penolakan dari penjual
            $table->timestamp('seller_confirmed_at')->nullable();
            $table->timestamp('buyer_confirmed_at')->nullable();

            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('orders');
    }
};