@extends('layouts.app')

@section('content')
    <style>

    </style>
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <h3 class="page-header">Member
                <small>| List</small>
            </h3>
            <div class="table-responsive">
                @if($data)
                    <table class="table table-striped table-hovered">
                        <thead class="bg-primary">
                        <tr>
                            <td>ID No.</td>
                            <td>Name</td>
                            <td>Profile Picture</td>
                            <td>Signature</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $row)
                        <tr>
                            <td>{{$row->id}}</td>
                            <td>{{$row->fname}} {{ $row->mname }} {{$row->lname}} {{$row->suffix}}</td>
                            <td>{{$row->url_prof}}</td>
                            <td>{{$row->url_sig}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        {{ $data->links() }}
                    </div>
                @else
                    <div class="alert alert-warning">
                        <i class="fa fa-warning"></i> No Members!
                    </div>
                @endif
            </div>
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

