@extends('layouts.app')

@section('title', 'Add Inventory Item | EduCore SMS')
@section('page_title', 'Add Inventory Item')
@section('breadcrumb', '/ Inventory / Items / New')

@section('topbar_actions')
    <a class="btn-outline-sms" href="{{ route('admin.inventory-items.index') }}"><i class="bi bi-arrow-left"></i> Back</a>
@endsection

@section('content')
    <div class="data-card">
        <form action="{{ route('admin.inventory-items.store') }}" method="POST">
            @csrf

            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="name">Item Name</label>
                    <input class="form-control-sms @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Whiteboard markers" required>
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="category">Category</label>
                    <select class="filter-select @error('category') is-invalid @enderror" id="category" name="category" required>
                        <option value="">Select category...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->name }}" @selected(old('category') === $category->name)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                    @if($categories->isEmpty())
                        <div class="text-danger small mt-1">Add an asset category first from Asset Management.</div>
                    @endif
                </div>
            </div>

            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;">
                        <label class="form-label-sms" for="inventory_supplier_id">Supplier</label>
                        <a href="{{ route('admin.inventory-suppliers.create') }}" style="font-size:.85rem;font-weight:700;color:var(--primary);text-decoration:none;">
                            <i class="bi bi-plus-lg"></i> Add Supplier
                        </a>
                    </div>
                    <select class="filter-select @error('inventory_supplier_id') is-invalid @enderror" id="inventory_supplier_id" name="inventory_supplier_id">
                        <option value="">No supplier selected</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" @selected(old('inventory_supplier_id') == $supplier->id)>{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                    @error('inventory_supplier_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="unit">Unit</label>
                    <input class="form-control-sms @error('unit') is-invalid @enderror" type="text" id="unit" name="unit" value="{{ old('unit', 'pcs') }}" placeholder="pcs, box, ream" required>
                    @error('unit')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="info-grid-2" style="margin-bottom:2rem;">
                <div>
                    <label class="form-label-sms" for="quantity">Opening Quantity</label>
                    <input class="form-control-sms @error('quantity') is-invalid @enderror" type="number" min="0" step="1" id="quantity" name="quantity" value="{{ old('quantity', 0) }}" required>
                    @error('quantity')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="unit_price">Unit Price (PKR)</label>
                    <input class="form-control-sms @error('unit_price') is-invalid @enderror" type="number" min="0" step="0.01" id="unit_price" name="unit_price" value="{{ old('unit_price', 0) }}" required>
                    @error('unit_price')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div style="display:flex;gap:1rem;flex-wrap:wrap;">
                <button class="btn-primary-sms" type="submit" style="padding:1rem 3rem;"><i class="bi bi-save"></i> Save Item</button>
                <a class="btn-outline-sms" href="{{ route('admin.inventory-items.index') }}" style="padding:1rem 3rem;">Cancel</a>
            </div>
        </form>
    </div>
@endsection
