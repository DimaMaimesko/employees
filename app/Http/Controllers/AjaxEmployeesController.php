<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\EmployeeCreateRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use Illuminate\Http\Request;

class AjaxEmployeesController extends Controller
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
        return  view('employees.ajaxlist.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.ajaxlist.create');
    }

    public function store(EmployeeCreateRequest $request)
    {
        $employee = Employee::create([
            'name' => $request->name,
            'position' => $request->position,
            'salary' => $request->salary,
            'boss_id' => isset($request->boss_id) ? $request->boss_id : null,
            'hired_at' => now(),
        ]);
        return redirect()->route('ajaxlist.show', $employee)->with('success','New employee created successfully!');

    }

    public function show($id)
    {
        $employee = Employee::find($id);
        return view('employees.ajaxlist.show', compact('employee'));
    }


    public function edit($id)
    {
        $employee = Employee::find($id);
        return view('employees.ajaxlist.edit', compact('employee'));
    }

    public function update(EmployeeUpdateRequest $request, $id)
    {
        $employee = Employee::find($id);
        $employee->update($request->input());
        return  redirect()->route('ajaxlist.show', $employee)->with('success','Employee ' .$employee->name . ' updated successfully!');
    }


    public function destroy($id)
    {
        $employee = Employee::find($id);
        $children =  $employee->children;
        if (count($children) == 0) {
            Employee::destroy($id);
            return redirect()->route('ajaxlist.index')->with('warning', 'Employee ' .$employee->name . ' fired!');
        }else{
           $siblings = Employee::where('boss_id', $employee->boss_id)->get();
           $sib = $siblings->mapWithKeys(function($item) {
              return [$item['id'] => $item['name']];
           });
           return view('employees.ajaxlist.redeployment',[
               'employee'   => $employee,
               'children'   => $children,
               'sib'        => $sib->all()
           ]);
        }
    }

    public function changeBoss(Request $request, $employee)
    {
        $newBossId  = $request->get('newBossId');
        $employee = Employee::find($employee);
        $children = $employee->children;
        foreach ($children as $child) {
            $child->update(['boss_id' => $newBossId]);
        }
        return redirect()->route('ajaxlist.destroy', $employee);
    }

    public function sortAsc($targetField)
    {
        $employees = Employee::orderBy($targetField, 'asc')->with('parent')->paginate(self::EMPLOYEES_FOR_PAGINATION);
        return  view('employees.ajaxlist.index', compact('employees'));
    }

    public function sortDesc($targetField)
    {
        $employees = Employee::orderBy($targetField, 'desc')->with('parent')->paginate(self::EMPLOYEES_FOR_PAGINATION);
        return  view('employees.ajaxlist.index', compact('employees'));
    }
}
