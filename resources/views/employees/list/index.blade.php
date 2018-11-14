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
            <th>ID<div class="d-flex flex-column float-right"><a href="{{route('list.sortDesc', 'id')}}"><i class="fa fa-sort-asc"></i></a> <a href="{{route('list.sortAsc', 'id')}}"><i class="fa fa-sort-desc"></i></a></div></th>
            <th>Name<div class="d-flex flex-column float-right"><a href="{{route('list.sortDesc', 'name')}}"><i class="fa fa-sort-asc"></i></a> <a href="{{route('list.sortAsc', 'name')}}"><i class="fa fa-sort-desc"></i></a></div></th>
            <th>Position<div class="d-flex flex-column float-right"><a href="{{route('list.sortDesc', 'position')}}"><i class="fa fa-sort-asc"></i></a> <a href="{{route('list.sortAsc', 'position')}}"><i class="fa fa-sort-desc"></i></a></div></th>
            <th>Hiring Date<div class="d-flex flex-column float-right"><a href="{{route('list.sortDesc', 'hired_at')}}"><i class="fa fa-sort-asc"></i></a> <a href="{{route('list.sortAsc', 'hired_at')}}"><i class="fa fa-sort-desc"></i></a></div></th>
            <th>Salary<div class="d-flex flex-column float-right"><a href="{{route('list.sortDesc', 'salary')}}"><i class="fa fa-sort-asc"></i></a> <a href="{{route('list.sortAsc', 'salary')}}"><i class="fa fa-sort-desc"></i></a></div></th>
            <th>Boss name<div class="d-flex flex-column float-right"><a href="{{route('list.sortDesc', 'boss_id')}}"><i class="fa fa-sort-asc"></i></a> <a href="{{route('list.sortAsc', 'boss_id')}}"><i class="fa fa-sort-desc"></i></a></div></th>
            <th></th>
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
