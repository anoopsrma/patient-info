@extends('layouts.app')

@section('content')
<div>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">New Stock</li>
    </ol>
<div class="container-fluid">
    <div id="ui-view"><div><div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
            <form class="form-horizontal" action="{{route('stocks.store')}}" method="post">
                 @csrf
                 <input class="form-control" name="admin" value="{{Auth::user()->email}}" type="hidden">
            <div class="card">
            <div class="card-header">
                <strong>New Stock</strong>
            </div>
            <div class="card-body">
            @if (session('error'))
    <div class="alert alert-success">
        {{ session('error') }}
    </div>
@endif
                <div class="form-group">
                    <label for="name"><strong>Name</strong></label>
                        <input class="form-control" id="name" name="name" type="text" required>
                </div>
                <div class="form-group">
                    <label for="description"><strong>Description</strong></label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                </div>
                <div class="form-group">
                    <label for="type"><strong>Type</strong></label>
                    <select class="form-control" id="type" name="type" required>
                        <option value="">Please Select</option>
                        <option value="equipment">Equipment</option>
                        <option value="medicine">Medicine</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity"><strong>Quantity</strong></label>
                        <input class="form-control" name="quantity" type="number" min="0" required>
                </div>
                <div class="form-group">
                    <label for="price"><strong>Price</strong></label>
                        <input class="form-control" name="price" step="any" type="number" min="0" required>
                </div>
                <div class="form-group">
                    <label for="reg_no"><strong>Total</strong></label>
                        <input class="form-control" id="reg_no" type="text" readonly>
                </div>

            </div>
            <div class="card-footer">
                <br>
                <button class="btn btn-sm btn-primary" type="submit">
                <i class="fa fa-dot-circle-o"></i> Submit</button>
                <button class="btn btn-sm btn-danger" type="reset">
                <i class="fa fa-ban"></i> Reset</button>
                <br><br>
            </div>
            </div>
            </form>
            <br><br><br>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
    </div>
</div>
</div>
</div>
@endsection
@section('script')
<script>
        $(function() {
            console.log( "ready!" );
        });
</script>
@endsection
