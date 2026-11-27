<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

/**
 * 【模組三：志願排課】管理員功能
 * - 列出所有老師的課程、指派課程給老師
 * - 列出時間衝突的課程
 * - 週日曆 drag & drop 移動課程
 */
class CourseAdminController extends Controller
{
    public function index()
    {
        $courses = Course::with(['teacher', 'room'])->orderBy('date')->orderBy('start_time')->get();

        return view('admin.courses.index', compact('courses'));
    }

    public function conflicts()
    {
        // 同一間教室、同一天、時間重疊的課程
        $conflicts = Course::query()
            ->from('courses as a')
            ->join('courses as b', function ($join) {
                $join->on('a.room_id', '=', 'b.room_id')
                    ->on('a.date', '=', 'b.date')
                    ->on('a.id', '<', 'b.id')
                    ->on('a.start_time', '<', 'b.end_time')
                    ->on('b.start_time', '<', 'a.end_time');
            })
            ->select('a.id as course_a', 'b.id as course_b')
            ->get();

        // TODO(模組三)：也檢查同一位老師同時段的衝突，並做成頁面
        return view('todo', ['title' => '時間衝突課程（找到 '.$conflicts->count().' 組）', 'module' => '模組三']);
    }

    public function move(Request $request, Course $course)
    {
        // TODO(模組三)：接收日曆拖拉後的新日期與時間（JSON），更新課程
        abort(501);
    }
}
