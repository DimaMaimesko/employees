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
                                    <div id="photo" class="img-thumbnail">
                                        <a href="">
                                            <img src="" alt="Photo" style="width:100%">
                                        </a>
                                    </div>
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
                "themes" : { "stripes" : true, "variant" : "large"},
                'data' : [

                        @foreach($employees as $employee)
                            { "id" : "{{ $employee->id }}",
                              "parent" : "@if(!empty($employee->boss_id)){{ $employee->boss_id }}@else#@endif",
                              "text" : "{{$employee->id}} <strong>{{ $employee->name }}</strong>  ({{$employee->position}})" , state : {opened : false, selected: false },
                            },
                            {{--@if (isset($employee->children))--}}
                                {{--@foreach($employee->children as $child)--}}
                                    {{--{ "id" : "{{ $child->id }}",--}}
                                        {{--"parent" : "@if(!empty($child->boss_id)){{ $child->boss_id }}@else#@endif",--}}
                                        {{--"text" : "{{$child->id}} <strong>{{ $child->name }}</strong>  ({{$child->position}})" , state : {opened : false, selected: false },--}}
                                    {{--},--}}
                                {{--@endforeach--}}
                            {{--@endif--}}
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
                    "icon": "tree_icon.png",
                },
                "root": {
                    "icon": "tree_icon.png",
                    "valid_children": ["default"],
                },
                "default": {
                    "valid_children": ["default", "file"],
                    "icon": "tree_icon.png",
                },
            },
            "plugins" : [
                "types", "dnd"
            ]
        });

        $('.card-body').hide();

        $('#js_tree').on("select_node.jstree", function (e, data) {
            axios.post('{{route('jstree.add.node')}}', {'nodeId': data.node.id})
                .then( function (res) {
                    console.log(res.data.emp);
                    if (res.data.enableNodeAddition){
                        let node = $('#js_tree').jstree().get_node(data.node.id);
                        node.state.opened = true;
                        res.data.emp.forEach(function(element){
                            $('#js_tree').jstree().create_node(data.node.id, element, 'last');
                            // $("#js_tree").jstree(true).set_icon(data.node.id, "/groot.jpg");
                        })
                    }else{
                        // alert('Already loaded!');
                    }


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
            ).fail(function () {
                });
        });

        $('#js_tree').on("select_node.jstree", function (e, data) {
        axios.post('{{route('jstree.show')}}', {'nodeId': data.node.id})
            .then( function (res) {
                if (res.data.employee.id) $('.card-body').show();
                if (!res.data.employee.photo) $('#photo').hide();
                if (res.data.employee.photo) $('#photo').show();
                $('#id').text(res.data.employee.id);
                $('#name').text(res.data.employee.name);
                $('#position').text(res.data.employee.position);
                $('#hiring_date').text(res.data.employee.hired_at);
                $('#salary').text(res.data.employee.salary);
                $('#boss_name').text(res.data.bossName);
                console.log(res.data.photo);
                $('#photo a').attr("href",res.data.employee.photo);
                $('#photo a img').attr("src",res.data.employee.photo);
            });
        });

    </script>
@endsection
