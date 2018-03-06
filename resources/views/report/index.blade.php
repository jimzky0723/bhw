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
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Barangay</th>
                            <th>Municipality / City</th>
                            <th>Province</th>
                            <th>Blood Type</th>
                            <th>Date of Birth</th>
                            <th>Name to Contact</th>
                            <th>Address</th>
                            <th>Contact No.</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $row)
                        <tr>
                            <td>{{$row->id}}</td>
                            <td>{{$row->fname}} {{$row->mname}} {{$row->lname}} {{$row->suffix}}</td>
                            <td>{{$row->address}}</td>
                            <td>{{$row->barangay}}</td>
                            <td>{{$row->muncity}}</td>
                            <td>{{$row->province}}</td>
                            <td>{{$row->blood_type}}</td>
                            <td>{{$row->dob}}</td>
                            <td>{{$row->fname_e}} {{$row->mname_e}} {{$row->lname_e}} {{$row->suffix_e}}</td>
                            <td>{{$row->address_e}}</td>
                            <td>{{$row->contact_e}}</td>
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

