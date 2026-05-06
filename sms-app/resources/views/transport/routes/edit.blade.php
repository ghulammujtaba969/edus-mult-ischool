@extends('layouts.app')

@section('title', 'Edit Transport Route | EduCore SMS')
@section('page_title', 'Edit Transport Route')
@section('breadcrumb', '/ Transport / Routes / Edit')

@section('topbar_actions')
    <a class="btn-outline-sms" href="{{ route('admin.transport-routes.index') }}"><i class="bi bi-arrow-left"></i> Back</a>
@endsection

@section('content')
    <div class="data-card">
        <form action="{{ route('admin.transport-routes.update', $route) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="name">Route Name</label>
                    <input class="form-control-sms @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name', $route->name) }}" required>
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="route_code">Route Code</label>
                    <input class="form-control-sms @error('route_code') is-invalid @enderror" type="text" id="route_code" name="route_code" value="{{ old('route_code', $route->route_code) }}">
                    @error('route_code')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div style="margin-bottom:1.5rem;">
                <label class="form-label-sms" for="fare">Base Fare (PKR)</label>
                <input class="form-control-sms @error('fare') is-invalid @enderror" type="number" min="0" step="0.01" id="fare" name="fare" value="{{ old('fare', $route->fare) }}" required>
                @error('fare')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-bottom:2rem;">
                <label class="form-label-sms" for="description">Description</label>
                <textarea class="form-control-sms @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $route->description) }}</textarea>
                @error('description')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div style="display:flex;gap:1rem;flex-wrap:wrap;">
                <button class="btn-primary-sms" type="submit" style="padding:1rem 3rem;"><i class="bi bi-save"></i> Update Route</button>
                <a class="btn-outline-sms" href="{{ route('admin.transport-routes.index') }}" style="padding:1rem 3rem;">Cancel</a>
            </div>
        </form>
    </div>
@endsection
