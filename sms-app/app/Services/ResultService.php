<?php

namespace App\Services;

use App\Models\Mark;
use App\Services\Contracts\ResultServiceInterface;

class ResultService implements ResultServiceInterface
{
    public function studentResultSummary(int $studentId): array
    {
        $marks = Mark::query()
            ->with('exam.examType', 'subject')
            ->where('student_id', $studentId)
            ->get();

        $total = $marks->sum('total_marks');
        $obtained = $marks->sum('obtained_marks');

        return [
            'records' => $marks,
            'percentage' => $total > 0 ? round(($obtained / $total) * 100, 1) : 0,
        ];
    }
}
