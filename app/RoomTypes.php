<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoomTypes extends Model
{
    protected $guarded = [];

    /**
     * @return int
     */
    public function roomsCount(): int
    {
        return $this->hasMany(Rooms::class)->count();
    }

    /**
     * @return HasMany
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(Rooms::class);
    }
}
