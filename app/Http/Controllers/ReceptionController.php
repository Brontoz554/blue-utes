<?php

namespace App\Http\Controllers;

use App\BookingRooms;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReceptionController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $bookings = BookingRooms::get();

        return view('management-system.reception.index', ['bookings' => $bookings]);
    }
}
