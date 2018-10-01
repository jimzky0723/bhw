<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class ReportCtrl extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = Member::orderBy('muncity','asc')
            ->orderBy('barangay','asc')
            ->orderBy('lname','asc')
            ->paginate(20);
        return view('report.index',[
            'data' => $data
        ]);
    }

    public function generateHome()
    {
        $data = array();
        $year = date('Y');
        for($i=1; $i<=12; $i++)
        {
            $month = str_pad($i, 2, '0', STR_PAD_LEFT);
            $start = "$year-$month-01";
            $month2 = str_pad(($i+1), 2, '0', STR_PAD_LEFT);
            $end = "$year-$month2-01";
            if($i==12)
            {
                $end = ($year+1).'-01-01';
            }
            $data['bohol'][] = self::countMember(1,$start,$end);
            $data['cebu'][] = self::countMember(2,$start,$end);
            $data['negros'][] = self::countMember(3,$start,$end);
            $data['siquijor'][] = self::countMember(4,$start,$end);
        }
        return $data;
    }

    public function countMember($province,$start,$end)
    {
        $count = Member::where('province',$province)
                ->where('date_added','>=',$start)
                ->where('date_added','<',$end)
                ->count();
        return $count;
    }


    public function generateExcel()
    {
        //$members = Member::orderBy('id','asc')->get();
        $keyword = Session::get('keyword');
        if($keyword){

            $key = isset($keyword['keyword']) ? $keyword['keyword']:null;
            $province = isset($keyword['province']) ? $keyword['province']: null;
            $muncity = isset($keyword['muncity']) ? $keyword['muncity']: null;
            $check_id = isset($keyword['check_id']) ? $keyword['check_id']: null;
            $data = Member::select('member.*')
                ->leftJoin('check_id','check_id.member_id','=','member.unique_id');
            if($key){
                $data = $data->where(function($q) use($key){
                    $q = $q->orwhere('member.fname','like',"%$key%")
                        ->orwhere('member.mname','like',"%$key%")
                        ->orwhere('member.lname','like',"%$key%");
                });
            }
            if($province && $province!='all')
            {
                $data = $data->where('member.province',$province);
            }
            if($muncity && $muncity!='all')
            {
                $data = $data->where('member.muncity',$muncity);
            }
            if($check_id==='yes')
            {
                $data = $data->where('check_id.status',1);
            }else if($check_id==='no'){
                $data = $data->where('check_id.status',0);
            }
            $record['records'] = $data->orderBy('lname','asc')
                ->get();

        }else{
            $record['records'] = Member::orderBy('lname','asc')
                ->get();
        }
        $members = $record['records'];
        $data = array();
        $c=1;
        foreach($members as $row)
        {
            $mname = $row->mname;
            $mname = (strlen($row->mname)>0) ? $mname[0].'.' : '';
            $mname_e = $row->mname_e;
            $mname_e = (strlen($row->mname_e)>0) ? $mname_e[0].'.' : '';

            $picture = "C:\bhw\pictures\\".$row->url_prof;
            $signature = 'C:\bhw\signatures\\'.$row->url_sig;
            $tmp_id = 'RO7-'.date('Y',strtotime($row->date_added)).'-'.str_pad(date('m',strtotime($row->date_added)),2,0,STR_PAD_LEFT).'-'.str_pad($row->id,6,0,STR_PAD_LEFT);

            $address_e = LocationCtrl::getBarangayName($row->barangay_e);
            $address_e .= ', '.LocationCtrl::getMuncityName($row->muncity_e);

            $location = LocationCtrl::getBarangayName($row->barangay).', '.LocationCtrl::getMuncityName($row->muncity);
            $data[] = array(
                'No' => $c,
                'id' => $tmp_id,
                'name' => $row->fname.' '.$mname.' '.$row->lname.' '.$row->suffix,
                'address' => strtoupper($row->address),
                'location' => strtoupper($location),
                'barangay' => strtoupper(LocationCtrl::getBarangayName($row->barangay)),
                'muncity' => strtoupper(LocationCtrl::getMuncityName($row->muncity)),
                'province' => strtoupper(LocationCtrl::getProvinceName($row->province)),
                'blood_type' => $row->blood_type,
                'dob' => date('M d, Y',strtotime($row->dob)),
                'name_e' => $row->fname_e.' '.$mname_e.' '.$row->lname_e.' '.$row->suffix_e,
                'address_e' => strtoupper($address_e),
                'contact_e' => $row->contact_e,
                'picture' => $picture,
                'signature' => $signature
            );
            $c++;
        }

//        print_r($data);

        Excel::create('BHW_ID_Printing', function($excel) use($data) {


            $excel->sheet('Member List', function($sheet) use($data) {

                $sheet->fromArray($data);
                $sheet->row(1, array(
                    'ID #','BHW ID', 'Name','Address','Location','Barangay','Municipal/City','Province','Blood Type','Date of Birth','Name to Contact','Address','Contact','Picture','Signature'
                ));

            });

        })->export('xls');
    }
}
