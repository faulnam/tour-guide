<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class VehicleController extends Controller
{
    /**
     * Show customer garage.
     */
    public function index(): View
    {
        $user = Auth::user();
        $vehicles = Vehicle::where('user_id', $user->id)->latest()->get();

        return view('customer.vehicles.index', compact('vehicles'));
    }

    /**
     * Store new vehicle in garage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'in:motor,mobil'],
            'brand' => ['required', 'string', 'max:100'],
            'model' => ['required', 'string', 'max:100'],
            'license_plate' => ['required', 'string', 'max:20'],
            'year' => ['nullable', 'string', 'max:10'],
            'color' => ['nullable', 'string', 'max:50'],
            'engine_cc' => ['nullable', 'string', 'max:50'],
            'transmission' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $validated['user_id'] = Auth::id();
        $validated['license_plate'] = strtoupper(trim($validated['license_plate']));

        Vehicle::create($validated);

        return redirect()->route('customer.vehicles.index')
                         ->with('success', 'Kendaraan berhasil ditambahkan ke Garasi Anda!');
    }

    /**
     * Delete vehicle from garage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $vehicle = Vehicle::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $vehicle->delete();

        return redirect()->route('customer.vehicles.index')
                         ->with('success', 'Kendaraan berhasil dihapus dari Garasi.');
    }
}
