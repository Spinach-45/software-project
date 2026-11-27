<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

/**
 * 【模組二：空間/物品預約借用】管理員審核、借出、歸還
 */
class ReservationReviewController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['user', 'room', 'items'])
            ->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
            ->orderBy('date')
            ->get();

        return view('admin.reservations.index', compact('reservations'));
    }

    public function review(Request $request, Reservation $reservation)
    {
        // TODO(模組二)：通過或退件，寫入 review_note、reviewed_by、reviewed_at
        abort(501);
    }

    public function checkout(Reservation $reservation)
    {
        // TODO(模組二)：註記借出（status = checked_out, checked_out_at = now()）
        abort(501);
    }

    public function return(Reservation $reservation)
    {
        // TODO(模組二)：確認歸還（status = returned, returned_at = now()）
        abort(501);
    }
}
