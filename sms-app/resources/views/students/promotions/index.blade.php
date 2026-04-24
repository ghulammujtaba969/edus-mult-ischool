@extends('layouts.app')

@section('title', 'Student Promotions | EduCore SMS')
@section('page_title', 'Student Promotions')
@section('breadcrumb', '/ Students / Promotions')

@section('content')
    <!-- Step 1: Filter Students -->
    <div class="data-card" style="margin-bottom:2rem;">
        <div class="card-title">Step 1: Select Students to Promote</div>
        <form action="{{ route('admin.promotions.index') }}" method="GET" style="display:grid;grid-template-columns:1fr 1fr 1fr auto;gap:1.5rem;align-items:end;">
            <div>
                <label class="form-label-sms">Academic Year</label>
                <select name="academic_year_id" class="form-control-sms" required>
                    <option value="">-- Select Year --</option>
                    @foreach($academicYears as $year)
                        <option value="{{ $year->id }}" @selected($selectedYear == $year->id)>{{ $year->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label-sms">Class</label>
                <select name="class_id" class="form-control-sms" required>
                    <option value="">-- Select Class --</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" @selected($selectedClass == $class->id)>{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label-sms">Section</label>
                <select name="section_id" class="form-control-sms" required>
                    <option value="">-- Select Section --</option>
                    @foreach($sections as $section)
                        <option value="{{ $section->id }}" @selected($selectedSection == $section->id)>{{ $section->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn-primary-sms"><i class="bi bi-filter"></i> Filter Students</button>
        </form>
    </div>

    @if(count($students) > 0)
        <!-- Step 2: Promotion Form -->
        <form action="{{ route('admin.promotions.store') }}" method="POST">
            @csrf
            <input type="hidden" name="from_year_id" value="{{ $selectedYear }}">
            <input type="hidden" name="from_class_id" value="{{ $selectedClass }}">
            <input type="hidden" name="from_section_id" value="{{ $selectedSection }}">

            <div style="display:grid;grid-template-columns:2fr 1fr;gap:2rem;">
                <!-- Student List -->
                <div class="data-card">
                    <div class="card-title">Select Students</div>
                    <table class="sms-table">
                        <thead>
                        <tr>
                            <th style="width:50px;"><input type="checkbox" id="select-all" checked></th>
                            <th>Reg No.</th>
                            <th>Student Name</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td><input type="checkbox" name="student_ids[]" value="{{ $student->id }}" class="student-checkbox" checked></td>
                                <td class="mono">{{ $student->admission_no }}</td>
                                <td style="font-weight:700;">{{ $student->user->name }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Target Selection -->
                <div class="data-card" style="height:fit-content;">
                    <div class="card-title">Step 2: Promotion Details</div>
                    <div style="margin-bottom:1.5rem;">
                        <label class="form-label-sms">Promote to Year</label>
                        <select name="to_year_id" class="form-control-sms" required>
                            <option value="">-- Select Target Year --</option>
                            @foreach($academicYears as $year)
                                @if($year->id != $selectedYear)
                                    <option value="{{ $year->id }}">{{ $year->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div style="margin-bottom:1.5rem;">
                        <label class="form-label-sms">Promote to Class</label>
                        <select name="to_class_id" class="form-control-sms" required>
                            <option value="">-- Select Target Class --</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="margin-bottom:2rem;">
                        <label class="form-label-sms">Promote to Section</label>
                        <select name="to_section_id" class="form-control-sms" required>
                            <option value="">-- Select Target Section --</option>
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn-primary-sms w-full" onclick="return confirm('Are you sure you want to promote the selected students?')">
                        <i class="bi bi-arrow-up-circle"></i> Promote Students
                    </button>
                </div>
            </div>
        </form>
    @elseif($selectedClass)
        <div class="data-card" style="text-align:center;padding:3rem;color:var(--text-light);">
            <i class="bi bi-people" style="font-size:3rem;display:block;margin-bottom:1rem;"></i>
            No students found in the selected class/section for this year.
        </div>
    @endif

    <script>
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.student-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    </script>
@endsection
