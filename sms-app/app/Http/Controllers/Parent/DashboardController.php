<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\FeeInvoice;
use App\Models\Student;
use App\Models\StudentParent;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        // Get all children linked to this parent email/phone
        $children = Student::whereHas('parent', function($q) use ($user) {
            $q->where('father_phone', $user->email) // Assuming email/phone link
              ->orWhere('mother_phone', $user->email)
              ->orWhere('guardian_name', $user->name);
        })->get();

        $unpaidInvoices = FeeInvoice::whereIn('student_id', $children->pluck('id'))
            ->where('status', 'unpaid')
            ->count();

        return view('portals.parent.dashboard', compact('children', 'unpaidInvoices'));
    }
}
