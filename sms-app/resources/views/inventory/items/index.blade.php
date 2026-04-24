@extends('layouts.app')

@section('title', 'Inventory Items | EduCore SMS')
@section('page_title', 'Consumable Inventory')
@section('breadcrumb', '/ Inventory / Items')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.inventory-items.create') }}"><i class="bi bi-plus-lg"></i> Add Item</a>
@endsection

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Item Name</th>
                <th>Category</th>
                <th>Supplier</th>
                <th>Total Qty</th>
                <th>Available</th>
                <th>Unit Price</th>
            </tr>
            </thead>
            <tbody>
            @forelse($items as $item)
                <tr>
                    <td style="font-weight:700;">{{ $item->name }}</td>
                    <td><span class="nav-badge">{{ ucfirst($item->category) }}</span></td>
                    <td>{{ $item->supplier->name ?? 'N/A' }}</td>
                    <td class="mono">{{ $item->quantity }} {{ $item->unit }}</td>
                    <td class="mono">
                        <span style="color:{{ $item->available_quantity > 0 ? 'var(--success)' : 'var(--danger)' }};">
                            {{ $item->available_quantity }} {{ $item->unit }}
                        </span>
                    </td>
                    <td class="mono">PKR {{ number_format($item->unit_price) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:2rem;color:var(--text-light);">No items in inventory.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
