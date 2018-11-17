@extends('layouts.app')

@section('content')
    @include('employees.ajaxlist._nav')


    <div class="row">
        <div class="col-6 col-md-8 col-lg-10">
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <p>
                <a href="{{route('ajaxlist.create')}}" class="btn btn-success text-uppercase">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    Add New Employee
                </a>
            </p>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">Filter</div>
        <div class="card-body">
            <form action="{{route('ajaxlist.index')}}" method="GET">
                <div class="row">
                        <div class="form-group" style="width:5%;">
                            <label for="id" class="col-form-label">ID</label>
                            <input id="id" class="form-control" name="id" value="{{ request('id') }}">
                        </div>
                        <div class="form-group" style="width:20%;">
                            <label for="name" class="col-form-label">Name</label>
                            <input id="name" class="form-control" name="name" value="{{ request('name') }}">
                        </div>
                        <div class="form-group"  style="width:25%;">
                            <label for="position" class="col-form-label">Position</label>
                            <input id="position" class="form-control" name="position" value="{{ request('position') }}">
                        </div>
                        <div class="form-group" style="width:20%;">
                            <label for="hired_at" class="col-form-label">Hired at</label>
                            <input id="hired_at" class="form-control" name="hired_at" value="{{ request('hired_at') }}">
                        </div>
                        <div class="form-group" style="width:5%;">
                            <label for="salary" class="col-form-label">Salary</label>
                            <input id="salary" class="form-control" name="salary" value="{{ request('salary') }}">
                        </div>
                        <div class="form-group"  style="width:15%;">
                            <label for="boss_id" class="col-form-label">Boss Id</label>
                            <input id="boss_id" class="form-control" name="boss_id" value="{{ request('boss_id') }}">
                        </div>
                        <div class="form-group"  style="width:10%;">
                            <label class="col-form-label">&nbsp;</label><br />
                            <button type="submit" class="btn btn-primary">Search</button>
                            <a href="?" class="btn btn-outline-secondary">Clear</a>
                        </div>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th style="width:5%;">ID<div class="d-flex flex-column float-right"><a href="{{route('ajaxlist.sortDesc', 'id')}}"><i class="fa fa-sort-asc"></i></a> <a href="{{route('ajaxlist.sortAsc', 'id')}}"><i class="fa fa-sort-desc"></i></a></div></th>
            <th style="width:20%;">Name<div class="d-flex flex-column float-right"><a href="{{route('ajaxlist.sortDesc', 'name')}}"><i class="fa fa-sort-asc"></i></a> <a href="{{route('ajaxlist.sortAsc', 'name')}}"><i class="fa fa-sort-desc"></i></a></div></th>
            <th style="width:25%;">Position<div class="d-flex flex-column float-right"><a href="{{route('ajaxlist.sortDesc', 'position')}}"><i class="fa fa-sort-asc"></i></a> <a href="{{route('ajaxlist.sortAsc', 'position')}}"><i class="fa fa-sort-desc"></i></a></div></th>
            <th style="width:20%;">Hiring Date<div class="d-flex flex-column float-right"><a href="{{route('ajaxlist.sortDesc', 'hired_at')}}"><i class="fa fa-sort-asc"></i></a> <a href="{{route('ajaxlist.sortAsc', 'hired_at')}}"><i class="fa fa-sort-desc"></i></a></div></th>
            <th style="width:5%;">Salary<div class="d-flex flex-column float-right"><a href="{{route('ajaxlist.sortDesc', 'salary')}}"><i class="fa fa-sort-asc"></i></a> <a href="{{route('ajaxlist.sortAsc', 'salary')}}"><i class="fa fa-sort-desc"></i></a></div></th>
            <th style="width:15%;">Boss name<div class="d-flex flex-column float-right"><a href="{{route('ajaxlist.sortDesc', 'boss_id')}}"><i class="fa fa-sort-asc"></i></a> <a href="{{route('ajaxlist.sortAsc', 'boss_id')}}"><i class="fa fa-sort-desc"></i></a></div></th>
            <th style="width:10%;"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($employees as $employee)
            <tr>
                <td>{{ $employee->id }}</td>
                <td><a href="{{route('ajaxlist.show', $employee->id)}}">{{ $employee->name }}</a></td>
                <td>{{ $employee->position }}</td>
                <td>{{ $employee->hired_at }}</td>
                <td>{{ $employee->salary }}</td>
                <td> {{$employee->parent ? $employee->parent->name : ""}}</td>

            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $employees->links() }}
@endsection
