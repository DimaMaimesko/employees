@extends('layouts.app')

@section('content')
    @include('employees.jstree._nav')


    <div class="row">
        <h1>JsTree</h1>
    </div>


<div class="container">

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

        {{--$('#js_tree').on("select_node.jstree", function (e, data) {--}}
            {{--console.log(data.node.id);--}}
            {{--window.location.href = '{{ route(', ['id' => '']) }}/' + data.node.id;--}}
        {{--});--}}

        $('#js_tree').on('move_node.jstree', function (e, data)
        {
            if (data.parent == '#'){
                data.parent =  null;
            }
            if (data.old_parent == '#'){
                data.old_parent =  null;
            }
            console.log('id: ' + data.node.id);
            console.log('boss_id: ' + data.parent);
            console.log('position: ' + data.position);
            console.log('old_position: ' + data.old_position);
            console.log('old_boss: ' + data.old_parent);
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
                        console.log(data.dima);
                    }
            )
                .fail(function () {
                    data.instance.refresh();
                });
        });

    </script>
@endsection
