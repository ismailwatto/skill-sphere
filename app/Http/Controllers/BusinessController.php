<?php

namespace App\Http\Controllers;

use App\Services\BusinessService;
use App\Models\Plan;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    protected $businessService;

    public function __construct(BusinessService $businessService)
    {
        $this->businessService = $businessService;
    }

    public function index()
    {
        $businesses = $this->businessService->getAllBusinesses();
        return view('businesses.index', compact('businesses'));
    }

    public function create()
    {
        $plans = Plan::all();
        return view('businesses.create', compact('plans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
            'business_type' => 'nullable|string|max:100',
            'business_phone' => 'nullable|string|max:20',
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|email|unique:users,email',
            'owner_password' => 'required|string|min:8|confirmed',
            'plan_id' => 'nullable|exists:plans,id',
        ]);

        $this->businessService->createBusinessWithOwner($request->all());

        return redirect()->route('businesses.index')
            ->with('success', 'Business and Owner account created successfully!');
    }

    public function edit($id)
    {
        $business = \App\Models\Business::findOrFail($id);
        // Find the owner user (this logic assumes one owner per business, or takes the first one)
        $owner = \App\Models\User::where('business_id', $business->id)
                    ->whereHas('role', function($q) {
                        $q->where('name', 'Business Owner');
                    })->first();

        // Fallback: If no user with "Business Owner" role, take the first user created for this business.
        if (!$owner) {
            $owner = \App\Models\User::where('business_id', $business->id)->orderBy('id')->first();
        }
                    
        $plans = Plan::all();
        return view('businesses.edit', compact('business', 'plans', 'owner'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
            'business_type' => 'nullable|string|max:100',
            'business_phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
            'plan_id' => 'nullable|exists:plans,id',
        ]);

        $this->businessService->updateBusiness($id, $request->all());

        return redirect()->route('businesses.index')
            ->with('success', 'Business updated successfully!');
    }

    public function destroy($id)
    {
        $this->businessService->toggleStatus($id);
        return back()->with('success', 'Business status updated successfully!');
    }
}
