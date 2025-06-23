<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('negotiations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_id')->constrained()->onDelete('cascade');
            $table->foreignId('buyer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('seller_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('offer_price', 10, 2);
            $table->enum('status', ['pending', 'accepted', 'rejected', 'countered'])->default('pending');
            $table->decimal('counter_price', 10, 2)->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('negotiations');
    }
};