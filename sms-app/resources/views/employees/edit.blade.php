@extends('layouts.app')

@section('title', 'Edit Employee | EduCore SMS')
@section('page_title', 'Edit Employee')
@section('breadcrumb', '/ Staff / ' . $employee->user->name . ' / Edit')

@section('content')
    <div class="data-card" style="max-width:800px;margin:0 auto;">
        <div class="card-title">Employee Details</div>
        <form action="{{ route('admin.employees.update', $employee) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="name">Full Name</label>
                    <input class="form-control-sms @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name', $employee->user->name) }}" required>
                    @error('name') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="email">Email Address</label>
                    <input class="form-control-sms @error('email') is-invalid @enderror" type="email" id="email" name="email" value="{{ old('email', $employee->user->email) }}" required>
                    @error('email') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="phone">Phone Number</label>
                    <input class="form-control-sms @error('phone') is-invalid @enderror" type="text" id="phone" name="phone" value="{{ old('phone', $employee->phone) }}" required>
                    @error('phone') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="role">User Role</label>
                    <select class="filter-select @error('role') is-invalid @enderror" id="role" name="role" required>
                        @foreach($roles as $value => $label)
                            <option value="{{ $value }}" @selected(old('role', $employee->user->role->value) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('role') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="employee_code">Employee Code</label>
                    <input class="form-control-sms @error('employee_code') is-invalid @enderror" type="text" id="employee_code" name="employee_code" value="{{ old('employee_code', $employee->employee_code) }}" required>
                    @error('employee_code') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="joining_date">Joining Date</label>
                    <input class="form-control-sms @error('joining_date') is-invalid @enderror" type="date" id="joining_date" name="joining_date" value="{{ old('joining_date', $employee->joining_date->format('Y-m-d')) }}" required>
                    @error('joining_date') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="designation">Designation</label>
                    <input class="form-control-sms @error('designation') is-invalid @enderror" type="text" id="designation" name="designation" value="{{ old('designation', $employee->designation) }}" required>
                    @error('designation') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="department">Department</label>
                    <input class="form-control-sms @error('department') is-invalid @enderror" type="text" id="department" name="department" value="{{ old('department', $employee->department) }}">
                    @error('department') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="info-grid-2" style="margin-bottom:2rem;">
                <div>
                    <label class="form-label-sms" for="cnic">CNIC / ID Card</label>
                    <input class="form-control-sms @error('cnic') is-invalid @enderror" type="text" id="cnic" name="cnic" value="{{ old('cnic', $employee->cnic) }}">
                    @error('cnic') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label-sms" for="status">Status</label>
                    <select class="filter-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        @foreach(['active' => 'Active', 'inactive' => 'Inactive', 'on_leave' => 'On Leave'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', $employee->status) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="display:flex;gap:1rem;">
                <button class="btn-primary-sms" type="submit"><i class="bi bi-save"></i> Save Changes</button>
                <a class="btn-outline-sms" href="{{ route('admin.employees.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
