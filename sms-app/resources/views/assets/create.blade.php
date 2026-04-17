@extends('layouts.app')

@section('title', 'Add Asset | EduCore SMS')
@section('page_title', 'New Asset')
@section('breadcrumb', '/ Assets / New')

@section('content')
    <div class="data-card">
        <form action="{{ route('admin.assets.store') }}" method="POST">
            @csrf
            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="name">Asset Name</label>
                    <input class="form-control-sms" type="text" id="name" name="name" required>
                </div>
                <div>
                    <label class="form-label-sms" for="code">Asset Code / Tag</label>
                    <input class="form-control-sms" type="text" id="code" name="code" placeholder="e.g. LAP-001" required>
                </div>
            </div>

            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="asset_category_id">Category</label>
                    <select class="filter-select" id="asset_category_id" name="asset_category_id" required>
                        <option value="">Select Category...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label-sms" for="condition">Condition</label>
                    <select class="filter-select" id="condition" name="condition" required>
                        <option value="new">New</option>
                        <option value="used">Used</option>
                        <option value="broken">Broken</option>
                    </select>
                </div>
            </div>

            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="purchase_date">Purchase Date</label>
                    <input class="form-control-sms" type="date" id="purchase_date" name="purchase_date">
                </div>
                <div>
                    <label class="form-label-sms" for="purchase_cost">Purchase Cost (PKR)</label>
                    <input class="form-control-sms" type="number" step="0.01" id="purchase_cost" name="purchase_cost" value="0" required>
                </div>
            </div>

            <div style="margin-bottom:2rem;">
                <label class="form-label-sms" for="status">Initial Status</label>
                <select class="filter-select" id="status" name="status" required>
                    <option value="available">Available</option>
                    <option value="in_use">In Use</option>
                    <option value="disposed">Disposed</option>
                </select>
            </div>

            <div style="display:flex;gap:1rem;">
                <button class="btn-primary-sms" type="submit" style="padding:1rem 3rem;"><i class="bi bi-save"></i> Record Asset</button>
                <a class="btn-outline-sms" href="{{ route('admin.assets.index') }}" style="padding:1rem 3rem;">Cancel</a>
            </div>
        </form>
    </div>
@endsection
