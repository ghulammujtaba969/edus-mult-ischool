<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DomainController extends Controller
{
    public function index(): View
    {
        $domains = Domain::with('school')->latest()->paginate(10);
        return view('super-admin.domains.index', compact('domains'));
    }
}
