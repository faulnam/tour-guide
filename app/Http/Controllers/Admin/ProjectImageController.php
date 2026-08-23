<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectImageController extends Controller
{
    /**
     * Delete an individual gallery image.
     */
    public function destroy(Project $project, ProjectImage $image): RedirectResponse|JsonResponse
    {
        if ($image->image_path && !str_starts_with($image->image_path, 'http') && Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Gallery image deleted successfully!');
    }

    /**
     * Reorder gallery images.
     */
    public function reorder(Request $request, Project $project): JsonResponse
    {
        $orderData = $request->input('orders', []); // [imageId => orderNumber]

        foreach ($orderData as $id => $order) {
            ProjectImage::where('id', $id)
                ->where('project_id', $project->id)
                ->update(['order' => (int) $order]);
        }

        return response()->json(['success' => true]);
    }
}
