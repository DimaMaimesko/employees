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


    <show-list :employees="{{json_encode($employees)}}" :pages="{{$pages}}"></show-list>

@endsection

@section('scripts')
    <script>

    </script>
@endsection

