@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="text-center">
                        @if(Auth::check())You are logged in!
                        @else
                            <p class="alert-warning">You are not logged in!</p>
                            <p class="alert-warning">Not all actions are allowed</p>
                        @endif
                        <p>
                            <a href="{{ route('jstree.index') }}" class="btn btn-success">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                EMPLOYEES
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
