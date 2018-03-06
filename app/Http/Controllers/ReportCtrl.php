<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;

use App\Http\Requests;
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
        $members = Member::orderBy('id','asc')->get();
        $data = array();
        $c=1;
        foreach($members as $row)
        {
            $mname = $row->mname;
            $mname = (strlen($row->mname)>0) ? $mname[0].'.' : '';
            $mname_e = $row->mname_e;
            $mname_e = (strlen($row->mname_e)>0) ? $mname_e[0].'.' : '';

            $picture = "C:\bhw\pictures\\".$row->url_prof;
            $signature = 'C:\bhw\signature\\'.$row->url_sig;
            $tmp_id = 'RO7-'.date('Y',strtotime($row->date_added)).'-'.str_pad(date('m',strtotime($row->date_added)),2,0,STR_PAD_LEFT).'-'.str_pad($row->id,6,0,STR_PAD_LEFT);

            $address_e = ', '.LocationCtrl::getBarangayName($row->barangay_e);
            $address_e .= ', '.LocationCtrl::getBarangayName($row->muncity_e);
            $address_e .= ', '.LocationCtrl::getBarangayName($row->province_e);

            $location = LocationCtrl::getBarangayName($row->muncity).', '.LocationCtrl::getBarangayName($row->barangay);
            $data[] = array(
                'No' => $c,
                'id' => $tmp_id,
                'name' => $row->fname.' '.$mname.' '.$row->lname.' '.$row->suffix,
                'address' => strtoupper($row->address),
                'location' => strtoupper($location),
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
                    'No','ID #', 'Name','Address','Location','Blood Type','Date of Birth','Name to Contact','Address','Contact','Picture','Signature'
                ));

            });

        })->export('xls');
    }
}
