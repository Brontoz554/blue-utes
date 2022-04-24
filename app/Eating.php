<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Eating extends Model
{
    protected $table = 'eating';

    protected $guarded = [];

    /**
     * @return BelongsToMany
     */
    public function tariffs(): BelongsToMany
    {
        return $this->belongsToMany(Tariff::class);
    }

}
