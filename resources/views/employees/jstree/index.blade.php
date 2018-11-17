@extends('layouts.app')

@section('content')
    @include('employees.jstree._nav')
    <div class="container">
    <div id="employee">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-default">
                        <div class="card-header">Employee Info</div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                <tr>
                                    <th>ID</th><td id="id"></td>
                                </tr>
                                <tr class="alert alert-info">
                                    <th>Name</th><td id="name"></td>
                                </tr>
                                <tr>
                                    <th>Position</th><td id="position"></td>
                                </tr>
                                <tr>
                                    <th>Hiring Date</th><td id="hiring_date"></td>
                                </tr>
                                <tr>
                                    <th>Salary</th><td id="salary"></td>
                                </tr>
                                <tr>
                                    <th>Boss</th><td id="boss_name"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <div id="js_tree">
    </div>
</div>


@endsection

@section('scripts')
    <script>
        $('#js_tree').jstree({
            "core" : {
                "animation" : 0,
                "check_callback" : true,
                "themes" : { "stripes" : true, "variant" : "large" },
                'data' : [
                        @foreach($employees as $employee)
                            { "id" : "{{ $employee->id }}",
                              "parent" : "@if(!empty($employee->boss_id)){{ $employee->boss_id }}@else#@endif",
                              "text" : "{{$employee->id}} <strong>{{ $employee->name }}</strong>  ({{$employee->position}})(<strong>{{$employee->sort}}</string>)" , state : {opened : false, selected: false },
                            },
                        @endforeach
                ],
                'deselect_all' : false,
                "multiple" : true,
            },
            "types": {
                "#": {
                    "max_children": 1,
                    "max_depth": 5,
                    "valid_children": ["root"],
                },
                "root": {
                    "icon": "/static/3.3.7/assets/images/tree_icon.png",
                    "valid_children": ["default"],
                },
                "default": {
                    "valid_children": ["default", "file"],
                },
                // "file": {
                //     "icon": "glyphicon glyphicon-file",
                //     "valid_children": []
                // }
            },
            "plugins" : [
                "types", "dnd"
            ]
        });

        $('.card-body').hide();

        $('#js_tree').on("select_node.jstree", function (e, data) {
            axios.post('{{route('jstree.show')}}', {'nodeId': data.node.id})
                .then( function (res) {
                  if (res.data.employee.id) $('.card-body').show();
                  $('#id').text(res.data.employee.id);
                  $('#name').text(res.data.employee.name);
                  $('#position').text(res.data.employee.position);
                  $('#hiring_date').text(res.data.employee.hired_at);
                  $('#salary').text(res.data.employee.salary);
                  $('#boss_name').text(res.data.bossName);
                });
        });


        $('#js_tree').on('move_node.jstree', function (e, data)
        {
            if (data.parent == '#') data.parent =  null;
            if (data.old_parent == '#') data.old_parent =  null;

            $.post('{{ route('jstree.sort') }}',
                    { "_token": "{{ csrf_token() }}",
                        'id' : data.node.id,
                        'boss_id' : data.parent,
                        'position' : data.position,
                        'old_position' : data.old_position,
                        'old_boss' : data.old_parent
                    },
                    function(data,status,xhr){
                        console.log(status);
                    }
            )
                .fail(function () {
                    data.instance.refresh();
                });
        });

    </script>
@endsection
