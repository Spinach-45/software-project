<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

/**
 * 【模組一：管院空間查詢】管理員增刪修改教室資料
 */
class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::orderBy('code')->get();

        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        // TODO(模組一)：新增教室表單
        return view('todo', ['title' => '新增教室', 'module' => '模組一']);
    }

    public function store(Request $request)
    {
        // TODO(模組一)：驗證並儲存教室，處理 360 照片上傳
        abort(501);
    }

    public function edit(Room $room)
    {
        // TODO(模組一)：編輯教室表單
        return view('todo', ['title' => "編輯教室 {$room->code}", 'module' => '模組一']);
    }

    public function update(Request $request, Room $room)
    {
        // TODO(模組一)
        abort(501);
    }

    public function destroy(Room $room)
    {
        // TODO(模組一)：刪除前確認沒有預約或課程使用這間教室
        abort(501);
    }
}
