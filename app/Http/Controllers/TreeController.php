<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class TreeController extends Controller
{
    private const EMPLOYEES_FOR_PAGINATION = 50;

    public function index()
    {
        $employees = Employee::where('boss_id',null)->with('children')->orderBy('sort')->paginate(self::EMPLOYEES_FOR_PAGINATION);
        return  view('employees.tree.index', compact('employees'));
    }

    public function showChildren(Employee $employee)
    {
        $bosses = $employee->getBosses();
        $children = $employee->children()->with('children')->orderBy('sort')->paginate(self::EMPLOYEES_FOR_PAGINATION);
        return  view('employees.tree.show', compact(['employee','children', 'bosses']));
    }
}
