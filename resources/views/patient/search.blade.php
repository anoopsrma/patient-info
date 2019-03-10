<div class="row">
    <div class="form-group col-sm-1"></div>
    <div class="form-group col-sm-4">
        <label for="from"><strong>From</strong></label>
        <input class="form-control" id="from" type="date" value="{{Carbon\Carbon::now()->startOfMonth()->toDateString()}}">
    </div>
    <div class="form-group col-sm-4">
        <label for="to">To</label>
        <input class="form-control" id="to" type="date">
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
