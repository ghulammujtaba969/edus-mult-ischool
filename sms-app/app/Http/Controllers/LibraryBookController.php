<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\LibraryBook;
use App\Services\CampusManager;
use App\Services\TenantManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LibraryBookController extends Controller
{
    public function index(): View
    {
        $books = LibraryBook::latest()->get();
        return view('library.books.index', compact('books'));
    }

    public function create(): View
    {
        return view('library.books.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'isbn_no' => 'nullable|string|max:50',
            'publisher' => 'nullable|string|max:255',
            'rack_no' => 'nullable|string|max:50',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $tenant = $this->tenantPayload($request);
        if (! $tenant['campus_id']) {
            return back()->withInput()->with('error', 'Please select an active campus before adding a book.');
        }

        LibraryBook::create(array_merge($validated, $tenant, [
            'available_quantity' => $validated['quantity']
        ]));

        return redirect()->route('admin.library-books.index')
            ->with('success', 'Book added successfully.');
    }

    public function show(LibraryBook $libraryBook): View
    {
        $libraryBook->load('issues.member.user');

        return view('library.books.show', ['book' => $libraryBook]);
    }

    public function edit(LibraryBook $libraryBook): View
    {
        return view('library.books.edit', ['book' => $libraryBook]);
    }

    public function update(Request $request, LibraryBook $libraryBook): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'isbn_no' => 'nullable|string|max:50',
            'publisher' => 'nullable|string|max:255',
            'rack_no' => 'nullable|string|max:50',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $diff = $validated['quantity'] - $libraryBook->quantity;
        $libraryBook->update(array_merge($validated, [
            'available_quantity' => $libraryBook->available_quantity + $diff
        ]));

        return redirect()->route('admin.library-books.index')
            ->with('success', 'Book updated successfully.');
    }

    public function destroy(LibraryBook $libraryBook): RedirectResponse
    {
        if ($libraryBook->issues()->where('status', 'issued')->exists()) {
            return back()->with('error', 'Cannot delete book with active issues.');
        }
        $libraryBook->delete();
        return redirect()->route('admin.library-books.index')
            ->with('success', 'Book deleted.');
    }

    private function tenantPayload(Request $request): array
    {
        $user = $request->user();
        $schoolId = app()->bound(TenantManager::class) ? app(TenantManager::class)->getSchoolId() : null;
        $schoolId = $schoolId ?: $user?->school_id;

        $campusId = app()->bound(CampusManager::class) ? app(CampusManager::class)->getScopeCampusId() : null;
        $campusId = $campusId ?: $request->session()->get('active_campus_id') ?: $user?->campus_id;

        if (! $campusId && $schoolId) {
            $campusId = Campus::where('school_id', $schoolId)->value('id');
            if ($campusId) {
                $request->session()->put('active_campus_id', $campusId);
            }
        }

        return [
            'school_id' => $schoolId,
            'campus_id' => $campusId,
        ];
    }
}
