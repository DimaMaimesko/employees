@extends('layouts.app')

@section('content')
    @include('employees.jstree._nav')


    <div class="row">
        <h1>JsTree</h1>
    </div>
    <div id="jstree">
        <!-- in this example the tree is populated from inline HTML -->
        <ul>
            <li>Root node 1
                <ul>
                    <li id="child_node_1">Child node 1</li>
                    <li>Child node 2</li>
                </ul>
            </li>
            <li>Root node 2</li>
        </ul>
    </div>
    <button>demo button</button>

    </div>
<hr>
<div class="container">
    <div id="js_tree">


    </div>

</div>


@endsection

@section('scripts')
    <script>
        $(function () {
            // 6 create an instance when the DOM is ready
            $('#jstree').jstree();
            // 7 bind to events triggered on the tree
            $('#jstree').on("changed.jstree", function (e, data) {
                console.log(data.selected);
            });
            // 8 interact with the tree - either way is OK
            $('button').on('click', function () {
                $('#jstree').jstree(true).select_node('child_node_1');
                $('#jstree').jstree('select_node', 'child_node_1');
                $.jstree.reference('#jstree').select_node('child_node_1');
            });
        });


        $('#js_tree').jstree({
            "core" : {
                "animation" : 0,
                "check_callback" : true,
                "themes" : { "stripes" : true, "variant" : "large" },
                'data' : [
                        @foreach($employees as $employee)
                            { "id" : "{{ $employee->id }}",
                                "parent" : "@if(!empty($employee->boss_id)){{ $employee->boss_id }}@else#@endif",
                                "text" : "<strong>{{ $employee->name }}</strong>  ({{$employee->position}})" , state : {opened : false, selected: false },
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
                // "root": {
                //     "icon": "/static/3.3.4/assets/images/tree_icon.png",
                //     "valid_children": ["default"],
                // },
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

    </script>
@endsection
