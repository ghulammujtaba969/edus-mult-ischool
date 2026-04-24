@extends('layouts.app')

@section('title', 'Library Books | EduCore SMS')
@section('page_title', 'Book Catalog')
@section('breadcrumb', '/ Library / Books')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.library-books.create') }}"><i class="bi bi-plus-lg"></i> Add Book</a>
@endsection

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Rack No</th>
                <th>Qty</th>
                <th>Available</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($books as $book)
                <tr>
                    <td style="font-weight:700;">{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td class="mono">{{ $book->rack_no }}</td>
                    <td class="mono">{{ $book->quantity }}</td>
                    <td class="mono">
                        <span style="color:{{ $book->available_quantity > 0 ? 'var(--success)' : 'var(--danger)' }};">
                            {{ $book->available_quantity }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="{{ route('admin.library-books.edit', $book) }}"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.library-books.destroy', $book) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-outline-sms" style="color:var(--danger);" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:2rem;color:var(--text-light);">No books found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
