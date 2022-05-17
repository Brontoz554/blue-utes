<?php

namespace App;

use Carbon\Carbon;
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

        foreach ($dates as $key => $date) {
            $nutrition = new BookingNutrition();

            $end = Carbon::parse($data->date_end . ' ' . $data->time_end);
            $start = Carbon::parse($data->date_start . ' ' . $data->time_start);

            $breakfastStart = Carbon::parse($data->date_start . ' 9:00');
            $dinnerStart = Carbon::parse($data->date_start . ' 13:00');
            $lunchStart = Carbon::parse($data->date_start . ' 19:00');

            $breakfastEnd = Carbon::parse($data->date_end . ' 9:00');
            $dinnerEnd = Carbon::parse($data->date_end . ' 13:00');
            $lunchEnd = Carbon::parse($data->date_end . ' 19:00');

            $nutrition->date = $date->format('d-m-y');
            $nutrition->booking_id = $bookingId;

            if (array_key_first($dates) == $key) {
                //Если заезд клиента раньше завтрака
                $nutrition->breakfast = $start < $breakfastStart ? $data->breakfast : 0;

                //Если заезд клиента раньше обеда
                $nutrition->dinner = $start < $dinnerStart ? $data->dinner : 0;

                //Если заезд клиента раньше ужина
                $nutrition->lunch = $start < $lunchStart ? $data->lunch : 0;

            } else if (array_key_last($dates) == $key) {

                //Если выезд клиента позже завтрака
                $nutrition->breakfast = $breakfastEnd < $end ? $data->breakfast : 0;

                //Если выезд клиента позже обеда
                $nutrition->dinner = $dinnerEnd < $end ? $data->dinner : 0;

                //Если выезд клиента позже ужина
                $nutrition->lunch = $lunchEnd < $end ? $data->lunch : 0;

            } else {
                $nutrition->breakfast = $data->breakfast;
                $nutrition->dinner = $data->dinner;
                $nutrition->lunch = $data->lunch;
            }

            $nutrition->save();
        }
    }

    /**
     * @param $request
     * @param $booking
     * @return void
     */
    public static function recalculateNutritionInfo($request, $bookingId)
    {
        $period = CarbonPeriod::create($request->date_start, $request->date_end);
        $dates = $period->toArray();
        $will = [];

        foreach ($dates as $date) {
            $nutrition = BookingNutrition::where('booking_id', '=', $bookingId)
                ->where('date', '=', $date->format('d-m-y'))
                ->first();

            if (!isset($nutrition)) {
                $new = new BookingNutrition([
                    'booking_id' => $bookingId,
                    'date' => $date->format('d-m-y'),
                    'breakfast' => 0,
                    'dinner' => 0,
                    'lunch' => 0,
                ]);

                $new->save();
            }
        }


        $nutritious = BookingNutrition::where('booking_id', '=', $bookingId)->get();
        foreach ($nutritious as $nutrition) {
            foreach ($dates as $date) {
                if ($nutrition->date == $date->format('d-m-y'))
                    $will[] = $date->format('d-m-y');
            }
        }

        $request = BookingNutrition::where('booking_id', '=', $bookingId);
        foreach ($will as $item) {
            $request->where('date', '!=', $item);
        }
        $request->delete();
    }
}
