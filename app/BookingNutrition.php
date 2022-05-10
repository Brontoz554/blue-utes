<?php

namespace App;

use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;

class BookingNutrition extends Model
{
    protected $guarded = [];

    protected $table = 'booking_nutrition';

    /**
     * @param $data
     * @param $bookingId
     * @return void
     */
    public static function createNutritionInfo($data, $bookingId)
    {
        $period = CarbonPeriod::create($data->date_start . ' ' . $data->time_start, $data->date_end . ' ' . $data->time_end);

        $dates = $period->toArray();

        foreach ($dates as $date) {
            $nutrition = new BookingNutrition([
                'date' => $date->format('d-m-y'),
                'booking_id' => $bookingId,
                'breakfast' => $data->breakfast,
                'dinner' => $data->dinner,
                'lunch' => $data->lunch,
            ]);

            $nutrition->save();
        }
    }
}
