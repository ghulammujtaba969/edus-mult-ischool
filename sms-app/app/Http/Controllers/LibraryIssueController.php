<?php

namespace App\Http\Controllers;

use App\Models\LibraryBook;
use App\Models\LibraryIssue;
use App\Models\LibraryMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LibraryIssueController extends Controller
{
    public function index(): View
    {
        $issues = LibraryIssue::with(['book', 'member.user'])->latest()->get();
        return view('library.issues.index', compact('issues'));
    }

    public function create(): View
    {
        $books = LibraryBook::where('available_quantity', '>', 0)->get();
        $members = LibraryMember::with('user')->where('status', 'active')->get();
        return view('library.issues.create', compact('books', 'members'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'library_book_id' => 'required|exists:library_books,id',
            'library_member_id' => 'required|exists:library_members,id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after:issue_date',
        ]);

        $book = LibraryBook::findOrFail($validated['library_book_id']);
        if ($book->available_quantity <= 0) {
            return back()->with('error', 'Book is not available.');
        }

        DB::transaction(function () use ($validated, $book) {
            LibraryIssue::create(array_merge($validated, [
                'campus_id' => auth()->user()->campus_id,
                'status' => 'issued'
            ]));
            $book->decrement('available_quantity');
        });

        return redirect()->route('admin.library-issues.index')
            ->with('success', 'Book issued successfully.');
    }

    public function update(Request $request, LibraryIssue $libraryIssue): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|string|in:returned,lost',
            'return_date' => 'required_if:status,returned|nullable|date',
            'fine_amount' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated, $libraryIssue) {
            $libraryIssue->update($validated);
            if ($validated['status'] === 'returned') {
                $libraryIssue->book->increment('available_quantity');
            }
        });

        return redirect()->route('admin.library-issues.index')
            ->with('success', 'Book record updated.');
    }
}
