@extends('layouts.app')

@section('title', 'Add Campus | EduCore SMS')
@section('page_title', 'Add Campus')
@section('breadcrumb', '/ Academic Setup / Campuses / Add')

@section('content')
    <div class="data-card">
        <form action="{{ route('admin.campuses.store') }}" method="POST">
            @csrf
            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="name">Campus Name</label>
                    <input class="form-control-sms @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="code">Campus Code</label>
                    <input class="form-control-sms @error('code') is-invalid @enderror" type="text" id="code" name="code" value="{{ old('code') }}" required>
                    @error('code') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="city">City</label>
                    <input class="form-control-sms" type="text" id="city" name="city" value="{{ old('city') }}">
                </div>
                <div>
                    <label class="form-label-sms" for="phone">Phone</label>
                    <input class="form-control-sms" type="text" id="phone" name="phone" value="{{ old('phone') }}">
                </div>
            </div>

            <div style="margin-bottom:1.5rem;">
                <label class="form-label-sms" for="email">Email</label>
                <input class="form-control-sms" type="email" id="email" name="email" value="{{ old('email') }}">
            </div>

            <div style="margin-bottom:1.5rem;">
                <label class="form-label-sms" for="address">Address</label>
                <textarea class="form-control-sms" id="address" name="address" rows="3">{{ old('address') }}</textarea>
            </div>

            <div style="margin-bottom:2rem;">
                <label class="form-label-sms" style="display:flex;align-items:center;gap:.5rem;cursor:pointer;">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} style="width:1.2rem;height:1.2rem;">
                    <span>Active Campus</span>
                </label>
            </div>

            <div style="display:flex;gap:1rem;">
                <button class="btn-primary-sms" type="submit" style="padding:1rem 3rem;"><i class="bi bi-save"></i> Save Campus</button>
                <a class="btn-outline-sms" href="{{ route('admin.campuses.index') }}" style="padding:1rem 3rem;">Cancel</a>
            </div>
        </form>
    </div>
@endsection
