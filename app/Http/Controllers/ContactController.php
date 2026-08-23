<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Display the Contact Us page.
     */
    public function index(): View
    {
        return view('contact.index');
    }

    /**
     * Store a new contact message into database.
     */
    public function store(StoreContactRequest $request): RedirectResponse
    {
        ContactMessage::create($request->validated());

        return redirect()->back()->with('success', 'Thank you for reaching out! Your message has been received and our team will get back to you shortly.');
    }
}
