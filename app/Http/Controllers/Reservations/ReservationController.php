<?php

namespace App\Http\Controllers\Reservations;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;

/**
 * 【模組二：空間/物品預約借用】負責人：（待填）
 *
 * 登入才能使用。需求：
 * - 選擇教室，以週為單位列出當週借用狀況
 * - 預約登記（空間、日期、時間區間、借用物品可多項）
 * - 可瀏覽自己的借用紀錄
 * 空間資料用 seeder 建好的測試資料，不須實作教室增刪修改。
 */
class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $reservations = $request->user()->reservations()
            ->with(['room', 'items'])
            ->orderByDesc('date')
            ->get();

        return view('reservations.index', compact('reservations'));
    }

    public function week(Request $request)
    {
        // TODO(模組二)：選擇教室與週次，畫出週借用表（可同時顯示排課模組的課程，見完整款整合）
        return view('todo', ['title' => '教室週借用狀況', 'module' => '模組二']);
    }

    public function create()
    {
        $rooms = Room::where('is_reservable', true)->orderBy('code')->get();
        $items = Item::orderBy('name')->get();

        // TODO(模組二)：預約表單（resources/views/reservations/create.blade.php）
        return view('todo', ['title' => '預約借用', 'module' => '模組二'] + compact('rooms', 'items'));
    }

    public function store(Request $request)
    {
        // TODO(模組二)：驗證、檢查時段衝突（含已核准預約與排課）、建立預約與物品
        abort(501);
    }
}
