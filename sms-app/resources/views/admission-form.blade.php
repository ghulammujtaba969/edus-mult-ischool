<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Admission Form | EduCore International School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --primary: #1a237e; --secondary: #303f9f; --bg: #f5f7fb; --text: #2c3e50; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background: var(--bg); color: var(--text); margin: 0; padding: 20px; }
        .form-container { max-width: 800px; margin: 40px auto; background: white; padding: 40px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .header { text-align: center; margin-bottom: 40px; }
        .header h1 { color: var(--primary); margin: 0; font-size: 2rem; }
        .header p { color: #666; margin-top: 10px; }
        .form-group { margin-bottom: 1.5rem; }
        label { display: block; font-weight: 600; margin-bottom: .5rem; font-size: .9rem; }
        .form-control { width: 100%; padding: .75rem; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem; box-sizing: border-box; }
        .form-control:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(26,35,126,0.1); }
        .btn-submit { width: 100%; padding: 1rem; background: var(--primary); color: white; border: none; border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer; transition: background 0.2s; }
        .btn-submit:hover { background: var(--secondary); }
        .alert { padding: 1rem; border-radius: 8px; margin-bottom: 2rem; text-align: center; }
        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
        @media (max-width: 600px) { .grid-2 { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="header">
            <i class="bi bi-mortarboard-fill" style="font-size: 3rem; color: var(--primary);"></i>
            <h1>Online Admission Inquiry</h1>
            <p>Complete the form below to start your child's journey with us.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admission.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Select Campus</label>
                <select name="campus_id" class="form-control" required>
                    <option value="">-- Select Campus --</option>
                    @foreach($campuses as $campus)
                        <option value="{{ $campus->id }}">{{ $campus->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>Student Full Name</label>
                    <input type="text" name="student_name" class="form-control" placeholder="Enter student's name" required>
                </div>
                <div class="form-group">
                    <label>Applying for Class</label>
                    <select name="school_class_id" class="form-control" required>
                        <option value="">-- Select Class --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Guardian / Parent Name</label>
                <input type="text" name="guardian_name" class="form-control" placeholder="Enter parent's name" required>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" class="form-control" placeholder="e.g. +92 300 1234567" required>
                </div>
                <div class="form-group">
                    <label>Email Address (Optional)</label>
                    <input type="email" name="email" class="form-control" placeholder="e.g. parent@example.com">
                </div>
            </div>

            <div class="form-group">
                <label>Residential Address</label>
                <textarea name="address" class="form-control" rows="3" placeholder="Enter your full address"></textarea>
            </div>

            <button type="submit" class="btn-submit">Submit Admission Inquiry</button>
            
            <p style="text-align: center; margin-top: 20px; font-size: .85rem; color: #999;">
                <a href="{{ route('login') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Staff Login</a>
            </p>
        </form>
    </div>
</body>
</html>
