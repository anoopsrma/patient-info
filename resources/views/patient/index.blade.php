@extends('layouts.app')

@section('content')
<div>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">New Patient</li>
    </ol>
<div class="container-fluid">
    <div id="ui-view"><div><div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
            <div class="card">
            <div class="card-header">
                <strong>New Patient</strong>
            </div>
            <div class="card-body">
            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="reg_no"><strong>दर्ता नं</strong></label>
                        <input class="form-control" id="reg_no" name="reg_no" type="text" required>
                </div>
                <div class="row">
                    <div class="form-group col-sm-4">
                        <label for="first_name"><strong>नाम</strong></label>
                        <input class="form-control" name="first_name" type="text" required>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="middle_name">.</label>
                        <input class="form-control" name="middle_name" type="text" required>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="last_name"><strong>थर</strong></label>
                        <input class="form-control" id="last_name" type="text" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="gender"><strong>लिङ्ग</strong></label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="">कृपया छान्नुहोस्</option>
                            <option value="male">पुरुष</option>
                            <option value="female">महिला</option>
                            <option value="other">अन्य</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="age"><strong>उमेर</strong></label>
                        <input class="form-control" name="age" type="number" min="0" step="1" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="social_indicator"><strong>जाती सन्केत</strong></label>
                        <input class="form-control" name="social_indicator" type="text" required>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="is_new"><strong>नयाँ/पुरानो</strong></label>
                        <select class="form-control" id="is_new" name="is_new" required>
                            <option value="">कृपया छान्नुहोस्</option>
                            <option value="0">नयाँ</option>
                            <option value="1">पुरानो</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address"><strong>ठेगाना</strong></label>
                        <input class="form-control" id="address" name="address" type="text" required>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="is_referred"><strong>प्रेषित</strong></label>
                        <select class="form-control" id="is_referred" name="is_referred" required>
                            <option value="">कृपया छान्नुहोस्</option>
                            <option value="1">हो</option>
                            <option value="0">होइन</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="has_id"><strong>परिचय पत्र</strong></label>
                        <select class="form-control" id="has_id" name="has_id" required>
                            <option value="">कृपया छान्नुहोस्</option>
                            <option value="1">छ</option>
                            <option value="0">छैन</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="group"><strong>लछित समुह</strong></label>
                        <input class="form-control" name="group" type="text" required>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="ward"><strong>बिभाग/वार्ड</strong></label>
                        <input class="form-control" name="ward" type="text" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-8">
                        <label for="medicine"><strong>औषधी/सेवा</strong></label>
                        <input class="form-control" name="medicine" type="text" required>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="total"><strong>रकम</strong></label>
                        <input class="form-control" name="total" type="number" min="0" step="1" required>
                    </div>
                </div>
            </form>
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
