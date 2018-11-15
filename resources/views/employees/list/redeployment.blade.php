@extends('layouts.app')

@section('content')
    @include('employees.list._nav')
    <br>
    <h5 class="alert alert-danger">Before deleting employee <strong>{{$employee->name}}</strong> you should choose
            another boss for his employees: </h5>
    <br>
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Position</th>
                <th>Boss name</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($children as $child)
                <tr>
                    <td>{{ $child->id }}</td>
                    <td><a href="{{route('tree.show', $child->id)}}">{{ $child->name }} ({{$child->children()->count()}} employees)</a></td>
                    <td>{{ $child->position }}</td>
                    <td>{{ $child->parent->name }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    <label>Choose another boss: </label>
    {!! Form::open(['url' => route('list.changeboss', $employee),'method'=>'GET','autocomplete'=>'off']) !!}
        {!! Form::select('newBossId', $sib, null, ['class'=>'form-control','placeholder' => 'Pick a size...']) !!}<br>
        {!! Form::submit('Change boss', ['class' => "btn btn-info"]) !!}
    {!! Form::close() !!}

@endsection