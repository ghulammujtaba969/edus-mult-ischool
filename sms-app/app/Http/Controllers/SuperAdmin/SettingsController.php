<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SettingsController extends Controller
{
    public function index(): View
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('super-admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $settings = $request->except('_token');

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->route('super-admin.settings.index')
            ->with('success', 'Platform settings updated successfully.');
    }
}
