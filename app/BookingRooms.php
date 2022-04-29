<?php

namespace App;

use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Log;

class BookingRooms extends Model
{
    protected $guarded = [];

    public static function bookingRoom($request, $id)
    {
        $bookingRooms = new BookingRooms([
            'client_id' => $id,
            'tariff_id' => $request->tariff,
            'room_id' => $request->room,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'time_start' => $request->time_start,
            'time_end' => $request->time_end,
            'old' => $request->old,
            'new' => $request->new,
            'price' => $request->price,
            'discount' => $request->discount,
            'accommodation' => $request->accommodation == 'on',
            'payment_type' => $request->accommodation == 'on',
            'payment_state' => $request->accommodation == 'on',
        ]);

        $bookingRooms->save();
    }

    /**
     * @param $id
     * @param $start
     * @param $end
     * @return bool
     */
    public static function isContainsPeriod($id, $start, $end): bool
    {
        $room = BookingRooms::where('room_id', '=', $id)->get();
        if (count($room) > 0) {
            foreach ($room as $booking) {
                $period = CarbonPeriod::create($booking->date_start . ' ' . $booking->time_start, $booking->date_end . ' ' . $booking->time_end);
                if ($period->contains($start) || $period->contains($end)) {
                    return true;
                } else {
                    return false;
                }
            }
        }

        return false;
    }

    /**
     * @return belongsTo
     */
    public function room(): belongsTo
    {
        return $this->belongsTo(Rooms::class);
    }

    /**
     * @return belongsTo
     */
    public function client(): belongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * @return BelongsTo
     */
    public function tariff(): BelongsTo
    {
        return $this->belongsTo(Tariff::class);
    }
}
