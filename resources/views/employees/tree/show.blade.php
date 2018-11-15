@extends('layouts.app')

@section('content')
    @include('employees.tree._nav')

    <div class="row">
        <h5> {{$bosses ? 'Employees of:  ' . $bosses : ""}}</h5>
    </div>
    @if (count($children) > 0)
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Position</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($children as $child)
                <tr>
                    <td>{{ $child->id }}</td>
                    <td><a href="{{route('tree.show', $child->id)}}">{{ $child->name }} ({{$child->children()->count()}} employees)</a></td>
                    <td>{{ $child->position }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <h3 class="alert alert-info">{{$employee->name}} has no employees</h3>
    @endif
    {{ $children->links() }}
@endsection