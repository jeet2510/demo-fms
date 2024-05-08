<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tracking;
use App\Models\Booking;
use App\Models\Invoice;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		$bookings = Booking::where('created_by', Auth::user()->creatorId())->get();
        $trackings = Tracking::where('created_by', Auth::user()->creatorId())->get();
         $total_bookings_today=Booking::where('created_by', Auth::user()->creatorId())->whereYear('created_at', Carbon::now()->year)
                        ->whereMonth('created_at', Carbon::now()->month)
                        ->whereDay('created_at', Carbon::now()->day)
                        ->count();
         $total_bookings_this_month=Booking::where('created_by', Auth::user()->creatorId())->whereYear('created_at', Carbon::now()->year)
                        ->whereMonth('created_at', Carbon::now()->month)
                        ->count();
         $total_invoices_this_month=Invoice::where('created_by', Auth::user()->creatorId())->whereYear('created_at', Carbon::now()->year)
                        ->whereMonth('created_at', Carbon::now()->month)
                        ->count();
        return view('home',compact('bookings', 'trackings','total_bookings_today','total_bookings_this_month','total_invoices_this_month'));
    }
}
