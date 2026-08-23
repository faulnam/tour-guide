<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsletterRequest;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;

class NewsletterController extends Controller
{
    /**
     * Subscribe email to newsletter.
     */
    public function store(StoreNewsletterRequest $request): RedirectResponse
    {
        NewsletterSubscriber::updateOrCreate(
            ['email' => $request->email],
            [
                'is_active' => true,
                'subscribed_at' => now(),
            ]
        );

        return redirect()->back()->with('success', 'Thank you for subscribing to our newsletter!');
    }
}
