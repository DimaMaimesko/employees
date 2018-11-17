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


    public function sort(Request $request)
    {
        if ($request->boss_id != $request->old_boss) {
            Employee::where('boss_id', $request->old_boss)
                ->where('sort', '>',$request->old_position)
                ->decrement('sort');
            Employee::where('boss_id', $request->boss_id)
                ->where('sort', '>=',$request->position)
                ->increment('sort');
        } else {
            if ($request->position > $request->old_position) {
                Employee::where('boss_id', $request->boss_id)
                    ->where('sort', '>', $request->old_position)
                    ->where('sort', '<=', $request->position)
                    ->decrement('sort');
            } else {
                Employee::where('boss_id', $request->boss_id)
                    ->where('sort', '>=', $request->position)
                    ->where('sort', '<', $request->old_position)
                    ->increment('sort');
            }
        }
        Employee::find($request->id)->update([
            'sort'           => $request->position,
            'boss_id' => $request->boss_id ,
        ]);
        return response()->json(['Dima' => 'Maimesko']);
    }

    public function show(Request $request)
    {
        $employee = Employee::where('id', $request->nodeId)->with('parent')->first();
        $bossName = isset($employee->parent->name) ? $employee->parent->name : 'no boss';
        return response()->json([
            'employee' => $employee,
            'bossName' =>  $bossName
        ]);
    }
}
