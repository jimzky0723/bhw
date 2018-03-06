<div class="modal fade" tabindex="-1" role="dialog" id="paymentModal">
    <div class="modal-dialog modal-md" role="document">
        <form method="POST" id="formPayment" action="{{ asset('payment/save') }}" class="form-submit form-horizontal">
            {{ csrf_field() }}
            <input type="hidden" name="process" id="process" value="save" />
            <div class="modal-content">
                <div class="modal-body">
                    <fieldset>
                        <legend><i class="fa fa-money"></i> Payment Status</legend>
                    </fieldset>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Payment Of:</th>
                                <th>Amount</th>
                                <th>O.R. No.</th>
                                <th>Year</th>
                            </tr>
                            </thead>
                            <tbody id="paymentStatus">
                            <tr>
                                <td colspan="4">Loading...</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <input type="hidden" id="payment_id" name="id" />
                    <input type="hidden" id="member_id" name="member_id" value="0" />
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Payment Of: </label>
                        <div class="col-sm-7">
                            <select name="payment_code" id="payment_code" class="form-control-select chosen-select" required>
                                <option value="">Select Option...</option>
                                <option value="registration">Membership/Registration Fee</option>
                                <option value="annual">Annual Dues</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Year: </label>
                        <div class="col-sm-7">
                            <select name="year" id="year" class="form-control-select chosen-select" required>
                                <option value="">Select Year...</option>
                                <?php $year = date('Y'); ?>
                                @for($i=10;$i>0;$i--)
                                    <option <?php if($year==date('Y')) echo 'selected'; ?>>{{ $year }}</option>
                                    <?php $year--; ?>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Amount Paid: </label>
                        <div class="col-sm-7">
                            <span class="input" style="padding: 0px;">
                                <input type="number" id="amount" name="amount" class="form-control-static" min="0" value="0" required />
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">O.R. No.: </label>
                        <div class="col-sm-7">
                            <span class="input" style="padding: 0px;">
                                <input type="text" id="OR_No" name="OR_No" class="form-control-static" placeholder="O.R. Number" required />
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Date of Payment: </label>
                        <div class="col-sm-7">
                            <span class="input" style="padding: 0px;">
                                <input type="date" id="payment_date" name="payment_date" class="form-control-static" value="{{ date('Y-m-d') }}" required />
                            </span>
                        </div>
                    </div>
                    <div class="alert alert-danger delete-confirmation hide">
                        Are you sure you want to delete this payment?
                        <button type="button" onclick="continueConfirmation()" class="btn btn-danger btn-sm">Continue</button>
                        <button type="button" onclick="hideConfirmation()" class="btn btn-default btn-sm">Cancel</button>
                    </div>
                </div>
                <div class="modal-footer paymentFooter">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <button type="button" class="btn btn-success btn-sm btn-save btn-submit"><i class="fa fa-check"></i> Save</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->