<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Room;
use Illuminate\Http\Request;

/**
 * 【模組三：志願排課】負責人：（待填）
 *
 * 登入才能使用，限老師與管理員。需求：
 * - 老師登記想排課的時段（課程、日期、區間、希望的教室），新增/修改/刪除
 * - 清單列出自己的課程，只能調整自己的課程
 * - 週日曆檢視所有排課狀態
 */
class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses = $request->user()->courses()->with('room')->orderBy('date')->orderBy('start_time')->get();

        return view('courses.index', compact('courses'));
    }

    public function calendar()
    {
        // TODO(模組三)：週日曆（可考慮 FullCalendar），管理員可 drag & drop 改時間（呼叫 Admin\CourseAdminController@move）
        return view('todo', ['title' => '排課週日曆', 'module' => '模組三']);
    }

    public function create()
    {
        // TODO(模組三)：新增課程表單
        return view('todo', ['title' => '新增課程', 'module' => '模組三']);
    }

    public function store(Request $request)
    {
        // TODO(模組三)
        abort(501);
    }

    public function edit(Request $request, Course $course)
    {
        $this->authorizeOwner($request, $course);

        // TODO(模組三)：編輯課程表單
        return view('todo', ['title' => "編輯課程 {$course->name}", 'module' => '模組三']);
    }

    public function update(Request $request, Course $course)
    {
        $this->authorizeOwner($request, $course);
        // TODO(模組三)
        abort(501);
    }

    public function destroy(Request $request, Course $course)
    {
        $this->authorizeOwner($request, $course);
        // TODO(模組三)
        abort(501);
    }

    /** 老師只能調整自己的課程；管理員可調整全部 */
    private function authorizeOwner(Request $request, Course $course): void
    {
        $user = $request->user();
        abort_unless($user->isAdmin() || $course->teacher_id === $user->id, 403, '只能調整自己的課程');
    }
}
