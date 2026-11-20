<?php

namespace App\Http\Controllers\Spaces;

use App\Http\Controllers\Controller;
use App\Models\Room;

/**
 * 【模組一：管院空間查詢】負責人：（待填）
 *
 * 不須登入即可瀏覽。需求：
 * - 教室列表與基本資訊
 * - 360 全景照片瀏覽（Pannellum，已在 show 頁面接好）
 * - 管院平面圖，標示教室位置（rooms.map_x / map_y）
 */
class SpaceController extends Controller
{
    public function index()
    {
        // TODO(模組一)：加入搜尋/篩選（樓層、類型、容納人數）
        $rooms = Room::orderBy('code')->get();

        return view('spaces.index', compact('rooms'));
    }

    public function show(Room $room)
    {
        return view('spaces.show', compact('room'));
    }

    public function map()
    {
        // TODO(模組一)：放上管院平面圖 public/images/floorplan.png，依 map_x/map_y 標示教室
        $rooms = Room::whereNotNull('map_x')->get();

        return view('spaces.map', compact('rooms'));
    }
}
