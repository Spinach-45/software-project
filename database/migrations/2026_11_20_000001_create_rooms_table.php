<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// 共用：教室/空間資料。空間查詢、預約借用、排課三個模組都會用到。
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();           // 空間編號，例如 M101
            $table->string('name');                     // 名稱
            $table->string('floor')->nullable();        // 樓層
            $table->string('type')->nullable();         // 類型：一般教室、電腦教室、會議室…
            $table->unsignedInteger('capacity')->nullable();
            $table->text('equipment')->nullable();      // 設備說明
            $table->text('description')->nullable();
            $table->string('panorama_path')->nullable(); // 360 全景照片路徑（public/ 底下）
            $table->decimal('map_x', 5, 2)->nullable(); // 平面圖上的位置（百分比）
            $table->decimal('map_y', 5, 2)->nullable();
            $table->boolean('is_reservable')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
