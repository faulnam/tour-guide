<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\View\View;

class ClientController extends Controller
{
    /**
     * Display the Clients page.
     */
    public function index(): View
    {
        $clients = Client::active()
            ->ordered()
            ->get();

        return view('clients.index', compact('clients'));
    }
}
