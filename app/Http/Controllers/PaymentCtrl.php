<?php

namespace App\Http\Controllers;

use Faker\Provider\el_GR\Payment;
use Illuminate\Http\Request;
use App\Payment as Pay;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class PaymentCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function status($id)
    {
        $data = Pay::where('member_id',$id)
                ->orderBy('payment_code','desc')
                ->orderBy('payment_date','desc')
                ->get();
        $raw = array();
        foreach($data as $row)
        {
            if($row->amount){
                $newdate = date('M d, Y',strtotime($row->payment_date));
                if($row->payment_date=='0000-00-00')
                {
                    $newdate = 'Invalid Date';
                }
                $code = 'Membership/Registration Fee';
                if($row->payment_code==='annual')
                {
                    $code = 'Annual Dues';
                }
                $raw[] = array(
                    'id' => $row->id,
                    'code' => $row->payment_code,
                    'member_id' => $row->member_id,
                    'payment_date' => $newdate,
                    'payment_code' => $code,
                    'amount' => number_format($row->amount,2),
                    'OR_No' => $row->OR_No,
                    'year' => $row->year
                );
            }
        }
        return $raw;
    }

    public function savePayment(Request $req)
    {
        $process = $req->process;

        if($process=='save')
        {
            DB::table('payment')->insert([
                'member_id' => $req->member_id,
                'payment_code' => $req->payment_code,
                'amount' => $req->amount,
                'OR_No' => $req->OR_No,
                'year' => $req->year,
                'payment_date' => $req->payment_date,
                'added_by' => Auth::user()->id,
                'date_added' => date('Y-m-d H:i:s')
            ]);
            return redirect()->back()->with('status','added');
        }else{
            self::updatePayment($req);
        }

    }

    public function updatePayment($req)
    {
        $data = array(
            'payment_code' => $req->payment_code,
            'amount' => $req->amount,
            'OR_No' => $req->OR_No,
            'year' => $req->year,
            'payment_date' => $req->payment_date,
            'added_by' => Auth::user()->id
        );
        $id = $req->id;
        Pay::where('id',$id)
            ->update($data);
    }

    public function info($id)
    {
        $info = Pay::where('id',$id)
            ->first();
        return $info;
    }

    public function delete($id){
        Pay::where('id',$id)
            ->delete();
    }
}
