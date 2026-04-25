@extends('layouts.app')

@section('title', 'Manage User Permissions')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Permissions for: {{ $user->name }}</h1>
        <a href="{{ route('super-admin.users.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Users
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">User Role: {{ $user->role->name }}</h6>
        </div>
        <div class="card-body">
            @if($user->isSuperAdmin())
                <div class="alert alert-info">
                    <strong>Note:</strong> This user is a Super Admin and has all permissions by default.
                </div>
            @endif

            <form action="{{ route('super-admin.users.permissions.update', $user) }}" method="POST">
                @csrf
                @foreach($permissions as $module => $modulePermissions)
                    <div class="mb-4">
                        <h5 class="text-dark font-weight-bold border-bottom pb-2">{{ $module }}</h5>
                        <div class="row">
                            @foreach($modulePermissions as $permission)
                                <div class="col-md-3 mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                            class="custom-control-input" id="perm-{{ $permission->id }}"
                                            {{ in_array($permission->id, $userPermissions) ? 'checked' : '' }}
                                            {{ $user->isSuperAdmin() ? 'disabled' : '' }}>
                                        <label class="custom-control-label" for="perm-{{ $permission->id }}">
                                            {{ $permission->name }}
                                            <small class="d-block text-muted">{{ $permission->description }}</small>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                @if(!$user->isSuperAdmin())
                    <hr>
                    <button type="submit" class="btn btn-primary btn-lg px-5">Save Permissions</button>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
