<?php

namespace App\Http\Controllers;

use App\Models\LibraryBook;
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

        LibraryBook::create(array_merge($validated, [
            'available_quantity' => $validated['quantity']
        ]));

        return redirect()->route('admin.library-books.index')
            ->with('success', 'Book added successfully.');
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
}
