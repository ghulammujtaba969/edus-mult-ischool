<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    public function index(): View
    {
        $logs = ActivityLog::with('user')->latest()->paginate(20);
        return view('super-admin.audit-logs.index', compact('logs'));
    }
}
