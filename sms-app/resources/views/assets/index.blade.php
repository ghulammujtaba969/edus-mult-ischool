@extends('layouts.app')

@section('title', 'Assets | EduCore SMS')
@section('page_title', 'Asset Management')
@section('breadcrumb', '/ Assets / All Assets')

@section('topbar_actions')
    <div style="display:flex;gap:.5rem;">
        <button class="btn-outline-sms" onclick="document.getElementById('category-modal').style.display='flex'"><i class="bi bi-tag"></i> Categories</button>
        <a class="btn-primary-sms" href="{{ route('admin.assets.create') }}"><i class="bi bi-plus-lg"></i> Add Asset</a>
    </div>
@endsection

@push('styles')
    <style>
        .assets-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 320px;
            gap: 1.25rem;
            align-items: start;
        }

        .assets-table-card,
        .assets-category-card {
            min-width: 0;
        }

        .assets-table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        .assets-table {
            min-width: 760px;
        }

        .assets-table th:last-child,
        .assets-table td:last-child {
            width: 120px;
            text-align: right;
        }

        .assets-actions {
            display: flex;
            justify-content: flex-end;
            gap: .5rem;
        }

        .assets-empty {
            text-align: center;
            padding: 3.5rem 1rem;
            color: var(--text-light);
            font-weight: 500;
        }

        .assets-category-list {
            list-style: none;
            padding: 0;
            margin: .75rem 0 0;
        }

        .assets-category-list li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding: .85rem 0;
            border-bottom: 1px solid var(--border);
        }

        .assets-category-list li:last-child {
            border-bottom: 0;
        }

        .assets-category-name {
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-weight: 700;
        }

        @media (max-width: 1100px) {
            .assets-layout {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <div class="assets-layout">
        <div class="profile-card assets-table-card">
            <div class="card-title">Inventory List</div>
            <div class="assets-table-wrap">
                <table class="sms-table assets-table">
                    <thead>
                    <tr>
                        <th>Asset Code</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Condition</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($assets as $asset)
                        <tr>
                            <td class="mono" style="font-weight:700;">{{ $asset->code }}</td>
                            <td>{{ $asset->name }}</td>
                            <td>{{ $asset->category->name }}</td>
                            <td>
                                <span class="status-pill {{ $asset->condition === 'new' ? 'pill-active' : ($asset->condition === 'used' ? 'pill-warning' : 'pill-inactive') }}">
                                    {{ ucfirst($asset->condition) }}
                                </span>
                            </td>
                            <td>
                                <span class="status-pill {{ $asset->status === 'available' ? 'pill-active' : ($asset->status === 'in_use' ? 'pill-partial' : 'pill-inactive') }}">
                                    {{ ucfirst(str_replace('_', ' ', $asset->status)) }}
                                </span>
                            </td>
                            <td>
                                <div class="assets-actions">
                                    <a class="btn-outline-sms" href="{{ route('admin.assets.show', $asset) }}"><i class="bi bi-eye"></i></a>
                                    <a class="btn-outline-sms" href="{{ route('admin.assets.edit', $asset) }}"><i class="bi bi-pencil"></i></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="assets-empty">No assets found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="profile-card assets-category-card">
            <div class="card-title">Categories</div>
            <ul class="assets-category-list">
                @foreach($categories as $cat)
                    <li>
                        <span class="assets-category-name">{{ $cat->name }}</span>
                        <span class="nav-badge">{{ $cat->assets_count }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Category Modal -->
    <div id="category-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);justify-content:center;align-items:center;z-index:1000;">
        <div class="data-card" style="width:100%;max-width:400px;margin:0 1rem;">
            <div class="card-title">New Category</div>
            <form action="{{ route('admin.assets.categories.store') }}" method="POST">
                @csrf
                <div style="margin-bottom:1.25rem;">
                    <label class="form-label-sms">Category Name</label>
                    <input class="form-control-sms" type="text" name="name" required>
                </div>
                <div style="margin-bottom:1.5rem;">
                    <label class="form-label-sms">Description</label>
                    <textarea class="form-control-sms" name="description" rows="2"></textarea>
                </div>
                <div style="display:flex;gap:1rem;">
                    <button class="btn-primary-sms" type="submit" style="flex:1;">Add Category</button>
                    <button class="btn-outline-sms" type="button" onclick="document.getElementById('category-modal').style.display='none'" style="flex:1;justify-content:center;">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endsection
