@extends('layouts.app')

@section('content')
    @include('employees.list._nav')

    <div class="d-flex flex-row mb-3">
        <a href="{{ route('list.edit', $employee) }}" class="btn btn-primary mr-1">Edit</a>
        <form method="POST" action="{{ route('list.destroy', $employee) }}" data-confirm="Do you want to delete employee {{$employee->name}}?" class="mr-1">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Delete</button>
        </form>
    </div>
    <div class="row">

        <div class="col-md-4">
            <div class="img-thumbnail m-md-2">
                <a href="{{asset($employee->photo)}}">
                    <img src="{{asset($employee->photo)}}" alt="Photo" style="width:100%">

                </a>
            </div>
        </div>

    </div>
    <table class="table table-bordered table-striped">
        <tbody>
            <tr>
                <th>ID</th><td>{{ $employee->id }}</td>
            </tr>
            <tr>
                <th>Name</th><td>{{ $employee->name }}</td>
            </tr>
            <tr>
                <th>Position</th><td>{{ $employee->position }}</td>
            </tr>
            <tr>
                <th>Hiring Date</th><td>{{ $employee->hired_at }}</td>
            </tr>
            <tr>
                <th>Salary</th><td>{{ $employee->salary }}</td>
            </tr>
            <tr>
                <th>Boss name</th><td>{{isset($employee->parent) ? $employee->parent->name : ""}}</td>
            </tr>
        </tbody>
    </table>


@endsection

@section('scripts')
    <script>

    </script>
@endsection