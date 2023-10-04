@extends('layout')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid"></div>
        </section>
        <!-- Main content -->
        <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <form method="GET" name="form">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="head" value="{{ old('head',$request->head) }}" placeholder="@lang('cmn.expense_name')">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-search"></i> @lang('cmn.search')</button>
                                @if(Auth::user()->role->create)
                                <button type="button" class="btn btn-md btn-success" data-toggle="modal" data-target="#expense_add" title="Add"><i class="fa fa-plus"></i> @lang('cmn.add')</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            {{-- Expense add --}}
            <div class="modal fade" id="expense_add">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="{{ url('settings/expenses') }}"  method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h4 class="modal-title">@lang('cmn.expenses_form')</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="">@lang('cmn.expenses') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                    <input type="text" class="form-control" name="head" id="head" value="{{ old('vehicle_number')}}" placeholder="@lang('cmn.expenses')" required>
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('cmn.type')</label>
                                    <select id="expense_type_id" name="expense_type_id" class="form-control" required>
                                        <option value="1">@lang('cmn.general')</option>
                                        <option value="3">@lang('cmn.office')</option>
                                        <option value="2">@lang('cmn.project')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> @lang('cmn.close')</button>
                                <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> @lang('cmn.save')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Expense edit -->
            <div class="modal fade" id="expense_edit">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="" method="post" id="action_edit">
                            @csrf
                            @method('put')
                            <div class="modal-header">
                                <h4 class="modal-title">@lang('cmn.expenses_form')</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="">@lang('cmn.expenses') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                    <input type="text" class="form-control" name="head" id="head_edit" value="{{ old('vehicle_number')}}" placeholder="@lang('cmn.expenses')" required>
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('cmn.type')</label>
                                    <select id="expense_type_id_edit" name="expense_type_id" class="form-control" required>
                                        <option value="1">@lang('cmn.general')</option>
                                        <option value="3">@lang('cmn.office')</option>
                                        <option value="2">@lang('cmn.project')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> @lang('cmn.close')</button>
                                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> @lang('cmn.do_posting')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">

                <table class="table table-striped text-center table-hover">
                    <thead>
                        <tr>
                            <th style="width:5%">#</th>
                            <th>@lang('cmn.expense')</th>
                            <th>@lang('cmn.type')</th>
                            @if(Auth::user()->role->edit or Auth::user()->role->delete)
                            <th>@lang('cmn.action')</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody id="tablecontents">
                        @if(isset($lists))
                        @foreach($lists as $key => $list)
                        <tr class="row1" data-id="{{ $list->id }}">
                            <td class="pl-3"><i class="fa fa-sort"></i> {{ $list->id }}</td>
                            <td>{{ $list->head }}</td>
                            <td>
                                @if($list->expense_type_id == 1)
                                    @lang('cmn.general')
                                @elseif($list->expense_type_id == 2)
                                    @lang('cmn.project')
                                @else
                                    @lang('cmn.office')
                                @endif
                            </td>
                            <td>
                                @if(Auth::user()->role->edit)
                                <button type="button" class="btn btn-xs bg-gradient-primary" onclick="editData({{json_encode($list) }})" title="Edit"><i class="fas fa-edit"></i></button>
                                @endif
                                @if(Auth::user()->role->delete)
                                <button type="button" class="btn btn-xs bg-gradient-danger" onclick="return (confirm('Are you sure?'))?document.getElementById('{{$list->id}}').submit():false" title="Delete"><i class="fas fa-trash"></i></button>
                                <form id="{{$list->id}}" action="{{ url('settings/expenses',$list->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endif
                            </td>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        {{ $lists->appends(Request::input())->links() }}
    </section>
    <!-- /.content -->
</div>
@endsection
@push('js')
<script src="{{ asset('assets/plugins/js.full.min.js') }}"></script>
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

<script type="text/javascript">

    function editData(value){

        $("#expense_edit").modal('show');

        $("#head_edit").val(value.head);
        $("#expense_type_id_edit").val(value.expense_type_id);
 
        $('#action_edit').attr('action', '');
        $('#action_edit').attr('action', '/settings/expenses/' + value.id);
    }

    function submitForm(){
        document.getElementById("load_icon1").style.display = "inline-block";
        document.getElementById("show_icon1").style.display = "none";
        document.getElementById("show_btn1").disabled=true;
        event.preventDefault();
        document.getElementById('action').submit();
    }

</script>

<!-- drag drop -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script type="text/javascript">

    // drag drop related
    var xmlHttp = new XMLHttpRequest();

    $(function () {

        $("#tablecontents").sortable({
            items: "tr",
            cursor: 'move',
            opacity: 0.6,
            update: function() {
                sendOrderToServer();
            }
        });

        function sendOrderToServer(){

            var order = [];
            var token = $('meta[name="csrf-token"]').attr('content');
            $('tr.row1').each(function(index,element) {
                order.push({
                    id: $(this).attr('data-id'),
                    position: index+1
                });
            });

            $.ajax({
                type: "POST", 
                dataType: "json", 
                url: "{{ url('/settings/expense-sort') }}",
                data: {
                    order: order,
                    _token: token
                },
                success: function(response) {
                    if (response.status == "success") {
                        console.log(response);
                    } else {
                        console.log(response);
                    }
                }
            });
        }

    });
</script>
@endpush