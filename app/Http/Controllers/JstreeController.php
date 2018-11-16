<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class JstreeController extends Controller
{
    private const EMPLOYEES_FOR_PAGINATION = 50;

    public function index()
    {
        $employees = Employee::orderBy('sort')->get();
        return  view('employees.jstree.index', compact('employees'));
    }
}
