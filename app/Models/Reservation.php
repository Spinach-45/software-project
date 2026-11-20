<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reservation extends Model
{
    public const STATUSES = [
        'pending' => '待審核',
        'approved' => '已通過',
        'rejected' => '已退件',
        'checked_out' => '已領用',
        'returned' => '已歸還',
        'cancelled' => '已取消',
    ];

    protected $fillable = [
        'user_id', 'room_id', 'date', 'start_time', 'end_time', 'purpose', 'status',
        'review_note', 'reviewed_by', 'reviewed_at', 'checked_out_at', 'returned_at',
    ];

    protected $casts = [
        'date' => 'date',
        'reviewed_at' => 'datetime',
        'checked_out_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class)->withPivot('quantity');
    }
}
