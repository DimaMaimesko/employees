@extends('layouts.app')

@section('content')
    @include('employees.tree._nav')


    <div class="row">
    </div>

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Position</th>

            </tr>
            </thead>
            <tbody>
            @foreach ($employees as $employee)
                <tr>
                    <td>{{ $employee->id }}</td>
                    <td><a href="{{route('tree.show', $employee)}}">
                            {{ $employee->name }} ({{$employee->children()->count()}} employees)
                        </a>
                    </td>
                    <td>{{ $employee->position }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    {{ $employees->links() }}
@endsection
