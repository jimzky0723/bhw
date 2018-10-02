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
    @include('sidebar.report')
    <div class="col-md-9 wrapper">
        <div class="alert alert-jim">
            <h3 class="page-header">Report</h3>
            @if(count($data) > 0)
                <table class="table table-bordered table-striped">
                <thead class="bg-primary">
                    <tr>
                        <th width="30%">Location</th>
                        <th>Count</th>
                    </tr>
                </thead>
                <?php $total = 0 ;?>
                @foreach($data as $key => $val)
                    <?php $total += $val; ?>
                    <tr>
                        <td>{{ $key }}</td>
                        <td>{{ number_format($val,0) }}</td>
                    </tr>
                @endforeach
                <tr class="bg-success">
                    <th>TOTAL</th>
                    <th>{{ number_format($total,0) }}</th>
                </tr>
                </table>
            @else
                <div class="alert alert-warning">
                    <i class="fa fa-warning"></i> No data found.
                </div>
            @endif
        </div>
    </div>
    @include('modal.payment')
    @include('modal.filterReport')
@endsection

@section('js')
    <script>
            <?php
            $keyword = Session::get('keywordReport');

            $province = isset($keyword['province']) ? $keyword['province']: null;
            $muncity = isset($keyword['muncity']) ? $keyword['muncity']: null;
            ?>
        var id = "{{ $province }}";
        var muncity = "{{ $muncity }}";
        if(id){
            filter_muncity(id);
        }

        $('.filter_province').on('change',function(){
            var province = $(this).val();

            if(province=='')
            {
                $('select[name="muncity"]').attr('disabled',true).empty()
                    .append($('<option>', {
                        value: "",
                        text : "All Municipality/City"
                    }));
            }else{
                filter_muncity(province);
            }

        });

        function filter_muncity(id)
        {
            var link = "{{ url('location/muncitylist') }}/"+id;
            $.ajax({
                url: link,
                type: "GET",
                success: function(data){
                    $('select[name="muncity"]').attr('disabled',false)
                        .empty()
                        .append($('<option>', {
                            value: "",
                            text : "All Municipality/City"
                        }));
                    jQuery.each(data, function(i,val){
                        $('select[name="muncity"]').append($('<option>', {
                            value: val.id,
                            text : val.description
                        }));
                    });
                    $('select[name="muncity"]').val(muncity);
                }
            });
        }
    </script>
@endsection

