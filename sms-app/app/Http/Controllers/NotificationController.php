<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(): View
    {
        $notifications = Notification::latest()->paginate(15);
        return view('notifications.index', compact('notifications'));
    }

    public function create(): View
    {
        return view('notifications.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'type' => 'required|string|in:announcement,emergency,event',
            'target_role' => 'nullable|string',
        ]);

        Notification::create([
            'campus_id' => auth()->user()->campus_id,
            'title' => $validated['title'],
            'body' => $validated['body'],
            'type' => $validated['type'],
            'target_role' => $validated['target_role'],
            'sent_at' => now(),
        ]);

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notification sent successfully.');
    }
}
