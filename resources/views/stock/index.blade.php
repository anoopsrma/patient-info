@extends('layouts.app')

@section('content')
<div>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Stock Table</li>
        <li>
            <a href ="{{route('stocks.create')}}" type="button" class="btn btn-sm btn-success" style="margin-left: 35px;"><i class="fa fa-plus"></i> Add New Stock</a>
        </li>
    </ol>
    <div class="container-fluid">
        <div id="ui-view"><div><div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
                <div class="row">
                    <div class="form-group col-sm-3">
                        <label for="from"><strong>From</strong></label>
                        <input class="form-control" id="from" type="date" value="{{Carbon\Carbon::now()->startOfMonth()->toDateString()}}">
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="to">To</label>
                        <input class="form-control" id="to" type="date">
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="name"><strong>Medicine</strong></label>
                        <input class="form-control" id="name" type="text">
                    </div>
                    <div class="form-group col-sm-2">
                        <button class="btn btn-sm btn-danger" id="search-form" style="margin-top: 35px;">
                        </i>Search</button>
                        <button class="btn btn-sm btn-primary" id= "stockCsv" style="margin-top: 35px;"></i>CSV</button>
                    </div>
                </div>
                {{ Form::open([
    'url'   => route("stock.csv"),
    'method' => 'post',
    'id'    => 'download-csv',
    'target' => '_blank',
    ])
}}
    {{ Form::hidden('from', null, ['id' => 'download-from']) }}
    {{ Form::hidden('to', null, ['id' => 'download-to']) }}
    {{ Form::hidden('username', null, ['id' => 'download-username']) }}

{{ Form::close() }}
                <table class="table table-responsive-sm table-striped" id="stocks-table">
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Created at</th>
                        </tr>
                    </thead>
                </table>
                </div>
            </div>
            </div>
        </div>
        </div></div></div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(function() {
        var stocktable = $('.table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                    url: '{{route('stock.datatable')}}',
                    data: function (d) {
                        d.from = $('#from').val();
                        d.to = $('#to').val();
                        d.name = $('#name').val();
                    }
                },
            order: [[6, 'desc']],
            columns: [
                {data:'id', name:'id', width:'3%'},
                {data:'name', name:'name', width:'15%'},
                {data:'description', name:'description'},
                {data:'type', name:'type', width:'10%'},
                {data:'quantity', name:'quantity', width:'5%'},
                {data:'price', name:'price', width:'5%'},
                {data:'created_at', name:'created_at', width:'15%'}
            ]
        })
        $('#search-form').on('click', function(e) {
            stocktable.draw();
            e.preventDefault();
        });

        $('#stockCsv').click(function(e) {
            $('#download-to').val($('#to').val());
            $('#download-from').val($('#from').val());
            $('#download-name').val($('#name').val());
            $('#download-csv').submit();
        });
    });
</script>
@endsection
