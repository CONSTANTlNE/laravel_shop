<?php

namespace App\Http\Controllers;

use App\Models\Social;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'required|string',
            'width' => 'nullable|integer',
            'height' => 'nullable|integer',
            'url' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Social::create($validated);

        return back()->with('alert_success', __('Social link created successfully.'));
    }

    public function update(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'social_id' => 'required|exists:socials,id',
            'name' => 'required|string|max:255',
            'icon' => 'required|string',
            'width' => 'nullable|integer',
            'height' => 'nullable|integer',
            'url' => 'nullable|string',
        ]);

        $social = Social::findOrFail($validated['social_id']);

        $social->update([
            'name' => $validated['name'],
            'icon' => $validated['icon'],
            'width' => $validated['width'],
            'height' => $validated['height'],
            'url' => $validated['url'],
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('alert_success', __('Social link updated successfully.'));
    }

    public function delete(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'social_id' => 'required|exists:socials,id',
        ]);

        $social = Social::findOrFail($request->input('social_id'));
        $social->delete();

        return back()->with('alert_success', __('Social link deleted successfully.'));
    }
}
