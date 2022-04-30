<?php

namespace App\Http\Controllers;

use App\BookingRooms;
use Illuminate\Http\Request;

class KitchenController extends Controller
{
    public function index()
    {
        $bookings = BookingRooms::get();

        dd($bookings);
    }
}
