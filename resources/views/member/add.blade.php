<?php
    $province = App\Province::orderBy('description','asc')->get();
?>
@extends('layouts.app')

@section('content')
    <style>
        .form-control-static {
            min-height: 0px;
            padding-top: 3px;
            padding-bottom: 3px;
            padding-left: 2px;
        }
        .form-control-select {
            min-height: 0px;
            padding-top: 5px;
            padding-bottom: 5px;
            padding-left: 2px;
        }
        .table tr td {
            vertical-align: middle !important;
        }
        .attainment label {
            margin-bottom: 0px;
            font-size:0.9em;
        }
        label {
            cursor: pointer;
        }

         .label {
             color:#1c2d3f;
             font-size:0.9em;
             float:left;
             margin-top:6px;
         }
        .input {
            overflow: hidden;
            display: block;
            padding: 0 4px 0 10px
        }
        .input input {
            width: 100%;
        }
        .btn-flat {
            border-radius: 0;
            -webkit-box-shadow: none;
            -moz-box-shadow: none;
            box-shadow: none;
            border-width: 1px;
        }
        .picture {
            margin-left: 10px;
        }
        img {
            margin-bottom: 10px;
        }
    </style>
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <br />
            <br />
            <h3 class="page-header">Membership
                <small>Form</small>
            </h3>
            <form class="form-inline" action="{{ url('member/save') }}" method="POST" enctype="multipart/form-data" >
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td colspan="3" style="background: #ccc;">
                                <div class="text-center text-bold">
                                    APPLICANT INFORMATION
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <label class="label">Name :</label>
                                <input type="text" name="fname" class="form-control-static" placeholder="First Name" required/>
                                <input type="text" name="mname" class="form-control-static" placeholder="Middle Name" />
                                <input type="text" name="lname" class="form-control-static" placeholder="Last Name" required />
                                <input type="text" name="suffix" class="form-control-static" placeholder="Suffix" />
                            </td>
                        </tr>
                        <tr>
                            <td width="33%">
                                <label class="label">
                                    Birthdate:
                                </label>
                                <span class="input">
                                    <input type="date" name="dob" class="form-control-static" placeholder="mm/dd/yyyy" required/>
                                </span>
                            </td>
                            <td width="33%">
                                <label>
                                    <input type="radio" value="Male" name="gender" required> Male
                                </label>
                                <label>
                                    <input type="radio" value="Female" name="gender" required> Female
                                </label>
                            </td>
                            <td width="33%">
                                <label class="label">Contact No.:</label>
                                <span class="input">
                                    <input type="text" name="contact" class="form-control-static" placeholder="" />
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <label class="label">Address :</label>
                                <input type="text" name="address" class="form-control-static" placeholder="Address" />
                                <select name="barangay" class="form-control-select chosen-select-static" id="filterBarangay1" style="width: 15%" required>
                                    <option value="">Barangay...</option>
                                </select>
                                <select name="muncity" class="form-control-select chosen-select-static" id="filterMuncity1" style="width: 15%" required>
                                    <option value="">Municipality/City...</option>
                                </select>
                                <select name="province" class="form-control-select chosen-select-static" id="filterProvince1" style="width: 15%" required>
                                    <option value="">Province...</option>
                                    @foreach($province as $r)
                                        <option value="{{ $r->id }}">{{ $r->description }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="label">Blood Type :</label>
                                <span class="input">
                                    <input type="text" name="blood_type" class="form-control-static"/>
                                </span>
                            </td>
                            <td>
                                <label class="label">PHIC No. :</label>
                                <span class="input">
                                    <input type="text" name="phic_no" class="form-control-static"/>
                                </span>
                            </td>
                            <td rowspan="3">
                                <div class="attainment">
                                    <label>Educational Attainment:</label><br />
                                    <label class="col-sm-6">
                                        <input type="radio" value="elem_level" name="education"> Elem Level
                                    </label>
                                    <label class="col-sm-6">
                                        <input type="radio" value="college_level" name="education"> College Level
                                    </label>
                                    <label class="col-sm-6">
                                        <input type="radio" value="elem_graduate" name="education"> Elem Graduate
                                    </label>
                                    <label class="col-sm-6">
                                        <input type="radio" value="college_graduate" name="education"> College Graduate
                                    </label>
                                    <label class="col-sm-6">
                                        <input type="radio" value="highschool_level" name="education"> High School Level
                                    </label>
                                    <label class="col-sm-6">
                                        <input type="radio" value="vocational" name="education"> Vocational
                                    </label>
                                    <label class="col-sm-6">
                                        <input type="radio" value="highschool_graduate" name="education"> High School Graduate
                                    </label>
                                    <label class="col-sm-6">
                                        <input type="radio" value="others" name="education"> Others
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="label">SSS/GSIS No.:</label>
                                <span class="input">
                                    <input type="text" name="sss_gsis" class="form-control-static"/>
                                </span>
                            </td>
                            <td rowspan="2">
                                <label class="label">No. of Years in Service as BHW:</label>
                                <span class="input">
                                    <input type="number" name="service_no" class="form-control-static" min="0" value="0"/>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="label">Monthly Income :</label>
                                <span class="input">
                                    <input type="text" name="income" class="form-control-static"/>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="background: #ccc;">
                                <div class="text-center text-bold">
                                    FOR ID CARD PURPOSES
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Picture</label>
                                <div class="picture">
                                    <img id="prof_pic" src="{{ asset('public/upload/pictures/default.png') }}" width="150px" height="150px" />
                                    <input type='file' name="prof_pic" onchange="readProfURL(this);" />
                                </div>
                            </td>
                            <td colspan="2">
                                <label>Signature</label>
                                <div class="picture">
                                    <img id="signature" src="{{ asset('public/upload/signatures/default.png') }}" width="300px" height="150px" />
                                    <input type='file' name="signature" onchange="readSignatureURL(this);" />
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="3" style="background: #ccc;">
                                <div class="text-center text-bold">
                                    EMERGENCY CONTACT<br />
                                    <em>(In case of Emergency please notify...)</em>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <label class="label">Name :</label>
                                <input type="text" name="fname_e" class="form-control-static" placeholder="First Name" />
                                <input type="text" name="mname_e" class="form-control-static" placeholder="Middle Name" />
                                <input type="text" name="lname_e" class="form-control-static" placeholder="Last Name" />
                                <input type="text" name="suffix_e" class="form-control-static" placeholder="Suffix" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label class="label">Address :</label>
                                <input type="text" name="address_e" class="form-control-static" placeholder="Address" />
                                <select name="barangay_e" class="form-control-select chosen-select-static" id="filterBarangay2" style="width: 20%">
                                    <option value="">Barangay...</option>
                                </select>
                                <select name="muncity_e" class="form-control-select chosen-select-static" id="filterMuncity2" style="width: 20%">
                                    <option value="">Municipality/City...</option>
                                </select>
                                <select name="province_e" class="form-control-select chosen-select-static" id="filterProvince2" style="width: 20%">
                                    <option value="">Province...</option>
                                    @foreach($province as $r)
                                        <option value="{{ $r->id }}">{{ $r->description }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <label class="label">Contact No. :</label>
                                <span class="input">
                                    <input type="text" name="contact_e" class="form-control-static"/>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <label class="label">Relationship</label>
                                <span class="input">
                                    <input type="text" class="form-control-static" name="relation_e" />
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="background: #ccc;">
                                <div class="text-center text-bold">
                                    MEMBERSHIP BENEFITS
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <label class="label">
                                    Name of Primary Beneficiary:
                                </label>
                                <input type="text" name="fname_a" class="form-control-static" placeholder="First Name" />
                                <input type="text" name="mname_a" class="form-control-static" placeholder="Middle Name" />
                                <input type="text" name="lname_a" class="form-control-static" placeholder="Last Name" />
                                <input type="text" name="suffix_a" class="form-control-static" placeholder="Suffix" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label class="label">
                                    Relationship:
                                </label>
                                <span class="input">
                                    <input type="text" class="form-control-static" name="relation_a" />
                                </span>
                            </td>
                            <td>
                                <label class="label">
                                    Birthdate:
                                </label>
                                <span class="input">
                                    <input type="date" name="dob_a" class="form-control-static" />
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <label class="label">
                                    Name of Secondary Beneficiary:
                                </label>
                                <input type="text" name="fname_b" class="form-control-static" placeholder="First Name" />
                                <input type="text" name="mname_b" class="form-control-static" placeholder="Middle Name" />
                                <input type="text" name="lname_b" class="form-control-static" placeholder="Last Name" />
                                <input type="text" name="suffix_b" class="form-control-static" placeholder="Suffix" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label class="label">
                                    Relationship:
                                </label>
                                <span class="input">
                                    <input type="text" class="form-control-static" name="relation_b" />
                                </span>
                            </td>
                            <td>
                                <label class="label">
                                    Birthdate:
                                </label>
                                <span class="input">
                                    <input type="date" name="dob_b" class="form-control-static" />
                                </span>
                            </td>
                        </tr>
                    </table>
                    <br />
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td colspan="4" style="background: #ccc;">
                                <div class="text-center text-bold">
                                    FOR PROCESSING/PAYMENT
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>PAYMENT OF:</th>
                            <th>AMOUNT PAID</th>
                            <th>O.R. NUMBER</th>
                            <th>DATE OF PAYMENT</th>
                        </tr>
                        <tr>
                            <th>Membership/Registration Fee</th>
                            <td>
                                <span class="input">
                                    <input type="text" class="form-control-static" name="amount1" />
                                </span>
                            </td>
                            <td>
                                <span class="input">
                                    <input type="text" class="form-control-static" name="OR_no1" />
                                </span>
                            </td>
                            <td>
                                <span class="input">
                                    <input type="date" class="form-control-static" name="payment_date1" />
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Annual Dues</th>
                            <td>
                                <span class="input">
                                    <input type="text" class="form-control-static" name="amount2" />
                                </span>
                            </td>
                            <td>
                                <span class="input">
                                    <input type="text" class="form-control-static" name="OR_no2" />
                                </span>
                            </td>
                            <td>
                                <span class="input">
                                    <input type="date" class="form-control-static" name="payment_date2" />
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="pull-right">
                    <a href="{{ url('member/list') }}" class="btn btn-flat btn-default"><i class="fa fa-arrow-left"></i> List</a>
                    <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-user-plus"></i> Submit</button>
                </div>
                <div class="clearfix"></div>
            </form>
            <hr />

        </div>
    </div>

@endsection

@section('js')

    <?php
    $status = session('status');
    ?>
    @if($status=='added')
        <script>
            Lobibox.notify('success', {
                msg: 'Successfully added!'
            });
        </script>
    @endif

    <script>
        var prov = $('#filterProvince1').val();
        console.log(prov);
        $('#filterProvince1').on('change',function(){
            var id = $(this).val();
            $('#filterMuncity1').empty()
                    .append($('<option>', {
                        value: "",
                        text : "Municipality/City..."
                    }));
            var data = getMuncity(id);
            jQuery.each(data, function(i,val){
                $('#filterMuncity1').append($('<option>', {
                    value: val.id,
                    text : val.description
                }));
                $('#filterMuncity1').chosen().trigger('chosen:updated');
            });
            $('#filterBarangay1').empty()
            .append($('<option>', {
                value: "",
                text : "Barangay..."
            }));
            $('#filterBarangay1').chosen().trigger('chosen:updated');
        });

        $('#filterMuncity1').on('change',function(){
            var id = $(this).val();
            $('#filterBarangay1').empty()
                    .append($('<option>', {
                        value: "",
                        text : "Barangay..."
                    }));
            var data = getBarangay(id);
            jQuery.each(data, function(i,val){
                $('#filterBarangay1').append($('<option>', {
                    value: val.id,
                    text : val.description
                }));
                $('#filterBarangay1').chosen().trigger('chosen:updated');
            });
        });

        $('#filterProvince2').on('change',function(){
            var id = $(this).val();
            $('#filterMuncity2').empty()
                    .append($('<option>', {
                        value: "",
                        text : "Municipality/City..."
                    }));
            var data = getMuncity(id);
            jQuery.each(data, function(i,val){
                $('#filterMuncity2').append($('<option>', {
                    value: val.id,
                    text : val.description
                }));
                $('#filterMuncity2').chosen().trigger('chosen:updated');
            });
            $('#filterBarangay2').empty()
                    .append($('<option>', {
                        value: "",
                        text : "Barangay..."
                    }));
            $('#filterBarangay2').chosen().trigger('chosen:updated');
        });

        $('#filterMuncity2').on('change',function(){
            var id = $(this).val();
            $('#filterBarangay2').empty()
                    .append($('<option>', {
                        value: "",
                        text : "Barangay..."
                    }));
            var data = getBarangay(id);
            jQuery.each(data, function(i,val){
                $('#filterBarangay2').append($('<option>', {
                    value: val.id,
                    text : val.description
                }));
                $('#filterBarangay2').chosen().trigger('chosen:updated');
            });
        });

        function getMuncity(province_id)
        {
            <?php echo 'var url = "'.url('location/muncitylist/').'/";';?>
            var tmp;
            $.ajax({
                url: url+province_id,
                type: 'get',
                async: false,
                success : function(data){
                    tmp = data;
                }
            });
            return tmp;

        }

        function getBarangay(muncity_id)
        {
            <?php echo 'var url = "'.url('location/barangaylist/').'/";';?>
            var tmp;
            $.ajax({
                url: url+muncity_id,
                type: 'get',
                async: false,
                success : function(data){
                    tmp = data;
                }
            });
            return tmp;
        }

    </script>

    <script>
        function readProfURL(input)
        {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#prof_pic').attr('src', e.target.result);
                    $('#prof_pic').addClass('img-responsive');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readSignatureURL(input)
        {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#signature').attr('src', e.target.result);
                    $('#signature').addClass('img-responsive');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection

