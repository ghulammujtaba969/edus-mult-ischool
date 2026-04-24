@extends('layouts.app')

@section('title', 'Suppliers | EduCore SMS')
@section('page_title', 'Inventory Suppliers')
@section('breadcrumb', '/ Inventory / Suppliers')

@section('topbar_actions')
    <a class="btn-primary-sms" href="{{ route('admin.inventory-suppliers.create') }}"><i class="bi bi-person-plus-fill"></i> Add Supplier</a>
@endsection

@section('content')
    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Supplier Name</th>
                <th>Contact Person</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($suppliers as $supplier)
                <tr>
                    <td style="font-weight:700;">{{ $supplier->name }}</td>
                    <td>{{ $supplier->contact_person }}</td>
                    <td class="mono">{{ $supplier->phone }}</td>
                    <td>{{ $supplier->email }}</td>
                    <td>
                        <button class="btn-outline-sms" onclick="alert('Address: {{ $supplier->address }}')"><i class="bi bi-info-circle"></i></button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:2rem;color:var(--text-light);">No suppliers added.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
