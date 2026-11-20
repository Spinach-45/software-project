<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Item;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * 測試資料。執行：php artisan migrate:fresh --seed
 * 所有測試帳號密碼都是 password
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create(['name' => '管理員', 'email' => 'admin@example.com', 'password' => 'password', 'role' => 'admin', 'status' => 'approved']);
        $teacher = User::create(['name' => '王老師', 'email' => 'teacher@example.com', 'password' => 'password', 'role' => 'teacher', 'status' => 'approved']);
        $teacher2 = User::create(['name' => '李老師', 'email' => 'teacher2@example.com', 'password' => 'password', 'role' => 'teacher', 'status' => 'approved']);
        $student = User::create(['name' => '陳同學', 'email' => 'user@example.com', 'password' => 'password', 'role' => 'user', 'status' => 'approved']);
        User::create(['name' => '待審核同學', 'email' => 'pending@example.com', 'password' => 'password', 'role' => 'user', 'status' => 'pending']);

        // TODO(模組一)：改成管院網站上的真實教室資料
        // https://www.ibs.ncnu.edu.tw/index.php/resources/space-classroom
        $rooms = collect([
            ['code' => 'M101', 'name' => '一般教室 101', 'floor' => '1F', 'type' => '一般教室', 'capacity' => 60, 'equipment' => '投影機、麥克風', 'map_x' => 20, 'map_y' => 30],
            ['code' => 'M102', 'name' => '一般教室 102', 'floor' => '1F', 'type' => '一般教室', 'capacity' => 60, 'equipment' => '投影機、麥克風', 'map_x' => 40, 'map_y' => 30],
            ['code' => 'M201', 'name' => '電腦教室 201', 'floor' => '2F', 'type' => '電腦教室', 'capacity' => 50, 'equipment' => '電腦 50 台、投影機', 'map_x' => 20, 'map_y' => 60],
            ['code' => 'M301', 'name' => '會議室 301', 'floor' => '3F', 'type' => '會議室', 'capacity' => 20, 'equipment' => '大型螢幕、視訊設備', 'map_x' => 60, 'map_y' => 60],
        ])->map(fn ($r) => Room::create($r));

        $items = collect(['教室鑰匙' => 10, '投影筆' => 5, '筆電' => 3, '延長線' => 5])
            ->map(fn ($qty, $name) => Item::create(['name' => $name, 'quantity' => $qty]))
            ->values();

        $monday = now()->startOfWeek();

        $reservation = Reservation::create([
            'user_id' => $student->id, 'room_id' => $rooms[0]->id,
            'date' => $monday->copy()->addDays(2), 'start_time' => '13:00', 'end_time' => '15:00',
            'purpose' => '社團會議', 'status' => 'pending',
        ]);
        $reservation->items()->attach([$items[0]->id => ['quantity' => 1], $items[1]->id => ['quantity' => 1]]);

        Reservation::create([
            'user_id' => $student->id, 'room_id' => $rooms[3]->id,
            'date' => $monday->copy()->addDays(1), 'start_time' => '10:00', 'end_time' => '12:00',
            'purpose' => '專題討論', 'status' => 'approved', 'review_note' => '請準時歸還鑰匙',
            'reviewed_by' => $admin->id, 'reviewed_at' => now(),
        ]);

        Course::create(['name' => '軟體工程', 'teacher_id' => $teacher->id, 'room_id' => $rooms[2]->id, 'date' => $monday, 'start_time' => '09:00', 'end_time' => '12:00']);
        Course::create(['name' => '資料庫系統', 'teacher_id' => $teacher->id, 'room_id' => $rooms[0]->id, 'date' => $monday->copy()->addDays(3), 'start_time' => '14:00', 'end_time' => '17:00']);
        // 故意和「軟體工程」衝突，用來測試衝突清單
        Course::create(['name' => '管理學', 'teacher_id' => $teacher2->id, 'room_id' => $rooms[2]->id, 'date' => $monday, 'start_time' => '10:00', 'end_time' => '12:00']);
    }
}
