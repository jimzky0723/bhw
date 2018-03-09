<div class="modal fade" role="dialog" id="filterResult">
    <div class="modal-dialog modal-sm" role="document">
        <form method="POST" action="{{ url('member/list') }}">
            <div class="modal-content">
                <div class="modal-body">
                    <fieldset>
                        <legend><i class="fa fa-filter"></i> Filter Result</legend>
                    </fieldset>
                    <div class="form-group">
                        <label>Keyword</label>
                        <input type="text" class="form-control" name="keyword" placeholder="Input keyword..." />
                    </div>
                    <div class="form-group">
                        <label>Province</label>
                        <select class="form-control filter_province" name="province">
                            <?php
                                $province = \App\Province::orderBy('description','asc')->get();
                            ?>
                            <option value="all">All Provinces</option>
                            @foreach($province as $row)
                            <option value="{{ $row->id }}">{{ $row->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Province</label>
                        <select class="form-control" name="muncity" disabled>
                            <div class="muncity_list">
                                <option value="all">All Muncity</option>
                            </div>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>ID Printed</label>
                        <select class="form-control" name="check_id">
                            <div class="muncity_list">
                                <option value="all">Both</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </div>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                    <button type="submit" class="btn btn-success btn-sm" ><i class="fa fa-search"></i> Filter</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->