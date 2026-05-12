<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->get();
        return view('backend.services.index', compact('services'));
    }

    public function create()
    {
        $pricingTypes = Service::getPricingTypes();
        return view('backend.services.create', compact('pricingTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'pricing_type' => 'nullable|in:one_time,per_year,per_month,per_page',
            'timeline_weeks' => 'nullable|integer|min:1',
            'key_features' => 'nullable|string',
            'is_optional' => 'boolean',
            'status' => 'boolean',
        ]);

        // Process key_features from textarea to array
        $keyFeaturesArray = null;
        if ($request->filled('key_features')) {
            $keyFeaturesArray = array_filter(
                array_map('trim', explode("\n", $request->key_features)),
                function($line) {
                    return !empty($line);
                }
            );
        }

        $service = Service::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'pricing_type' => $request->pricing_type,
            'timeline_weeks' => $request->timeline_weeks,
            'key_features' => $keyFeaturesArray,
            'is_optional' => $request->is_optional ?? false,
            'status' => $request->status ?? true,
        ]);

        return redirect()->route('services.index')->with('success', 'Service created successfully!');
    }

    public function edit(Service $service)
    {
        $pricingTypes = Service::getPricingTypes();
        return view('backend.services.edit', compact('service', 'pricingTypes'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'pricing_type' => 'nullable|in:one_time,per_year,per_month,per_page',
            'timeline_weeks' => 'nullable|integer|min:1',
            'key_features' => 'nullable|string',
            'is_optional' => 'boolean',
            'status' => 'boolean',
        ]);

        // Process key_features from textarea to array
        $keyFeaturesArray = null;
        if ($request->filled('key_features')) {
            $keyFeaturesArray = array_filter(
                array_map('trim', explode("\n", $request->key_features)),
                function($line) {
                    return !empty($line);
                }
            );
        }

        $service->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'pricing_type' => $request->pricing_type,
            'timeline_weeks' => $request->timeline_weeks,
            'key_features' => $keyFeaturesArray,
            'is_optional' => $request->is_optional ?? false,
            'status' => $request->status ?? true,
        ]);

        return redirect()->route('services.index')->with('success', 'Service updated successfully!');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Service deleted successfully!');
    }
}
