<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Treatment extends Model
{
    protected $guarded = [];

    /**
     * @return BelongsToMany
     */
    public function tariffs(): BelongsToMany
    {
        return $this->belongsToMany(Tariff::class);
    }
}
