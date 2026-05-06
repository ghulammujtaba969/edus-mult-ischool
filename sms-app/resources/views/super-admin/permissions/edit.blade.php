@extends('layouts.app')

@section('title', 'Edit Permission | SaaSAdmin')
@section('page_title', 'Edit Permission')
@section('breadcrumb', 'Super Admin / Access Control / Permissions / Edit')

@section('content')
<div class="page-header mb-4">
    <div class="container-fluid p-0">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('super-admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('super-admin.permissions.index') }}">Permissions</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
                <h1 class="h3 font-weight-bold text-dark mb-0">Edit Permission: {{ $permission->name }}</h1>
                <p class="text-muted small mb-0 mt-1">Update granular access capability settings for the system.</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('super-admin.permissions.index') }}" class="btn-outline-sms px-4">
                    <i class="bi bi-arrow-left mr-2"></i> Back to Permissions
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid p-0">
    <form action="{{ route('super-admin.permissions.update', $permission) }}" method="POST" class="has-sticky-bar">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-8">
                <div class="card-sms shadow-sm mb-4">
                    <div class="card-header-sms py-3 px-4 border-bottom">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-shield-check mr-2"></i> Permission Details
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label-sms">Permission Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control-sms @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name', $permission->name) }}"
                                       placeholder="e.g. View Audit Logs" required autofocus>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="module" class="form-label-sms">Module / Group <span class="text-danger">*</span></label>
                                <input type="text" class="form-control-sms @error('module') is-invalid @enderror"
                                       id="module" name="module" value="{{ old('module', $permission->module) }}"
                                       placeholder="e.g. System Logs" required>
                                @error('module') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-0">
                            <label for="description" class="form-label-sms">Functional Description</label>
                            <textarea class="form-control-sms @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="3"
                                      placeholder="Briefly describe what this permission allows the user to do...">{{ old('description', $permission->description) }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card-sms shadow-sm mb-4 sticky-top" style="top: 20px;">
                    <div class="card-header-sms py-3 px-4 border-bottom">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-info-circle mr-2"></i> Metadata
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="metadata-item mb-4">
                            <label class="small text-muted mb-1 d-block font-weight-bold text-uppercase">System Identifier</label>
                            <div class="mono small text-primary bg-light p-2 rounded border">{{ $permission->slug }}</div>
                            <small class="text-muted mt-1 d-block italic">The slug is used for programmatic checks and cannot be changed.</small>
                        </div>
                        <div class="metadata-item mb-4">
                            <label class="small text-muted mb-1 d-block font-weight-bold text-uppercase">Creation Date</label>
                            <div class="small font-weight-bold text-dark">
                                <i class="bi bi-calendar-event mr-1"></i>
                                {{ $permission->created_at->format('M d, Y') }}
                            </div>
                        </div>
                        <div class="metadata-item mb-0">
                            <label class="small text-muted mb-1 d-block font-weight-bold text-uppercase">Last Modification</label>
                            <div class="small font-weight-bold text-dark">
                                <i class="bi bi-clock-history mr-1"></i>
                                {{ $permission->updated_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="sticky-save-bar">
            <div class="container-fluid d-flex justify-content-end align-items-center gap-2">
                <span class="text-muted small d-none d-md-inline mr-3">Permission updates will apply immediately to all assigned roles</span>
                <button type="submit" class="btn-primary-sms px-5 shadow-sm">
                    <i class="bi bi-check-lg mr-2"></i> Update Permission
                </button>
            </div>
        </div>
    </form>
</div>

@push('styles')
<style>
    .has-sticky-bar { padding-bottom: 80px; }
</style>
@endpush
@endsection
