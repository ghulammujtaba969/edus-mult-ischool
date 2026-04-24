<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transcript - {{ $student->user->name }}</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; line-height: 1.6; margin: 0; padding: 40px; }
        .transcript-container { max-width: 900px; margin: 0 auto; border: 1px solid #eee; padding: 40px; box-shadow: 0 0 20px rgba(0,0,0,0.05); }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #333; padding-bottom: 20px; margin-bottom: 30px; }
        .school-info h1 { margin: 0; color: #1a237e; font-size: 24px; }
        .school-info p { margin: 5px 0; color: #666; font-size: 14px; }
        .student-details { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 40px; background: #f9f9f9; padding: 20px; border-radius: 8px; }
        .detail-item { font-size: 14px; }
        .detail-item strong { color: #555; width: 140px; display: inline-block; }
        .marks-section { margin-bottom: 40px; }
        .marks-section h2 { font-size: 18px; border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 20px; color: #1a237e; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #eee; padding: 12px; text-align: left; font-size: 14px; }
        th { background: #f5f5f5; font-weight: 700; color: #444; }
        .grade-badge { font-weight: 800; color: #1a237e; }
        .footer { margin-top: 60px; display: flex; justify-content: space-between; }
        .signature-box { border-top: 1px solid #333; width: 200px; text-align: center; padding-top: 10px; font-size: 14px; }
        @media print {
            body { padding: 0; }
            .transcript-container { border: none; box-shadow: none; width: 100%; max-width: none; }
            .no-print { display: none; }
        }
        .btn-print { background: #1a237e; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-weight: 600; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div style="text-align: center;" class="no-print">
        <button onclick="window.print()" class="btn-print">Print Transcript</button>
    </div>

    <div class="transcript-container">
        <div class="header">
            <div class="school-info">
                <h1>EDUCORE INTERNATIONAL SCHOOL</h1>
                <p>Academic Excellence & Character Building</p>
                <p>Phone: +92 300 1234567 | Email: info@educore.edu.pk</p>
            </div>
            <div style="text-align: right;">
                <h2 style="margin: 0; color: #666;">OFFICIAL TRANSCRIPT</h2>
                <p style="margin: 5px 0; font-size: 12px;">Date Issued: {{ date('M d, Y') }}</p>
            </div>
        </div>

        <div class="student-details">
            <div class="detail-item"><strong>Student Name:</strong> {{ $student->user->name }}</div>
            <div class="detail-item"><strong>Admission No:</strong> {{ $student->admission_no }}</div>
            <div class="detail-item"><strong>Class:</strong> {{ $student->schoolClass->name }}</div>
            <div class="detail-item"><strong>Section:</strong> {{ $student->section->name }}</div>
            <div class="detail-item"><strong>Academic Year:</strong> {{ $student->academicYear->name }}</div>
            <div class="detail-item"><strong>Roll Number:</strong> {{ $student->roll_no ?? '--' }}</div>
        </div>

        @forelse($marks as $examType => $examMarks)
            <div class="marks-section">
                <h2>{{ $examType }} Results</h2>
                <table>
                    <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Obtained Marks</th>
                        <th>Total Marks</th>
                        <th>Percentage</th>
                        <th>Grade</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($examMarks as $mark)
                        @php
                            $percentage = ($mark->obtained_marks / $mark->exam->total_marks) * 100;
                            $grade = $gradeScales->where('min_percent', '<=', $percentage)->first();
                        @endphp
                        <tr>
                            <td>{{ $mark->subject->name }}</td>
                            <td>{{ $mark->obtained_marks }}</td>
                            <td>{{ $mark->exam->total_marks }}</td>
                            <td>{{ number_format($percentage, 1) }}%</td>
                            <td class="grade-badge">{{ $grade->grade ?? '--' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @empty
            <div style="text-align: center; padding: 40px; color: #999; border: 1px dashed #ddd; border-radius: 8px;">
                No examination records found for this student.
            </div>
        @endforelse

        <div class="footer">
            <div class="signature-box">
                Class Teacher
            </div>
            <div class="signature-box">
                Controller of Exams
            </div>
            <div class="signature-box">
                Principal
            </div>
        </div>
    </div>
</body>
</html>
