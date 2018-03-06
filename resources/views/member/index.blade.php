@extends('layouts.app')

@section('content')
    <style>
        .table {
            text-transform: capitalize;
        }
        a:hover {
            text-decoration: none;
            color: #77ab59;
            font-weight: bold;
        }
        .payment{
            font-size:0.8em;
            color: #1c2d3f;
        }
        .popover-content{
            padding: 9px 25px;
        }

    </style>
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <h3 class="page-header">Member
                <small>| List</small>
            </h3>

            @if(count($records)==0)
                <div class="alert alert-warning">
                    No available data! | <a href="{{ url('member/add') }}">Add Member</a>
                </div>
            @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Gender</th>
                        <th>Date of Birth</th>
                        <th>Years in Service</th>
                        <th>Payment Status</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($records as $row)
                        <tr>
                            <td>
                                <a href="{{ asset('member/'.$row->id) }}" class="title-info" rel="popover" data-img="{{ asset('public/upload/pictures/'.$row->url_prof) }}">
                                {{ $row->lname }}, {{ $row->fname }} {{$row->mname}} {{ $row->suffix }}
                                </a>
                                <br />
                                @if($row->contact!=null)
                                <small class="text-info"><em>({{ $row->contact }})</em></small>
                                @endif
                            </td>
                            <td>
                                @if($row->address)
                                    {{ $row->address }},
                                @endif
                                {{ \App\Barangay::find($row->barangay)->description }}<br />
                                <small class="text-info">
                                    {{ \App\Muncity::find($row->muncity)->description }},
                                    {{ \App\Province::find($row->province)->description }}
                                </small>

                            </td>
                            <td>{{ $row->gender }}</td>
                            <td>{{ date('M d, Y',strtotime($row->dob)) }}</td>
                            <td>{{ $row->service_no }}</td>
                            <td class="payment">
                                <?php
                                    $reg = DB::table('payment')
                                                ->select(DB::raw('SUM(amount) as total'))
                                                ->where('member_id',$row->id)
                                                ->where('payment_code','registration')
                                                ->get();
                                    $reg = $reg[0]->total;

                                    $annual = DB::table('payment')
                                            ->select(DB::raw('SUM(amount) as total'))
                                            ->where('member_id',$row->id)
                                            ->where('payment_code','annual')
                                            ->where('year',date('Y'))
                                            ->get();
                                    $annual = $annual[0]->total;
                                ?>
                                Registration:  {{ number_format($reg,2) }}<br />
                                Annual Due (2017): {{ number_format($annual,2)}}<br />
                                <a href="#paymentModal" data-toggle="modal" class="text-info paymentStatus" data-id="{{ $row->id }}"><i class="fa fa-money"></i> Update Payment</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-center">
                    {{ $records->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
    @include('modal.payment')
@endsection

@section('js')

<?php
$status = session('status');
?>
@if($status=='added')
    <script>
        Lobibox.notify('success', {
            msg: 'Payment successfully added!'
        });
    </script>
@elseif($status=='deleted')
    <script>
        Lobibox.notify('success', {
            msg: 'Record successfully deleted!'
        });
    </script>
@endif

<script>
    $('a[rel=popover]').popover({
        html: true,
        trigger: 'hover',
        placement: 'bottom',
        content: function(){return '<img src="'+$(this).data('img') + '" width="100px" />';}
    });

    var toDelete = 0;
    var id = 0;
    $('.paymentStatus').on('click', function(){
        var btn = '';
        btn += '<button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>';
        btn += '<button type="submit" name="save" class="btn btn-success btn-sm btn-save btn-submit"><i class="fa fa-check"></i> Save</button>';

        $('.paymentFooter').html(btn);
        id = $(this).data('id');
        $('#process').val('save');
        $('#member_id').val(id);
        getPaymentStatus(id);


        $('#formPayment').submit(function(e){
            console.log('here');
            e.preventDefault();
            var data = $('#formPayment').serializeArray();
            var url = "<?php echo asset('payment/save');?>";
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function(r) {
                    getPaymentStatus(id);
                    resetForm();
                }
            });
        });


    });

    function deletePayment()
    {
        $('.delete-confirmation').removeClass('hide');
    }

    function hideConfirmation()
    {
        $('.delete-confirmation').addClass('hide');
    }

    function continueConfirmation()
    {
        $('.delete-confirmation').addClass('hide');
        var url = "<?php echo asset('payment/delete/'); ?>";
        $.ajax({
            url: url+'/'+toDelete,
            type: 'GET',
            success: function(r){
                getPaymentStatus(id);
                resetForm();
            }
        });
    }

    function resetForm()
    {
        var year = "<?php echo date('Y');?>";
        var date_payment = "<?php echo date('Y-m-d');?>";
        $('#process').val('save');
        $('#payment_code').val(null).trigger("chosen:updated");
        $('#year').val(year).trigger("chosen:updated");
        $('#amount').val(null);
        $('#OR_No').val(null);
        $('#payment_date').val(date_payment);

        var btn = '';
        btn += '<button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>';
        btn += '<button type="submit" name="save" class="btn btn-success btn-sm btn-save btn-submit"><i class="fa fa-check"></i> Save</button>';
        $('.paymentFooter').html(btn);
    }

    function getPaymentStatus(id)
    {
        var url = "<?php echo asset('payment/status'); ?>";
        var content = '';
        $.ajax({
            url: url+'/'+id,
            type: 'GET',
            success: function(data){
                jQuery.each(data, function(i,val){
                    content += '<tr>';
                    content += '<td><a href="#" data-value="'+val.code+'" data-id="'+val.id+'" class="updatePayment">'+val.payment_code+'</a><br />' +
                        '<small class="text-success">('+val.payment_date+')</small>' +
                        '</td>';
                    content += '<td>'+val.amount+'</td>';
                    content += '<td>'+val.OR_No+'</td>';
                    content += '<td>'+val.year+'</td>';
                    content += '</tr>';
                });

                if(data.length==0)
                {
                    content += '<tr>';
                    content += '<td colspan="4">No Payment History...</td>';
                    content += '</tr>';
                }
                $('#paymentStatus').html(content);

                $('.updatePayment').on('click',function(){
                    var id = $(this).data('id');
                    toDelete = id;
                    url = "<?php echo asset('payment/info/');?>";
                    $.ajax({
                        url: url+'/'+id,
                        type: 'GET',
                        success: function(info){
                            $('#payment_code').val(info.payment_code).trigger("chosen:updated");
                            $('#year').val(info.year).trigger("chosen:updated");
                            $('#amount').val(info.amount);
                            $('#OR_No').val(info.OR_No);
                            $('#payment_date').val(info.payment_date);

                            var btnUpdate = '';
                            $('#process').val('update');
                            $('#payment_id').val(info.id);
                            btnUpdate += '<button type="button" class="btn btn-success btn-sm" onclick="resetForm()"><i class="fa fa-plus"></i> Add New</button>';
                            btnUpdate += '<button type="submit" name="update" class="btn btn-info btn-sm btn-update btn-submit"><i class="fa fa-check"></i> Update</button>';
                            btnUpdate += '<a href="#" onclick="deletePayment()" data-id="'+info.id+'" class="btn btn-danger btn-sm btn-delete btn-submit"><i class="fa fa-trash"></i> Delete</a>';
                            $('.paymentFooter').html(btnUpdate);
                        }
                    });
                });

            }
        });
    }

</script>
@endsection

