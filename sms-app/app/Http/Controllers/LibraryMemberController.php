<?php

namespace App\Http\Controllers;

use App\Models\LibraryMember;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LibraryMemberController extends Controller
{
    public function index(): View
    {
        $members = LibraryMember::with('user')->latest()->get();
        return view('library.members.index', compact('members'));
    }

    public function create(): View
    {
        $users = User::whereDoesntHave('libraryMember')->get();
        return view('library.members.create', compact('users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id|unique:library_members,user_id',
            'library_card_no' => 'required|string|unique:library_members,library_card_no',
        ]);

        LibraryMember::create(array_merge($validated, [
            'campus_id' => auth()->user()->campus_id,
            'status' => 'active'
        ]));

        return redirect()->route('admin.library-members.index')
            ->with('success', 'Library member registered.');
    }

    public function destroy(LibraryMember $libraryMember): RedirectResponse
    {
        if ($libraryMember->issues()->where('status', 'issued')->exists()) {
            return back()->with('error', 'Cannot remove member with active book issues.');
        }
        $libraryMember->delete();
        return redirect()->route('admin.library-members.index')
            ->with('success', 'Member removed.');
    }
}
