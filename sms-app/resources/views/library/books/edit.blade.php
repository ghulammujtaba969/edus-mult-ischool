@extends('layouts.app')

@section('title', 'Edit Book | EduCore SMS')
@section('page_title', 'Edit Library Book')
@section('breadcrumb', '/ Library / Books / Edit')

@section('topbar_actions')
    <a class="btn-outline-sms" href="{{ route('admin.library-books.index') }}"><i class="bi bi-arrow-left"></i> Back</a>
@endsection

@section('content')
    <div class="data-card">
        <form action="{{ route('admin.library-books.update', $book) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="title">Book Title</label>
                    <input class="form-control-sms @error('title') is-invalid @enderror" type="text" id="title" name="title" value="{{ old('title', $book->title) }}" required>
                    @error('title')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="author">Author</label>
                    <input class="form-control-sms @error('author') is-invalid @enderror" type="text" id="author" name="author" value="{{ old('author', $book->author) }}">
                    @error('author')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="isbn_no">ISBN No</label>
                    <input class="form-control-sms @error('isbn_no') is-invalid @enderror" type="text" id="isbn_no" name="isbn_no" value="{{ old('isbn_no', $book->isbn_no) }}">
                    @error('isbn_no')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="publisher">Publisher</label>
                    <input class="form-control-sms @error('publisher') is-invalid @enderror" type="text" id="publisher" name="publisher" value="{{ old('publisher', $book->publisher) }}">
                    @error('publisher')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="info-grid-3" style="margin-bottom:2rem;">
                <div>
                    <label class="form-label-sms" for="rack_no">Rack No</label>
                    <input class="form-control-sms @error('rack_no') is-invalid @enderror" type="text" id="rack_no" name="rack_no" value="{{ old('rack_no', $book->rack_no) }}">
                    @error('rack_no')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="quantity">Quantity</label>
                    <input class="form-control-sms @error('quantity') is-invalid @enderror" type="number" min="1" step="1" id="quantity" name="quantity" value="{{ old('quantity', $book->quantity) }}" required>
                    @error('quantity')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="price">Price (PKR)</label>
                    <input class="form-control-sms @error('price') is-invalid @enderror" type="number" min="0" step="0.01" id="price" name="price" value="{{ old('price', $book->price) }}" required>
                    @error('price')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div style="display:flex;gap:1rem;flex-wrap:wrap;">
                <button class="btn-primary-sms" type="submit" style="padding:1rem 3rem;"><i class="bi bi-save"></i> Update Book</button>
                <a class="btn-outline-sms" href="{{ route('admin.library-books.index') }}" style="padding:1rem 3rem;">Cancel</a>
            </div>
        </form>
    </div>
@endsection
