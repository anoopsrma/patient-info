@extends('layouts.app')

@section('content')
<div>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Stock Table</li>
        <li>
            <a href ="{{route('patients.create')}}" type="button" class="btn btn-sm btn-success" style="margin-left: 35px;"><i class="fa fa-plus"></i> Add New Patient</a>
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
                            <th>#</th>
                            <th>दर्ता नं</th>
                            <th>नाम</th>
                            <th>लिङ्ग</th>
                            <th>उमेर</th>
                            <th>जाती सन्केत</th>
                            <th>नयाँ/पुरानो</th>
                            <th>ठेगाना</th>
                            <th>प्रेषित</th>
                            <th>परिचय पत्र</th>
                            <th>लछित समुह</th>
                            <th>आएको मिती</th>
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
                    url: '{{route('patient.datatable')}}',
                    data: function (d) {
                        d.from = $('#from').val();
                        d.to = $('#to').val();
                        d.name = $('#name').val();
                    }
                },
            order: [[0, 'asc']],
            columns: [
                {data:'id', name:'id', width:'3%'},
                {data:'reg_no', name:'reg_no', width:'5%'},
                {data:'name', name:'name', width:'10%'},
                {data:'gender', name:'gender', width:'5%'},
                {data:'age', name:'age', width:'5%'},
                {data:'social_indicator', name:'social_indicator', width:'5%'},
                {data:'is_new', name:'is_new', width:'5%'},
                {data:'address', name:'address', width:'15%'},
                {data:'is_referred', name:'is_referred', width:'5%'},
                {data:'has_id', name:'has_id', width:'5%'},
                {data:'group', name:'group', width:'5%'},
                {data:'created_at', name:'created_at', width:'10%'}
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
