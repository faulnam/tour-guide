<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClientRequest;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ClientController extends Controller
{
    /**
     * Display a listing of clients.
     */
    public function index(Request $request): View
    {
        $query = Client::query();

        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $clients = $query->orderBy('order')->latest()->paginate(12)->withQueryString();

        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new client.
     */
    public function create(): View
    {
        return view('admin.clients.create');
    }

    /**
     * Store a newly created client in storage.
     */
    public function store(ClientRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('clients', 'public');
        } else {
            $data['logo'] = '';
        }

        $data['is_active'] = $request->boolean('is_active', true);
        $data['order'] = $request->input('order', 0) ?? 0;

        Client::create($data);

        return redirect()->route('admin.clients.index')->with('success', 'Client partner added successfully!');
    }

    /**
     * Show the form for editing the specified client.
     */
    public function edit(Client $client): View
    {
        return view('admin.clients.edit', compact('client'));
    }

    /**
     * Update the specified client in storage.
     */
    public function update(ClientRequest $request, Client $client): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            if ($client->logo && !str_starts_with($client->logo, 'http') && Storage::disk('public')->exists($client->logo)) {
                Storage::disk('public')->delete($client->logo);
            }
            $data['logo'] = $request->file('logo')->store('clients', 'public');
        }

        $data['is_active'] = $request->boolean('is_active', true);
        $data['order'] = $request->input('order', 0) ?? 0;

        $client->update($data);

        return redirect()->route('admin.clients.index')->with('success', 'Client partner updated successfully!');
    }

    /**
     * Remove the specified client from storage.
     */
    public function destroy(Client $client): RedirectResponse
    {
        if ($client->logo && !str_starts_with($client->logo, 'http') && Storage::disk('public')->exists($client->logo)) {
            Storage::disk('public')->delete($client->logo);
        }

        $client->delete();

        return redirect()->route('admin.clients.index')->with('success', 'Client partner removed successfully!');
    }
}
