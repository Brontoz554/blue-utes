<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Rooms extends Model
{
    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(RoomTypes::class, 'room_types_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function roomServices(): BelongsToMany
    {
        return $this->belongsToMany(RoomService::class, 'room_service_rooms', 'room_id', 'service_id');
    }

    /**
     * @return HasMany
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(BookingRooms::class, 'room_id');
    }

}
