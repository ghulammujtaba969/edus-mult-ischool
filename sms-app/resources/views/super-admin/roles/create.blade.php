@extends('layouts.app')

@section('title', 'Create Global Role')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create Global Role</h1>
        <a href="{{ route('super-admin.roles.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Roles
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('super-admin.roles.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Role Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="2">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <h5 class="mt-4 mb-3 text-primary font-weight-bold border-bottom pb-2">Assign Permissions</h5>
                
                @foreach($permissions as $module => $modulePermissions)
                    <div class="mb-4">
                        <h6 class="text-dark font-weight-bold">{{ $module }}</h6>
                        <div class="row">
                            @foreach($modulePermissions as $permission)
                                <div class="col-md-3 mb-2">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                            class="custom-control-input" id="perm-{{ $permission->id }}"
                                            {{ is_array(old('permissions')) && in_array($permission->id, old('permissions')) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="perm-{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <hr>
                <button type="submit" class="btn btn-primary btn-lg px-5">Create Global Role</button>
            </form>
        </div>
    </div>
</div>
@endsection
