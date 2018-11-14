<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\EmployeeCreateRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    private const EMPLOYEES_FOR_PAGINATION = 20;

    public function index(Request $request)
    {
        $query = Employee::orderBy('id');

        if (!empty($value = $request->get('id'))) {
            $query->where('id', $value);
        }
        if (!empty($value = $request->get('name'))) {
            $query->where('name', $value);
        }
        if (!empty($value = $request->get('position'))) {
            $query->where('position', $value);
        }
        if (!empty($value = $request->get('hired_at'))) {
            $query->where('hired_at', $value);
        }
        if (!empty($value = $request->get('salary'))) {
            $query->where('salary', $value);
        }
        if (!empty($value = $request->get('boss_id'))) {
            $query->where('boss_id', $value);
        }

        $employees = $query->with('parent')->paginate(self::EMPLOYEES_FOR_PAGINATION);
        return  view('employees.list.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.list.create');
    }

    public function store(EmployeeValidate $request)
    {
        $employee = Employee::create([
            'name' => $request->name,
            'position' => $request->position,
            'salary' => $request->salary,
            'boss_id' => isset($request->boss_id) ? $request->boss_id : null,
            'hired_at' => now(),
        ]);
        return redirect()->route('list.show', $employee)->with('success','New employee created successfully!');

    }

    public function show($id)
    {
        $employee = Employee::find($id);
        return view('employees.list.show', compact('employee'));
    }


    public function edit($id)
    {
        $employee = Employee::find($id);
        return view('employees.list.edit', compact('employee'));
    }

    public function update(EmployeeUpdateRequest $request, $id)
    {
        $employee = Employee::find($id);
        $employee->update($request->input());
        return  redirect()->route('list.show', $employee)->with('success','Employee ' .$employee->name . ' updated successfully!');
    }


    public function destroy($id)
    {
        $employee = Employee::find($id);
        Employee::destroy($id);
        return redirect()->route('list.index')->with('warning', 'Employee ' .$employee->name . ' fired!');
    }

    public function sortAsc($targetField)
    {
        $employees = Employee::orderBy($targetField, 'asc')->with('parent')->paginate(self::EMPLOYEES_FOR_PAGINATION);
        return  view('employees.list.index', compact('employees'));
    }

    public function sortDesc($targetField)
    {
        dump($targetField);
        $employees = Employee::orderBy($targetField, 'desc')->with('parent')->paginate(self::EMPLOYEES_FOR_PAGINATION);
        return  view('employees.list.index', compact('employees'));
    }
}
