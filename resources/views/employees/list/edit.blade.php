@extends('layouts.app')

@section('content')
    @include('employees.list._nav')


    <div class="row">

        <div class="col-md-4">
            <div class="img-thumbnail m-md-2">
                <a href="{{asset($employee->photo)}}">
                    <img src="{{asset($employee->photo)}}" alt="Photo" style="width:100%">

                </a>
            </div>
        </div>

    </div>
    {!! Form::open(['url' => route('list.update', $employee->id),'method'=>'PUT','autocomplete'=>'off',  'enctype'=>"multipart/form-data"]) !!}
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

    <div class="form-group">
        <label>Photo</label>
        <br>
        @if(!empty($employee->photo))
            <img src="{{asset($employee->photo)}}" alt="Photo" width="200px">
        @endif
        {!! Form::file('photo',['class'=>'form-control']) !!}
    </div>

    <button type="submit" class="btn btn-success text-uppercase"><i class="fa fa-save"></i> Update</button>

    {!! Form::close() !!}
@endsection