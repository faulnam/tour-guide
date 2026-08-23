<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class PageContentController extends Controller
{
    /**
     * Show page contents copywriting editor form.
     */
    public function edit(): View
    {
        $contents = PageContent::all()->groupBy('page');

        return view('admin.page-contents.edit', compact('contents'));
    }

    /**
     * Update page contents.
     */
    public function update(Request $request): RedirectResponse
    {
        $items = $request->input('contents', []); // [key => value]

        foreach ($items as $key => $value) {
            PageContent::where('key', $key)->update([
                'value' => is_null($value) ? '' : $value,
            ]);
        }

        Cache::forget('page_contents_all');

        return redirect()->route('admin.page-contents.edit')->with('success', 'Page contents copywriting updated successfully!');
    }
}
