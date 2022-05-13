<?php

namespace App;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;


class BookingRooms extends Model
{
    protected $guarded = [];

    /**
     * @param $request
     * @param $id
     * @return int
     */
    public static function bookingRoom($request, $id): int
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
            'type_of_day' => $request->type_of_day,
            'booking_type' => $request->booking_type,
            'payment_type' => $request->payment_type,
            'payment_state' => $request->payment_state,
        ]);

        $bookingRooms->save();

        return $bookingRooms->id;
    }

    /**
     * @param $roomId
     * @param $start
     * @param $end
     * @param $bookingId
     * @return bool
     */
    public static function isContainsPeriod($roomId, $start, $end, $bookingId = false): bool
    {
        if ($bookingId) {
            $room = BookingRooms::where('room_id', '=', $roomId)->where('id', '!=', $bookingId)->get();
        } else {
            $room = BookingRooms::where('room_id', '=', $roomId)->get();
        }

        if (count($room) > 0) {
            foreach ($room as $booking) {
                $period = CarbonPeriod::create(
                    $booking->date_start . ' ' . $booking->time_start,
                    $booking->date_end . ' ' . $booking->time_end
                );

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
     * @param Request $request
     * @param BookingRooms $booking
     * @param bool $changeCheckIn
     * @return float
     */
    public static function recalculatePrice(Request $request, BookingRooms $booking, bool $changeCheckIn = true): float
    {
        $start = Carbon::parse($booking->date_start . ' ' . $booking->time_start);
        $end = Carbon::parse($booking->date_end . ' ' . $booking->time_end);

        if ($changeCheckIn) {
            $hoursAfter = $end->diffInHours($start);

            $start = Carbon::parse($request->date . ' ' . $request->time);
            $hoursBefore = $end->diffInHours($start);

        } else {
            $hoursAfter = $start->diffInHours($end);

            $end = Carbon::parse($request->date . ' ' . $request->time);
            $hoursBefore = $start->diffInHours($end);

        }

        return ceil(($hoursBefore / ($hoursAfter / 100)) * ($booking->price / 100));
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

    /**
     * @return HasMany
     */
    public function nutritious(): HasMany
    {
        return $this->hasMany(BookingNutrition::class, 'booking_id')->orderBy('date', 'ASC');
    }

    /**
     * @return HasMany
     */
    public function PaidServiceNutritiousBooking(): HasMany
    {
        return $this->hasMany(PaidServiceNutritiousBooking::class, 'booking_id');
    }
}
