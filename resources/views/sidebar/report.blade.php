<?php
$provinces = \App\Province::orderBy('description','asc')->get();
$keyword = Session::get('keywordReport');
$province = isset($keyword['province']) ? $keyword['province']: null;
$muncity = isset($keyword['muncity']) ? $keyword['muncity']: null;
?>
<span id="url" data-link="{{ asset('date_in') }}"></span>
<span id="token" data-token="{{ csrf_token() }}"></span>
<div class="col-md-3 wrapper">

    <div class="panel panel-jim">
        <div class="panel-heading">
            <h3 class="panel-title">Filter</h3>
        </div>
        <div class="panel-body">
            <form method="POST" action="{{ asset('report/search') }}">
                <div class="form-group">
                    <label>Province</label>
                    <select class="form-control filter_province" name="province">
                        <option value="">All Provinces</option>
                        @foreach($provinces as $row)
                            <option {{ ($row->id==$province) ? 'selected':'null' }} value="{{ $row->id }}">{{ $row->description }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Province</label>
                    <select class="form-control" name="muncity" {{ ($muncity) ? '': 'disabled' }}>
                        <div class="muncity_list">
                            <option value="">All Municipality/City</option>
                        </div>
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-success btn-block">Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>


