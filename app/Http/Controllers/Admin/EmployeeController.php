<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function index(): View
    {
        $employees = User::where('role', 'karyawan')
            ->withCount(['attendances', 'assignedBookings'])
            ->latest()
            ->paginate(15);

        return view('admin.employees.index', compact('employees'));
    }

    public function create(): View
    {
        return view('admin.employees.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', Password::min(6)],
            'specialty' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => 'karyawan',
            'specialty' => $validated['specialty'],
            'address' => $validated['address'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.employees.index')
                         ->with('success', 'Data Karyawan / Mekanik baru berhasil ditambahkan!');
    }

    public function edit(int $id): View
    {
        $employee = User::where('role', 'karyawan')->findOrFail($id);
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $employee = User::where('role', 'karyawan')->findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $employee->id],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['nullable', Password::min(6)],
            'specialty' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $employee->name = $validated['name'];
        $employee->email = $validated['email'];
        $employee->phone = $validated['phone'];
        $employee->specialty = $validated['specialty'];
        $employee->address = $validated['address'] ?? null;
        $employee->is_active = $request->boolean('is_active', true);

        if (!empty($validated['password'])) {
            $employee->password = Hash::make($validated['password']);
        }

        $employee->save();

        return redirect()->route('admin.employees.index')
                         ->with('success', 'Data Karyawan berhasil diperbarui!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $employee = User::where('role', 'karyawan')->findOrFail($id);
        $employee->delete();

        return redirect()->route('admin.employees.index')
                         ->with('success', 'Karyawan berhasil dihapus.');
    }
}
