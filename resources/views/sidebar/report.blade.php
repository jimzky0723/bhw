
<span id="url" data-link="{{ asset('date_in') }}"></span>
<span id="token" data-token="{{ csrf_token() }}"></span>
<div class="col-md-3 wrapper">

    <div class="panel panel-jim">
        <div class="panel-heading">
            <h3 class="panel-title">Filter</h3>
        </div>
        <div class="panel-body">
            <form class="form-inline" method="POST" action="{{ asset('report/generate') }}">
                {{ csrf_field() }}
                <table width="100%">
                    <tr>
                        <td>
                            <label>Label</label>
                            <div class="input-group col-xs-12">

                            </div>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>


