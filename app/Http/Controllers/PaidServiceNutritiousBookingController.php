<?php

namespace App\Http\Controllers;

use App\Eating;
use App\PaidServiceNutritiousBooking;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PaidServiceNutritiousBookingController extends Controller
{
    public function store(Request $request)
    {
        $paid = new PaidServiceNutritiousBooking([
            'booking_id' => $request->bookingId,
            'name' => $request->name,
            'price' => $request->price,
        ]);

        $paid->save();

        return Redirect::back();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function editPaidNutritious(Request $request): JsonResponse
    {
        if (strlen($request->option) > 0) {
            PaidServiceNutritiousBooking::where('id', $request->id)->update([
                $request->name => $request->option,
            ]);
            return response()->json([]);
        }
        return response()->json([], 400);
    }

    /**
     * @param PaidServiceNutritiousBooking $service
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(PaidServiceNutritiousBooking $service): RedirectResponse
    {
        $service->delete();

        return Redirect::back();
    }
}
