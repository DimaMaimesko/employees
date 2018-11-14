@extends('layouts.app')

@section('content')
    @include('employees.list._nav')

    {!! Form::open(['url' => route('list.update', $employee->id),'method'=>'PUT','autocomplete'=>'off']) !!}
    <br>
    <div class="form-group">
        <label>Employee Name</label>
        {!! Form::text('name',$employee->name,['class'=>'form-control','placeholder'=>'Employee name','required']) !!}
    </div>
    <div class="form-group">
        <label>Position</label>
        {!! Form::text('position',$employee->position,['class'=>'form-control','placeholder'=>'Position','required']) !!}
    </div>
    <div class="form-group">
        <label>Salary</label>
        {!! Form::text('salary',$employee->salary,['class'=>'form-control','placeholder'=>'Salary','required']) !!}
    </div>
    <div class="form-group">
        <label>Boss Id</label>
        {!! Form::text('boss_id',isset($employee->boss_id) ? $employee->boss_id : "",['class'=>'form-control','placeholder'=>'Boss id']) !!}
    </div>

    <button type="submit" class="btn btn-success text-uppercase"><i class="fa fa-save"></i> Update</button>

    {!! Form::close() !!}
@endsection