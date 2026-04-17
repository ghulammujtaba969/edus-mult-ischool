@extends('layouts.app')

@section('title', 'New Assignment | EduCore SMS')
@section('page_title', 'Asset Assignment')
@section('breadcrumb', '/ Assets / New Assignment')

@section('content')
    <div class="data-card">
        <form action="{{ route('admin.asset-assignments.store') }}" method="POST">
            @csrf
            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="asset_id">Select Asset</label>
                    <select class="filter-select" id="asset_id" name="asset_id" required>
                        <option value="">Choose Available Asset...</option>
                        @foreach($assets as $asset)
                            <option value="{{ $asset->id }}" @selected($selectedAssetId == $asset->id)>
                                {{ $asset->code }} - {{ $asset->name }} ({{ $asset->category->name }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label-sms" for="assigned_to">Assign To</label>
                    <select class="filter-select" id="assigned_to" name="assigned_to" onchange="updateAssignedTo(this)" required>
                        <option value="">Choose Person...</option>
                        <optgroup label="Employees">
                            @foreach($employees as $employee)
                                <option value="App\Models\Employee:{{ $employee->id }}">{{ $employee->user->name }} (Staff)</option>
                            @endforeach
                        </optgroup>
                        <optgroup label="Students">
                            @foreach($students as $student)
                                <option value="App\Models\Student:{{ $student->id }}">{{ $student->user->name }} (Student)</option>
                            @endforeach
                        </optgroup>
                    </select>
                    <input type="hidden" id="assigned_to_type" name="assigned_to_type">
                    <input type="hidden" id="assigned_to_id" name="assigned_to_id">
                </div>
            </div>

            <div style="margin-bottom:1.5rem;">
                <label class="form-label-sms" for="assigned_at">Assignment Date</label>
                <input class="form-control-sms" type="date" id="assigned_at" name="assigned_at" value="{{ date('Y-m-d') }}" required>
            </div>

            <div style="margin-bottom:2rem;">
                <label class="form-label-sms" for="notes">Notes / Purpose</label>
                <textarea class="form-control-sms" id="notes" name="notes" rows="2"></textarea>
            </div>

            <div style="display:flex;gap:1rem;">
                <button class="btn-primary-sms" type="submit" style="padding:1rem 3rem;"><i class="bi bi-person-check"></i> Assign Asset</button>
                <a class="btn-outline-sms" href="{{ route('admin.asset-assignments.index') }}" style="padding:1rem 3rem;">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        function updateAssignedTo(select) {
            const val = select.value;
            if (val) {
                const parts = val.split(':');
                document.getElementById('assigned_to_type').value = parts[0];
                document.getElementById('assigned_to_id').value = parts[1];
            } else {
                document.getElementById('assigned_to_type').value = '';
                document.getElementById('assigned_to_id').value = '';
            }
        }
    </script>
@endsection
