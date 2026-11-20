<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// 預約借用模組：可借物品、預約單、預約單與物品的對應
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');                         // 鑰匙、投影筆、筆電…
            $table->unsignedInteger('quantity')->default(1);
            $table->timestamps();
        });

        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('purpose')->nullable();
            // pending 待審 | approved 通過 | rejected 退件 | checked_out 已領用 | returned 已歸還 | cancelled 取消
            $table->string('status')->default('pending');
            $table->text('review_note')->nullable();        // 審核意見
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('checked_out_at')->nullable(); // 管理員註記借出
            $table->timestamp('returned_at')->nullable();    // 管理員確認歸還
            $table->timestamps();
        });

        Schema::create('item_reservation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('item_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('quantity')->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_reservation');
        Schema::dropIfExists('reservations');
        Schema::dropIfExists('items');
    }
};
