<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('business_id', Auth::user()->business_id)
            ->with(['product', 'staff'])
            ->orderBy('booking_at', 'desc')
            ->get();
            
        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $products = \App\Models\Product::where('business_id', Auth::user()->business_id)->where('status', 'active')->get();
        $staff = \App\Models\User::where('business_id', Auth::user()->business_id)->where('status', 'active')->get();
        return view('bookings.create', compact('products', 'staff'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'booking_at' => 'required|date',
            'product_id' => 'nullable|exists:products,id',
            'user_id' => 'nullable|exists:users,id',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $data['business_id'] = Auth::user()->business_id;

        Booking::create($data);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking created successfully.');
    }

    public function edit(Booking $booking)
    {
        $this->authorizeBusiness($booking);
        $products = \App\Models\Product::where('business_id', Auth::user()->business_id)->where('status', 'active')->get();
        $staff = \App\Models\User::where('business_id', Auth::user()->business_id)->where('status', 'active')->get();
        return view('bookings.edit', compact('booking', 'products', 'staff'));
    }

    public function update(Request $request, Booking $booking)
    {
        $this->authorizeBusiness($booking);

        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'booking_at' => 'required|date',
            'product_id' => 'nullable|exists:products,id',
            'user_id' => 'nullable|exists:users,id',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $booking->update($data);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        $this->authorizeBusiness($booking);
        $booking->delete();

        return redirect()->route('bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }

    protected function authorizeBusiness(Booking $booking)
    {
        if ($booking->business_id !== Auth::user()->business_id) {
            abort(403);
        }
    }
}
