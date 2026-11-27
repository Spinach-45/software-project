<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = [
        'code', 'name', 'floor', 'type', 'capacity', 'equipment', 'description',
        'panorama_path', 'map_x', 'map_y', 'is_reservable',
    ];

    protected $casts = ['is_reservable' => 'boolean'];

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }
}
