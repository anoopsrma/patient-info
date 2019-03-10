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
            <form class="form-horizontal" action="{{route('patients.update', $patient)}}" method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
            <div class="card-header">
                <strong>New Patient</strong>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="reg_no"><strong>दर्ता नं</strong></label>
                        <input class="form-control" id="reg_no" name="reg_no" value="{{$patient->reg_no}}" type="text" required>
                </div>
                <div class="row">
                    <div class="form-group col-sm-4">
                        <label for="first_name"><strong>नाम</strong></label>
                        <input class="form-control" name="first_name" value="{{$patient->first_name}}" type="text" required>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="middle_name">.</label>
                        <input class="form-control" name="middle_name" value="{{$patient->middle_name}}" type="text" required>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="last_name"><strong>थर</strong></label>
                        <input class="form-control" name="last_name" id="last_name" value="{{$patient->last_name}}" type="text" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="gender"><strong>लिङ्ग</strong></label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="">कृपया छान्नुहोस्</option>
                            @if($patient->gender == 'male')
                                <option value="male" selected="selected">पुरुष</option>
                            @else
                                <option value="male">पुरुष</option>
                            @endif
                            @if($patient->gender == 'female')
                                <option value="female" selected="selected">महिला</option>
                            @else
                                <option value="female">महिला</option>
                            @endif
                            @if($patient->gender == 'other')
                                <option value="other" selected="selected">अन्य</option>
                            @else
                                <option value="other">अन्य</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="age"><strong>उमेर</strong></label>
                        <input class="form-control" name="age" value="{{$patient->age}}" type="number" min="0" step="1" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="social_indicator"><strong>जाती सन्केत</strong></label>
                        <input class="form-control" name="social_indicator" value="{{$patient->social_indicator}}" type="text" required>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="is_new"><strong>नयाँ/पुरानो</strong></label>
                        <select class="form-control" id="is_new" name="is_new" required>
                            <option value="">कृपया छान्नुहोस्</option>
                            @if($patient->is_new == 1)
                                <option value="0">नयाँ</option>
                                <option value="1" selected="selected">पुरानो</option>
                            @else
                                <option value="0" selected="selected">नयाँ</option>
                                <option value="1" >पुरानो</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address"><strong>ठेगाना</strong></label>
                        <input class="form-control" id="address" name="address" value="{{$patient->address}}" type="text" required>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="is_referred"><strong>प्रेषित</strong></label>
                        <select class="form-control" id="is_referred" name="is_referred" required>
                            <option value="">कृपया छान्नुहोस्</option>
                            @if($patient->is_referred == 1)
                                <option value="1" selected="selected">हो</option>
                                <option value="0">होइन</option>
                            @else
                                <option value="1" >हो</option>
                                <option value="0" selected="selected">होइन</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="has_id"><strong>परिचय पत्र</strong></label>
                        <select class="form-control" id="has_id" name="has_id" required>
                            <option value="">कृपया छान्नुहोस्</option>
                            @if($patient->has_id ==1 )
                                <option value="1" selected="selected">छ</option>
                                <option value="0">छैन</option>
                            @else
                                <option value="1" >छ</option>
                                <option value="0" selected="selected">छैन</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="group"><strong>लछित समुह</strong></label>
                        <input class="form-control" name="group" value="{{$patient->group}}" type="text" required>
                    </div id = "ward">
                    <div class="form-group col-sm-6">
                        <label for="ward"><strong>बिभाग/वार्ड</strong></label>
                        <input class="form-control" name="ward" value="{{$patient->ward}}" type="text" required>
                    </div>
                </div>

                @foreach ($medicines as $medicine)
                <div class="row" id="medicine">
                    <div class="form-group col-sm-2">
                        <label for="medicine"><strong>औषधी/सेवा</strong></label>
                        <select class="form-control" id="type" name="type[]" required>
                            <option value="">कृपया छान्नुहोस्</option>
                            @if($medicine->type == 'medicine')
                            <option value="medicine" selected="selected">औषधी</option>
                            <option value="service">सेवा</option>
                            @else
                            <option value="medicine" >औषधी</option>
                            <option value="service" selected="selected">सेवा</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group col-sm-7">
                        <label for="medicine"><strong>औषधी/सेवा</strong></label>
                        <input class="form-control" name="medicine[]" value="{{$medicine->name}}" type="text" required>
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="price"><strong>रकम</strong></label>
                        <input class="form-control" name="price[]" value="{{$medicine->price}}" type="number" min="0" step="1" required>
                    </div>
                    <div class="form-group col-sm-1" style="margin-top: 2%;">
                        <a href="" id="add-medicine"><i class="fa fa-plus-circle fa-lg mt-4"></i></a>
                        <a href="" id="delete-medicine"><i class="fa fa-times-circle fa-lg mt-4"></i></a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="card-footer">
                <br>
                <button class="btn btn-sm btn-primary" type="submit">
                <i class="fa fa-dot-circle-o"></i> Submit</button>
                <button class="btn btn-sm btn-danger" type="reset">
                <i class="fa fa-ban"></i> Reset</button>
                <br><br>
            </div>
            </form>
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
@section('script')
    <script>
        $(function() {
            var html = '<div class="row"><div class="form-group col-sm-2"><label for="type"><strong>औषधी/सेवा</strong></label><select class="form-control" id="type" name="type[]" required><option value="">कृपया छान्नुहोस्</option><option value="medicine">औषधी</option><option value="service">सेवा</option></select></div><div class="form-group col-sm-7"><label for="medicine"><strong>औषधी/सेवा</strong></label><input class="form-control" name="medicine[]" type="text" required></div><div class="form-group col-sm-2"><label for="price"><strong>रकम</strong></label><input class="form-control" name="price[]" type="number" min="0" step="1" required></div> <div class="form-group col-sm-1" style="margin-top: 2%;"><a href="#" id="add-medicine"><i class="fa fa-plus-circle fa-lg mt-4"> </i></a> <a href="#" id="delete-medicine"><i class="fa fa-times-circle fa-lg mt-4"></i></a></div></div>';

            $( "body" ).on('click', '#add-medicine', function(e) {
                e.preventDefault();
                $(html).insertAfter("#medicine");
            });

            $( "body" ).on('click', '#delete-medicine', function(e) {
                e.preventDefault();
                $(this).parent().parent().remove();
                /*console.log($(this).parent().parent().parent());
                $(this).parent().parent().parent().remove();*/
            });
        });
    </script>
@endsection
