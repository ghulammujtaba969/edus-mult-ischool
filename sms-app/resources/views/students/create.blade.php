@extends('layouts.app')

@section('title', 'Enroll Student | EduCore SMS')
@section('page_title', 'Enroll Student')
@section('breadcrumb', '/ Students / Enroll')

@section('content')
    <form action="{{ route('admin.students.store') }}" method="POST" x-data="{ 
        classId: '{{ old('school_class_id') }}',
        sections: @js($sections)
    }">
        @csrf
        <div class="profile-grid">
            <!-- Left Column: Personal Information -->
            <div class="profile-card">
                <div class="card-title">Personal Details</div>
                
                <div style="margin-bottom:1.25rem;">
                    <label class="form-label-sms" for="name">Full Name</label>
                    <input class="form-control-sms @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                </div>

                <div class="info-grid-2" style="margin-bottom:1.25rem;">
                    <div>
                        <label class="form-label-sms" for="gender">Gender</label>
                        <select class="filter-select" id="gender" name="gender" required>
                            <option value="Male" @selected(old('gender') === 'Male')>Male</option>
                            <option value="Female" @selected(old('gender') === 'Female')>Female</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label-sms" for="date_of_birth">Date of Birth</label>
                        <input class="form-control-sms" type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                    </div>
                </div>

                <div class="info-grid-2" style="margin-bottom:1.25rem;">
                    <div>
                        <label class="form-label-sms" for="b_form_no">B-Form / CNIC</label>
                        <input class="form-control-sms" type="text" id="b_form_no" name="b_form_no" value="{{ old('b_form_no') }}" placeholder="e.g. 35202-1234567-1" required>
                    </div>
                    <div>
                        <label class="form-label-sms" for="email">Email (Optional)</label>
                        <input class="form-control-sms" type="email" id="email" name="email" value="{{ old('email') }}">
                    </div>
                </div>

                <div style="margin-bottom:1.25rem;">
                    <label class="form-label-sms" for="address">Residential Address</label>
                    <textarea class="form-control-sms" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                </div>

                <div class="card-title" style="margin-top:2rem;">Guardian Details</div>
                
                <div style="margin-bottom:1.25rem;">
                    <label class="form-label-sms" for="father_name">Father's Name</label>
                    <input class="form-control-sms" type="text" id="father_name" name="father_name" value="{{ old('father_name') }}" required>
                </div>

                <div class="info-grid-2" style="margin-bottom:1.25rem;">
                    <div>
                        <label class="form-label-sms" for="father_phone">Father's Phone</label>
                        <input class="form-control-sms" type="text" id="father_phone" name="father_phone" value="{{ old('father_phone') }}" required>
                    </div>
                    <div>
                        <label class="form-label-sms" for="emergency_contact">Emergency Contact</label>
                        <input class="form-control-sms" type="text" id="emergency_contact" name="emergency_contact" value="{{ old('emergency_contact') }}" required>
                    </div>
                </div>
            </div>

            <!-- Right Column: Academic Information -->
            <div class="profile-card">
                <div class="card-title">Admission Details</div>

                <div class="info-grid-2" style="margin-bottom:1.25rem;">
                    <div>
                        <label class="form-label-sms" for="registration_no">Registration No.</label>
                        <input class="form-control-sms @error('registration_no') is-invalid @enderror" type="text" id="registration_no" name="registration_no" value="{{ old('registration_no') }}" placeholder="e.g. REG-2026-001" required>
                        @error('registration_no') <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="form-label-sms" for="enrollment_date">Enrollment Date</label>
                        <input class="form-control-sms" type="date" id="enrollment_date" name="enrollment_date" value="{{ old('enrollment_date', date('Y-m-d')) }}" required>
                    </div>
                </div>

                <div style="margin-bottom:1.25rem;">
                    <label class="form-label-sms" for="academic_year_id">Academic Year</label>
                    <select class="filter-select" id="academic_year_id" name="academic_year_id" required>
                        @foreach($academicYears as $year)
                            <option value="{{ $year->id }}" @selected(old('academic_year_id') == $year->id || $year->is_current)>{{ $year->name }} @if($year->is_current) (Current) @endif</option>
                        @endforeach
                    </select>
                </div>

                <div class="info-grid-2" style="margin-bottom:1.25rem;">
                    <div>
                        <label class="form-label-sms" for="school_class_id">Class</label>
                        <select class="filter-select" id="school_class_id" name="school_class_id" x-model="classId" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label-sms" for="section_id">Section</label>
                        <select class="filter-select" id="section_id" name="section_id" required>
                            <option value="">Select Section</option>
                            <template x-for="section in sections.filter(s => s.school_class_id == classId)" :key="section.id">
                                <option :value="section.id" x-text="section.name" :selected="section.id == '{{ old('section_id') }}'"></option>
                            </template>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom:2rem;">
                    <label class="form-label-sms" for="roll_no">Roll No.</label>
                    <input class="form-control-sms" type="text" id="roll_no" name="roll_no" value="{{ old('roll_no') }}" placeholder="e.g. 01, 15" required>
                </div>

                <div style="display:flex;gap:1rem;margin-top:2rem;">
                    <button class="btn-primary-sms" type="submit" style="flex:1;"><i class="bi bi-person-plus-fill"></i> Complete Enrollment</button>
                    <a class="btn-outline-sms" href="{{ route('admin.students.index') }}" style="flex:1;justify-content:center;">Cancel</a>
                </div>
            </div>
        </div>
    </form>
@endsection
