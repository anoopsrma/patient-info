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
                @include('patient.search')
                @include('patient.modal')
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
                            <th>कार्य</th>
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
        var stocktable = $('#stocks-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                    url: '{{route('patient.datatable')}}',
                    data: function (d) {
                        d.from = $('#from').val();
                        d.to = $('#to').val();
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
                {data:'created_at', name:'created_at', width:'10%'},
                {data:'action', name:'action', width:'5%'}
            ]
        })
        $('#search-form').on('click', function(e) {
            stocktable.draw();
            e.preventDefault();
        });

         $('#patientCsv').click(function(e) {
            $('#download-to').val($('#to').val());
            $('#download-from').val($('#from').val());
            $('#download-csv').submit();
        });

        $("body").on('click', '#detail', function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            $.ajax({
                url: '{{url('/')}}'+'/patients/'+id,
                type: 'get',
                success: function(data) {
                    $('.modal-body').html(data);
                },
                error: function(data) {
                    $('.modal-body').html('Cannot Access Server');
                    console.log('failure', data);
                }
            });
        });
    });
</script>
@endsection
