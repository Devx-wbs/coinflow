<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = Plan::latest()->get();
        return view('superadmin.plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.plans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'price'           => 'required|numeric|min:0',
            'duration'        => 'required|integer|min:1',
            'duration_type'   => 'required|in:days,months,years',
            'license_type'    => 'required|in:single_site,multi_site,unlimited',
            'max_activations' => 'required_if:license_type,multi_site|nullable|integer|min:1',
            'trial_days'      => 'nullable|integer|min:0',
            'description'     => 'nullable|string',
            'is_active'       => 'nullable|boolean',
        ]);

        if ($error = Plan::validateTrialDays($validated)) {
            return back()
                ->withErrors(['trial_days' => $error])
                ->withInput();
        }

        $validated['max_activations'] = Plan::resolveMaxActivations($validated);

        // Create Plan
        Plan::create([
            'name'               => $validated['name'],
            'description'        => $validated['description'] ?? null,
            'price'              => $validated['price'],
            'duration'           => $validated['duration'],
            'duration_type'      => $validated['duration_type'],
            'license_type'       => $validated['license_type'],
            'max_activations'    => $validated['max_activations'],
            'auto_generate_license' => true, // default true
            'features'           => null,    // abhi ke liye empty
            'is_active'          => $request->has('is_active') ? 1 : 0,
            'trial_days'         => $validated['trial_days'] ?? null,
        ]);

        return redirect()->route('plans-index')->with('success', 'Plan created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        return view('superadmin.plans.edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plan $plan)
    {

        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'price'           => 'required|numeric|min:0',
            'duration'        => 'required|integer|min:1',
            'duration_type'   => 'required|in:days,months,years',
            'license_type'    => 'required|in:single_site,multi_site,unlimited',
            'max_activations' => 'required_if:license_type,multi_site|nullable|integer|min:1',
            'trial_days'      => 'nullable|integer|min:0',
            'is_active'       => 'nullable|boolean',
        ]);

        if ($error = Plan::validateTrialDays($validated)) {
            return back()
                ->withErrors(['trial_days' => $error])
                ->withInput();
        }

        $validated['max_activations'] = Plan::resolveMaxActivations($validated);

       
        $plan->update([
            'name'              => $validated['name'],
            'description'       => $validated['description'] ?? null,
            'price'             => $validated['price'],
            'duration'          => $validated['duration'],
            'duration_type'     => $validated['duration_type'],
            'license_type'      => $validated['license_type'],
            'max_activations'   => $validated['max_activations'],
            'trial_days'        => $validated['trial_days'] ?? null,
            'is_active'         => $request->has('is_active') ? 1 : 0,
        ]);


        return redirect()->route('plans-index')->with('success', 'Plan updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        try {
            $plan->delete();
            return redirect()->route('plans-index')->with('success', 'Plan deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('plans-index')->with('error', 'Failed to delete plan!');
        }
    }
}
