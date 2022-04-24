<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Services extends Model
{
    protected $guarded = [];

    protected $table = 'services';

    /**
     * @return BelongsToMany
     */
    public function tariffs(): BelongsToMany
    {
        return $this->belongsToMany(Tariff::class);
    }
}
