@extends('layouts.app')

@section('content')
    <style>

    </style>
    @include('sidebar.report')
    <div class="col-md-9 wrapper">
        <div class="alert alert-jim">
            <h3 class="page-header">Member
                <small>| List</small>
            </h3>
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
                msg: 'Payment successfully added!'
            });
        </script>
    @endif
@endsection

