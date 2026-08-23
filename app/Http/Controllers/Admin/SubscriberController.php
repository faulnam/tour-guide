<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SubscriberController extends Controller
{
    public function index(Request $request): View
    {
        $query = NewsletterSubscriber::query();

        if ($search = $request->get('search')) {
            $query->where('email', 'like', "%{$search}%");
        }

        $subscribers = $query->latest('subscribed_at')->paginate(20)->withQueryString();

        return view('admin.subscribers.index', compact('subscribers'));
    }

    /**
     * Export all active subscribers as a CSV file.
     */
    public function export(): StreamedResponse
    {
        $fileName = 'subscribers_' . date('Y-m-d_His') . '.csv';

        $subscribers = NewsletterSubscriber::where('is_active', true)->orderBy('subscribed_at', 'desc')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($subscribers) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Email', 'Subscribed At', 'Status']);

            foreach ($subscribers as $sub) {
                fputcsv($handle, [
                    $sub->id,
                    $sub->email,
                    $sub->subscribed_at ? $sub->subscribed_at->toDateTimeString() : '',
                    $sub->is_active ? 'Active' : 'Unsubscribed',
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    public function destroy(NewsletterSubscriber $subscriber): RedirectResponse
    {
        $subscriber->delete();

        return redirect()->route('admin.subscribers.index')->with('success', 'Subscriber removed successfully!');
    }
}
