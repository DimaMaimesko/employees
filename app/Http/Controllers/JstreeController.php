<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class JstreeController extends Controller
{
    private const EMPLOYEES_FOR_PAGINATION = 50;

    public function index()
    {
        $employees = Employee::orderBy('sort')->where('boss_id', null)->with('children')->get();
        $arrayEmployees = $employees->toArray();
        $emp = [];
        foreach ($arrayEmployees  as $key => $value){
            $emp[$key]['id'] = $value['id'];
            $emp[$key]['parent'] = '#';
            $emp[$key]['text'] = $value['name'];
            $emp[$key]['state']['opened'] = false;
            $emp[$key]['state']['selected'] = false;
        }
        session(['loadedNodes' => []]);
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
    public function addNode(Request $request)
    {
        $loadedNodes = session('loadedNodes');
        $nodeId = $request->nodeId;
        if (in_array($nodeId, $loadedNodes)){
            $enableNodeAddition = false;
        }else {
            $enableNodeAddition = true;
            $loadedNodes[] = $nodeId;
            session(['loadedNodes' => $loadedNodes]);
        }
        $employees = Employee::orderBy('sort')->with('children')->where('boss_id', $nodeId)->get()->toArray();
        if(!empty($employees)){
            foreach ($employees  as $key => $value){
                $emp1[$key]['id'] = $value['id'];
                $emp1[$key]['parent'] = $value['boss_id'];
                $emp1[$key]['text'] = '<strong>'.$value['name'].'</strong>'.' ('.$value['position'].')';
                $emp1[$key]['state']['opened'] = false;
                $emp1[$key]['state']['selected'] = false;
            }
        }else{
            $enableNodeAddition = false;
            $emp1 = [];
        }
       return response()->json([
           'emp' => $emp1,
           'enableNodeAddition' => $enableNodeAddition,
       ]);
    }

}
