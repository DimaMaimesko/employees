@extends('layouts.app')

@section('content')
    @include('employees.ajaxlist._nav')

    {!! Form::open(['url' => route('ajaxlist.store'),'method'=>'POST','autocomplete'=>'off']) !!}
    <br>
    <div class="form-group">
        <label>Employee Name</label>
        {!! Form::text('name',old('name'),['class'=>'form-control','placeholder'=>'Employee name','required']) !!}
    </div>
    <div class="form-group">
        <label>Position</label>
        {!! Form::text('position',old('position'),['class'=>'form-control','placeholder'=>'Position','required']) !!}
    </div>
    <div class="form-group">
        <label>Salary</label>
        {!! Form::text('salary',old('salary'),['class'=>'form-control','placeholder'=>'Salary','required']) !!}
    </div>
    <div class="form-group">
        <label>Boss Id</label>
        {!! Form::text('boss_id',isset($boss_id) ? $boss_id : old('boss_id'),['class'=>'form-control','placeholder'=>'Boss id']) !!}
    </div>

    <button type="submit" class="btn btn-success text-uppercase"><i class="fa fa-save"></i> Save</button>

    {!! Form::close() !!}
@endsection