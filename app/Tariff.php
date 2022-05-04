<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tariff extends Model
{
    protected $guarded = [];

    /**
     * @return BelongsToMany
     */
    public function treatments(): BelongsToMany
    {
        return $this->belongsToMany(Treatment::class);
    }

    /**
     * @return BelongsToMany
     */
    public function eatings(): BelongsToMany
    {
        return $this->belongsToMany(Eating::class);
    }

    /**
     * @return BelongsToMany
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Services::class, 'tariff_services');
    }

    /**
     * @return BelongsToMany
     */
    public function roomTypes(): BelongsToMany
    {
        return $this->belongsToMany(RoomTypes::class, 'tariff_rooms', 'room_types_id', 'tariff_id');
    }
}
