@extends('layouts.app')

@section('title', 'Inventory Report | EduCore SMS')
@section('page_title', 'Inventory Status')
@section('breadcrumb', '/ Reports / Inventory')

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Item Name</th>
                <th>Category</th>
                <th>Supplier</th>
                <th>Total Stock</th>
                <th>Available</th>
                <th>Unit Price</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @forelse($items as $item)
                <tr>
                    <td style="font-weight:700;">{{ $item->name }}</td>
                    <td><span class="badge-sms badge-outline-sms">{{ $item->category }}</span></td>
                    <td>{{ $item->supplier->name ?? '--' }}</td>
                    <td class="mono">{{ $item->quantity }} {{ $item->unit }}</td>
                    <td class="mono" style="font-weight:700;">{{ $item->available_quantity }} {{ $item->unit }}</td>
                    <td class="mono">{{ number_format($item->unit_price, 2) }}</td>
                    <td>
                        @if($item->available_quantity <= 5)
                            <span class="badge-sms badge-danger-sms">Low Stock</span>
                        @else
                            <span class="badge-sms badge-success-sms">In Stock</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:2rem;color:var(--text-light);">No inventory items found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
