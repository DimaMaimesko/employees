@extends('layouts.app')

@section('content')
    @include('employees.list._nav')


    <div class="row">
        <div class="col-6 col-md-8 col-lg-10">
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <p>
                <a href="{{route('list.create')}}" class="btn btn-success text-uppercase">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    Add New Employee
                </a>
            </p>
        </div>
    </div>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Position</th>
            <th>Hiring Date</th>
            <th>Salary</th>
            <th>Boss name</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($employees as $employee)
            <tr>
                <td>{{ $employee->id }}</td>
                <td><a href="{{route('list.show', $employee->id)}}">{{ $employee->name }}</a></td>
                <td>{{ $employee->position }}</td>
                <td>{{ $employee->hired_at }}</td>
                <td>{{ $employee->salary }}</td>
                <td> {{$employee->parent ? $employee->parent->name : ""}}</td>
                <td>
                    {{--<div class="d-flex flex-row">--}}
                        {{--<form method="POST" action="{{ route('admin.regions.first', $region) }}" class="mr-1">--}}
                            {{--@csrf--}}
                            {{--<button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-up"></span></button>--}}
                        {{--</form>--}}
                        {{--<form method="POST" action="{{ route('admin.regions.up', $region) }}" class="mr-1">--}}
                            {{--@csrf--}}
                            {{--<button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-up"></span></button>--}}
                        {{--</form>--}}
                        {{--<form method="POST" action="{{ route('admin.regions.down', $region) }}" class="mr-1">--}}
                            {{--@csrf--}}
                            {{--<button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-down"></span></button>--}}
                        {{--</form>--}}
                        {{--<form method="POST" action="{{ route('admin.regions.last', $region) }}" class="mr-1">--}}
                            {{--@csrf--}}
                            {{--<button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-down"></span></button>--}}
                        {{--</form>--}}
                    {{--</div>--}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $employees->links() }}
@endsection
