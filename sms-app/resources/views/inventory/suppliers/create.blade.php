@extends('layouts.app')

@section('title', 'Add Supplier | EduCore SMS')
@section('page_title', 'Add Supplier')
@section('breadcrumb', '/ Inventory / Suppliers / New')

@section('topbar_actions')
    <a class="btn-outline-sms" href="{{ route('admin.inventory-suppliers.index') }}"><i class="bi bi-arrow-left"></i> Back</a>
@endsection

@section('content')
    <div class="data-card">
        <form action="{{ route('admin.inventory-suppliers.store') }}" method="POST">
            @csrf

            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="name">Supplier Name</label>
                    <input class="form-control-sms @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Allied Stationers" required>
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="contact_person">Contact Person</label>
                    <input class="form-control-sms @error('contact_person') is-invalid @enderror" type="text" id="contact_person" name="contact_person" value="{{ old('contact_person') }}" placeholder="e.g. Ahmed Khan">
                    @error('contact_person')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="phone">Phone</label>
                    <input class="form-control-sms @error('phone') is-invalid @enderror" type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+92 300 0000000">
                    @error('phone')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="email">Email</label>
                    <input class="form-control-sms @error('email') is-invalid @enderror" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="supplier@example.com">
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div style="margin-bottom:2rem;">
                <label class="form-label-sms" for="address">Address</label>
                <textarea class="form-control-sms @error('address') is-invalid @enderror" id="address" name="address" rows="3" placeholder="Street, city, region">{{ old('address') }}</textarea>
                @error('address')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div style="display:flex;gap:1rem;flex-wrap:wrap;">
                <button class="btn-primary-sms" type="submit" style="padding:1rem 3rem;"><i class="bi bi-save"></i> Save Supplier</button>
                <a class="btn-outline-sms" href="{{ route('admin.inventory-suppliers.index') }}" style="padding:1rem 3rem;">Cancel</a>
            </div>
        </form>
    </div>
@endsection
