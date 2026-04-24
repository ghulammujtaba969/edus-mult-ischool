<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        $settings = Setting::where('campus_id', auth()->user()->campus_id)
            ->orWhereNull('campus_id')
            ->get()
            ->groupBy('group');

        return view('settings.index', compact('settings'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'group' => 'required|string',
        ]);

        foreach ($validated['settings'] as $key => $value) {
            Setting::updateOrCreate(
                [
                    'key' => $key,
                    'campus_id' => auth()->user()->campus_id,
                ],
                [
                    'value' => $value,
                    'group' => $validated['group'],
                ]
            );
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
